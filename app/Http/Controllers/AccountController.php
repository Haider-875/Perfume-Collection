<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Review;
use App\Models\Wishlist;
use App\Services\PakistanGeoService;
use App\Services\PaymentGateways\BankTransferGateway;
use App\Services\PaymentGateways\WalletTransferGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AccountController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $recentOrders = $user->orders()->with('items')->take(3)->get();
        $totalOrdersCount = $user->orders()->count();
        $totalSpent = $user->orders()->whereIn('payment_status', ['paid', 'unpaid', 'pending_verification'])->sum('total_amount');
        $defaultAddress = $user->addresses()->where('is_default', true)->first() ?? $user->addresses()->first();
        $wishlistCount = $user->wishlists()->count();

        return view('account.dashboard', compact(
            'user',
            'recentOrders',
            'totalOrdersCount',
            'totalSpent',
            'defaultAddress',
            'wishlistCount'
        ));
    }

    public function orders(Request $request)
    {
        $user = Auth::user();
        $status = $request->input('status');

        $query = $user->orders()->with('items')->latest();

        if ($status && $status !== 'all') {
            $query->where('order_status', $status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('account.orders', compact('user', 'orders', 'status'));
    }

    public function orderDetail(string $orderNumber)
    {
        $user = Auth::user();
        $order = $user->orders()->with(['items.product', 'items.variant', 'items.bundle'])->where('order_number', $orderNumber)->firstOrFail();

        $bankGateway = new BankTransferGateway();
        $bankDetails = $bankGateway->getBankDetails();

        $walletGateway = new WalletTransferGateway();
        $walletDetails = $walletGateway->getWalletDetails();

        return view('account.order-detail', compact('user', 'order', 'bankDetails', 'walletDetails'));
    }

    public function uploadReceipt(Request $request, string $orderNumber)
    {
        $user = Auth::user();
        $order = $user->orders()->where('order_number', $orderNumber)->firstOrFail();

        $request->validate([
            'transaction_id' => ['nullable', 'string', 'max:100'],
            'receipt_file' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
        ]);

        if ($request->hasFile('receipt_file')) {
            $file = $request->file('receipt_file');
            $filename = 'account_receipt_' . $order->order_number . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            $destinationPath = public_path('uploads/receipts');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            $file->move($destinationPath, $filename);
            $receiptPath = 'uploads/receipts/' . $filename;

            $order->payment_receipt = $receiptPath;
            if ($request->input('transaction_id')) {
                $order->bank_transaction_id = $request->input('transaction_id');
            }
            $order->payment_status = 'pending_verification';
            $order->order_status = 'pending_verification';
            $order->save();

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $order->payment_method,
                'amount' => $order->total_amount,
                'transaction_id' => $order->bank_transaction_id,
                'receipt_image' => $receiptPath,
                'status' => 'pending_verification',
                'notes' => 'Customer uploaded payment receipt via account portal.',
            ]);

            return back()->with('success', 'Payment proof attached successfully. Our finance concierge has received your receipt for verification.');
        }

        return back()->with('error', 'Please upload a valid screenshot/receipt image.');
    }

    public function addresses()
    {
        $user = Auth::user();
        $addresses = $user->addresses()->latest()->get();
        $provinces = PakistanGeoService::getProvinces();

        return view('account.addresses', compact('user', 'addresses', 'provinces'));
    }

    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'regex:/^((\+92)|(0092)|(0))?3[0-9]{2}[0-9]{7}$/'],
            'street_address' => ['required', 'string', 'max:300'],
            'city' => ['required', 'string', 'max:100'],
            'province' => ['required', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        $user = Auth::user();
        $isDefault = $request->boolean('is_default') || $user->addresses()->count() === 0;

        if ($isDefault) {
            $user->addresses()->update(['is_default' => false]);
        }

        $user->addresses()->create([
            'recipient_name' => $validated['recipient_name'],
            'phone' => $validated['phone'],
            'street_address' => $validated['street_address'],
            'city' => $validated['city'],
            'province' => $validated['province'],
            'postal_code' => $validated['postal_code'] ?? null,
            'is_default' => $isDefault,
        ]);

        return back()->with('success', 'Delivery address saved to your luxury profile.');
    }

    public function deleteAddress($id)
    {
        $address = Auth::user()->addresses()->where('id', $id)->firstOrFail();
        $address->delete();

        return back()->with('success', 'Address removed successfully.');
    }

    public function setDefaultAddress($id)
    {
        $user = Auth::user();
        $user->addresses()->update(['is_default' => false]);
        $user->addresses()->where('id', $id)->update(['is_default' => true]);

        return back()->with('success', 'Primary delivery address updated.');
    }

    public function wishlist()
    {
        $user = Auth::user();
        $wishlistItems = $user->wishlists()->with('product.category', 'product.images', 'product.variants')->latest()->get();

        return view('account.wishlist', compact('user', 'wishlistItems'));
    }

    public function toggleWishlist(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false, 
                'message' => 'Please sign in to save creations to your private wishlist.',
                'redirect' => route('login')
            ], 401);
        }

        $productId = $request->input('product_id');
        $product = Product::findOrFail($productId);
        $user = Auth::user();

        $existing = Wishlist::where('user_id', $user->id)->where('product_id', $productId)->first();

        if ($existing) {
            $existing->delete();
            $inWishlist = false;
            $message = "{$product->name} removed from your wishlist.";
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            $inWishlist = true;
            $message = "{$product->name} preserved in your luxury wishlist.";
        }

        return response()->json([
            'success' => true,
            'in_wishlist' => $inWishlist,
            'count' => $user->wishlists()->count(),
            'message' => $message,
        ]);
    }

    public function reviews()
    {
        $user = Auth::user();
        $reviews = $user->reviews()->with('product')->latest()->get();

        // Find products purchased by this user that haven't been reviewed yet
        $purchasedProductIds = OrderItem::whereHas('order', function($q) use ($user) {
            $q->where('user_id', $user->id)->whereIn('order_status', ['confirmed', 'packed', 'shipped', 'delivered']);
        })->pluck('product_id')->unique()->filter();

        $unreviewedProducts = Product::whereIn('id', $purchasedProductIds)
            ->whereNotIn('id', $reviews->pluck('product_id'))
            ->get();

        return view('account.reviews', compact('user', 'reviews', 'unreviewedProducts'));
    }

    public function storeReview(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title' => ['nullable', 'string', 'max:150'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        // Check if verified purchase
        $hasPurchased = OrderItem::whereHas('order', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('product_id', $validated['product_id'])->exists();

        Review::create([
            'product_id' => $validated['product_id'],
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'customer_city' => $user->city ?? 'Lahore',
            'rating' => $validated['rating'],
            'title' => $validated['title'] ?? null,
            'comment' => $validated['comment'],
            'verified_purchase' => $hasPurchased,
            'is_approved' => true,
        ]);

        return back()->with('success', 'Thank you for documenting your olfactory review. It is now published.');
    }
}
