<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to add optimized performance indexes across core store tables.
     */
    public function up(): void
    {
        // 1. Products: Optimize catalog filtering, new arrivals, collaboration collections, and inventory checks
        Schema::table('products', function (Blueprint $table) {
            $table->index(['is_active', 'created_at'], 'idx_products_is_active_created_at');
            $table->index(['category_id', 'is_active'], 'idx_products_category_id_is_active');
            $table->index(['is_new_arrival', 'is_active'], 'idx_products_is_new_arrival_is_active');
            $table->index(['is_collaboration', 'is_active'], 'idx_products_is_collab_is_active');
            $table->index(['stock'], 'idx_products_stock');
        });

        // 2. Orders: Optimize dashboard date-range queries, payment verification status, tracking lookup, and customer lookup
        Schema::table('orders', function (Blueprint $table) {
            $table->index(['created_at'], 'idx_orders_created_at');
            $table->index(['payment_status', 'created_at'], 'idx_orders_payment_status_created_at');
            $table->index(['tracking_number'], 'idx_orders_tracking_number');
            $table->index(['customer_email'], 'idx_orders_customer_email');
        });

        // 3. Categories: Optimize active navigation sorted by sort_order
        Schema::table('categories', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order'], 'idx_categories_is_active_sort_order');
        });

        // 4. Collections: Optimize active curated collections navigation sorted by sort_order
        Schema::table('collections', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order'], 'idx_collections_is_active_sort_order');
        });

        // 5. Product Collection Pivot: Optimize products in collection ordered by sort_order
        Schema::table('product_collection', function (Blueprint $table) {
            $table->index(['collection_id', 'sort_order'], 'idx_product_collection_col_sort');
        });

        // 6. Reviews: Optimize product page approved reviews and homepage testimonials
        Schema::table('reviews', function (Blueprint $table) {
            $table->index(['product_id', 'is_approved', 'created_at'], 'idx_reviews_prod_approved_created');
            $table->index(['is_approved', 'created_at'], 'idx_reviews_is_approved_created_at');
        });

        // 7. Users: Optimize customer management listing by role and phone search
        Schema::table('users', function (Blueprint $table) {
            $table->index(['role', 'created_at'], 'idx_users_role_created_at');
            $table->index(['phone'], 'idx_users_phone');
        });

        // 8. Product Variants: Optimize default variant lookup by product
        Schema::table('product_variants', function (Blueprint $table) {
            $table->index(['product_id', 'is_default'], 'idx_product_variants_prod_default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_is_active_created_at');
            $table->dropIndex('idx_products_category_id_is_active');
            $table->dropIndex('idx_products_is_new_arrival_is_active');
            $table->dropIndex('idx_products_is_collab_is_active');
            $table->dropIndex('idx_products_stock');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('idx_orders_created_at');
            $table->dropIndex('idx_orders_payment_status_created_at');
            $table->dropIndex('idx_orders_tracking_number');
            $table->dropIndex('idx_orders_customer_email');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_is_active_sort_order');
        });

        Schema::table('collections', function (Blueprint $table) {
            $table->dropIndex('idx_collections_is_active_sort_order');
        });

        Schema::table('product_collection', function (Blueprint $table) {
            $table->dropIndex('idx_product_collection_col_sort');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex('idx_reviews_prod_approved_created');
            $table->dropIndex('idx_reviews_is_approved_created_at');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_role_created_at');
            $table->dropIndex('idx_users_phone');
        });

        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropIndex('idx_product_variants_prod_default');
        });
    }
};
