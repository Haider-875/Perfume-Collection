<?php

namespace App\Services;

use App\Mail\OrderPlacedMail;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\PaymentGateways\PaymentGatewayManager;
use App\Services\PaymentGateways\PaymentResult;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    public function __construct(
        protected CartService $cartService,
        protected PaymentGatewayManager $paymentGatewayManager
    ) {}

    /**
     * Generate unique luxury order number in PC-100XXX format
     */
    public function generateOrderNumber(): string
    {
        do {
            $number = 'PC-' . rand(100100, 999900);
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }

    /**
     * Create Order within a database transaction
     */
    public function createOrder(Cart $cart, array $data, ?int $userId = null): array
    {
        if ($cart->items->isEmpty()) {
            throw new Exception('Your fragrance bag is empty.');
        }

        $paymentMethodKey = $data['payment_method'] ?? 'cod';
        $paymentGateway = $this->paymentGatewayManager->get($paymentMethodKey);

        return DB::transaction(function () use ($cart, $data, $userId, $paymentMethodKey, $paymentGateway) {
            // 1. Stock check & decrement
            foreach ($cart->items as $item) {
                if ($item->product_variant_id) {
                    $variant = ProductVariant::lockForUpdate()->find($item->product_variant_id);
                    if ($variant && $variant->stock < $item->quantity) {
                        throw new Exception("Insufficient stock for {$item->product->name} ({$variant->size_label}). Available: {$variant->stock}");
                    }
                    if ($variant) {
                        $variant->decrement('stock', $item->quantity);
                    }
                } elseif ($item->product_id) {
                    $product = Product::lockForUpdate()->find($item->product_id);
                    if ($product && $product->stock < $item->quantity) {
                        throw new Exception("Insufficient stock for {$product->name}. Available: {$product->stock}");
                    }
                    if ($product) {
                        $product->decrement('stock', $item->quantity);
                    }
                }
            }

            // 2. Financials
            $subtotal = $cart->subtotal;
            $discountAmount = $cart->discount_amount;
            $couponCode = $cart->coupon_code;
            $shippingCost = $this->cartService->calculateShipping($cart, $data['city'] ?? null);
            $totalAmount = max(0, $subtotal - $discountAmount + $shippingCost);

            // 3. Create Order
            $orderNumber = $this->generateOrderNumber();
            
            $initialOrderStatus = match ($paymentMethodKey) {
                'cod' => 'confirmed',
                'bank_transfer', 'wallet_transfer' => 'pending_verification',
                default => 'pending',
            };

            $initialPaymentStatus = match ($paymentMethodKey) {
                'cod' => 'unpaid',
                'bank_transfer', 'wallet_transfer' => 'pending_verification',
                default => 'pending',
            };

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $userId ?? auth()->id(),
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'customer_phone' => $data['customer_phone'],
                'shipping_address' => $data['shipping_address'],
                'area' => $data['area'] ?? null,
                'landmark' => $data['landmark'] ?? null,
                'city' => $data['city'],
                'province' => $data['province'] ?? 'Punjab',
                'postal_code' => $data['postal_code'] ?? null,
                'order_notes' => $data['order_notes'] ?? null,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'coupon_code' => $couponCode,
                'shipping_cost' => $shippingCost,
                'total_amount' => $totalAmount,
                'payment_method' => $paymentMethodKey,
                'payment_status' => $initialPaymentStatus,
                'order_status' => $initialOrderStatus,
                'bank_transaction_id' => $data['transaction_id'] ?? null,
                'is_whatsapp_order' => false,
            ]);

            // 4. Create Order Items snapshot
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'bundle_id' => $item->bundle_id,
                    'product_name' => $item->bundle ? $item->bundle->name : $item->product->name,
                    'variant_label' => $item->variant ? $item->variant->size_label : ($item->bundle ? 'Curated Bundle' : $item->product->volume_ml . 'ml Flacon'),
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'total' => $item->price * $item->quantity,
                ]);
            }

            // 5. Increment coupon usage if used
            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->first();
                if ($coupon) {
                    $coupon->increment('used_count');
                }
            }

            // 6. Initiate Gateway Payment
            $paymentResult = $paymentGateway->initiate($order, $data);

            // 7. Update order with payment results (e.g. receipt image, transaction ID)
            if ($paymentResult->receiptImage) {
                $order->payment_receipt = $paymentResult->receiptImage;
            }
            if ($paymentResult->transactionId && !$order->bank_transaction_id) {
                $order->bank_transaction_id = $paymentResult->transactionId;
            }
            $order->save();

            // 8. Log Payment record in payments table
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $paymentMethodKey,
                'amount' => $order->total_amount,
                'transaction_id' => $paymentResult->transactionId,
                'gateway_reference' => $paymentResult->transactionId,
                'gateway_response' => json_encode($paymentResult->rawResponse),
                'receipt_image' => $paymentResult->receiptImage,
                'status' => $paymentResult->status,
                'notes' => $paymentResult->message,
            ]);

            // 9. Clear cart
            $this->cartService->clearCart($cart);

            // 10. Send queued order confirmation email (safe catch)
            try {
                if (filter_var($order->customer_email, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($order->customer_email)->queue(new OrderPlacedMail($order));
                }
            } catch (\Exception $e) {
                Log::warning('Order confirmation email queueing failed: ' . $e->getMessage());
            }

            return [
                'order' => $order,
                'payment_result' => $paymentResult,
            ];
        });
    }

    /**
     * Mark order as paid when gateway callback or webhook confirms payment
     */
    public function markOrderPaid(Order $order, string $transactionId, array $gatewayResponse = []): void
    {
        DB::transaction(function () use ($order, $transactionId, $gatewayResponse) {
            $order->payment_status = 'paid';
            $order->order_status = 'confirmed';
            $order->bank_transaction_id = $transactionId;
            $order->save();

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $order->payment_method,
                'amount' => $order->total_amount,
                'transaction_id' => $transactionId,
                'gateway_reference' => $transactionId,
                'gateway_response' => json_encode($gatewayResponse),
                'status' => 'paid',
                'notes' => 'Payment verified by gateway callback/webhook.',
            ]);
        });
    }
}
