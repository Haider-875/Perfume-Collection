<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('badge_text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Collections (Exclusive, Men, Women, Unisex, Bundles, Collaborations)
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('badge_text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Brands / Signature Houses
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('origin_country')->default('France / Orient');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Fragrance Families
        Schema::create('fragrance_families', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('accent_color')->default('#D4AF37');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        // 5. Scent Notes Master
        Schema::create('scent_notes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('default_layer', ['top', 'heart', 'base'])->default('heart');
            $table->string('aroma_family')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 6. Products Table
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('fragrance_family_id')->nullable()->constrained()->nullOnDelete();
            
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('tagline')->nullable();
            
            $table->string('concentration')->default('Extrait de Parfum');
            $table->enum('gender', ['Unisex', 'Men', 'Women'])->default('Unisex');
            $table->integer('volume_ml')->default(100);
            
            $table->decimal('price', 10, 2); // In PKR
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->decimal('compare_at_price', 10, 2)->nullable();
            $table->integer('stock')->default(25);
            $table->boolean('in_stock')->default(true);
            
            // Olfactory Metrics
            $table->string('longevity')->default('14+ Hours');
            $table->string('sillage')->default('Heavy / Room Filling');
            $table->string('season')->default('All Seasons / Evening');
            $table->string('time_of_day')->default('Evening & Signature');
            
            // Scent Notes Breakdown
            $table->string('top_notes_summary')->nullable();
            $table->string('heart_notes_summary')->nullable();
            $table->string('base_notes_summary')->nullable();
            
            // Descriptions & Stories
            $table->text('story')->nullable();
            $table->longText('description')->nullable();
            $table->text('application_guide')->nullable();
            $table->text('ingredients')->nullable();
            
            // Flags
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('is_new_arrival')->default(false);
            $table->boolean('is_limited_edition')->default(false);
            $table->boolean('is_bundle')->default(false);
            $table->boolean('is_collaboration')->default(false);
            $table->boolean('is_active')->default(true);
            
            // Stats
            $table->decimal('rating_avg', 3, 2)->default(5.00);
            $table->integer('reviews_count')->default(0);
            $table->integer('views_count')->default(0);
            
            // Media
            $table->string('thumbnail_image');
            $table->string('hover_image')->nullable();
            $table->string('lifestyle_image')->nullable();
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->index(['gender', 'is_active']);
            $table->index(['is_bestseller', 'is_active']);
            $table->index(['is_featured', 'is_active']);
            $table->index('price');
        });

        // 7. Product Collections Pivot
        Schema::create('product_collection', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('collection_id')->constrained()->cascadeOnDelete();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 8. Bundles & Bundle Items
        Schema::create('bundles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->text('tagline')->nullable();
            $table->text('description')->nullable();
            $table->decimal('original_price', 10, 2);
            $table->decimal('bundle_price', 10, 2);
            $table->decimal('savings_amount', 10, 2);
            $table->string('image')->nullable();
            $table->string('badge_text')->default('SAVE EXTRA');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('bundle_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bundle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->string('custom_size_label')->nullable();
            $table->timestamps();
        });

        // 9. Product Gallery Images
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->string('alt_text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        // 10. Product Scent Notes Pivot
        Schema::create('product_scent_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('scent_note_id')->constrained()->cascadeOnDelete();
            $table->enum('note_layer', ['top', 'heart', 'base']);
            $table->integer('prominence_percentage')->default(33);
            $table->timestamps();
        });

        // 11. Product Variants (Sizes & Concentrations)
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('size_label');
            $table->integer('volume_ml');
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('sku')->unique();
            $table->integer('stock')->default(20);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        // 12. Carts & Cart Items (Database-backed for shared hosting persistence)
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('session_id')->nullable()->index();
            $table->string('coupon_code')->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('bundle_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        // 13. Customer Reviews
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_city')->default('Karachi');
            $table->integer('rating')->default(5);
            $table->string('title')->nullable();
            $table->text('comment');
            $table->boolean('verified_purchase')->default(true);
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });

        // 14. Discount Coupons
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('value', 10, 2);
            $table->decimal('min_spend', 10, 2)->default(0);
            $table->decimal('max_discount', 10, 2)->nullable();
            $table->date('expires_at')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('used_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 15. Customer Addresses
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('recipient_name');
            $table->string('phone');
            $table->string('street_address');
            $table->string('city');
            $table->string('province')->default('Punjab');
            $table->string('postal_code')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        // 16. Customer Orders
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            
            // Customer Details (Pakistan context)
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->text('shipping_address');
            $table->string('area')->nullable();
            $table->string('landmark')->nullable();
            $table->string('city');
            $table->string('province')->default('Punjab');
            $table->string('postal_code')->nullable();
            $table->text('order_notes')->nullable();
            
            // Financials
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->string('coupon_code')->nullable();
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            
            // Payment & Logistics
            $table->string('payment_method')->default('cod'); // cod, bank_transfer, wallet_transfer, jazzcash, easypaisa, card, safepay
            $table->string('payment_status')->default('unpaid'); // unpaid, pending_verification, paid, failed, refunded
            $table->string('payment_receipt')->nullable();
            $table->string('bank_transaction_id')->nullable();
            
            $table->string('order_status')->default('pending'); // pending, pending_verification, confirmed, packed, shipped, delivered, cancelled, returned
            $table->string('tracking_number')->nullable();
            $table->string('courier_name')->nullable(); // TCS, Leopards, PostEx, M&P, Trax, BlueEx
            $table->string('tracking_link')->nullable();
            
            $table->boolean('is_whatsapp_order')->default(false);
            $table->timestamps();

            $table->index(['order_status', 'payment_status', 'customer_phone']);
        });

        // 17. Order Items
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('bundle_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name');
            $table->string('variant_label')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(1);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });

        // 18. Payments Record (Pluggable Gateways)
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('payment_method');
            $table->decimal('amount', 10, 2);
            $table->string('transaction_id')->nullable();
            $table->string('gateway_reference')->nullable();
            $table->text('gateway_response')->nullable();
            $table->string('receipt_image')->nullable();
            $table->string('status')->default('pending'); // pending, pending_verification, paid, failed, refunded
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 19. Wishlist
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('session_id')->nullable();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        // 20. Blogs / Fragrance Chronicles
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('image')->nullable();
            $table->string('author_name')->default('Master Parfumeur');
            $table->string('category')->default('Olfactory Culture');
            $table->string('read_time')->default('5 min read');
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // 21. Hero Slides
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('badge_text')->nullable();
            $table->string('image');
            $table->string('cta_text')->default('EXPLORE VAULT');
            $table->string('cta_url')->default('/collections/exclusive');
            $table->string('secondary_cta_text')->nullable();
            $table->string('secondary_cta_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 22. Store Settings Key-Value Table
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });

        // 23. Page Visits / Analytics
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->nullable();
            $table->string('page_url');
            $table->string('referer')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('visited_at')->useCurrent();
        });

        // 24. Newsletter Subscribers
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('source')->default('footer_modal');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 25. Inquiries & Fragrance Consultations
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->string('inquiry_type')->default('General');
            $table->text('message');
            $table->enum('status', ['new', 'in_progress', 'resolved'])->default('new');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inquiries');
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('page_visits');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('hero_slides');
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('wishlists');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('product_scent_notes');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('bundle_items');
        Schema::dropIfExists('bundles');
        Schema::dropIfExists('product_collection');
        Schema::dropIfExists('products');
        Schema::dropIfExists('scent_notes');
        Schema::dropIfExists('fragrance_families');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('collections');
        Schema::dropIfExists('categories');
    }
};
