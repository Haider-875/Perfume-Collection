<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Administrative Activity Audit Logs
        if (!Schema::hasTable('activity_logs')) {
            Schema::create('activity_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->string('user_name')->default('Admin Concierge');
                $table->string('action'); // created, updated, deleted, status_change, payment_approved, etc.
                $table->string('subject_type')->nullable(); // Order, Product, Setting, Coupon, etc.
                $table->unsignedBigInteger('subject_id')->nullable();
                $table->text('description');
                $table->text('properties')->nullable(); // JSON of changes
                $table->string('ip_address')->nullable();
                $table->timestamps();

                $table->index(['action', 'subject_type', 'created_at']);
            });
        }

        // 2. Telemetry Page Visits Table for lightweight visitor tracking
        if (!Schema::hasTable('page_visits')) {
            Schema::create('page_visits', function (Blueprint $table) {
                $table->id();
                $table->string('session_id')->nullable()->index();
                $table->text('page_url')->nullable();
                $table->string('path')->nullable()->index();
                $table->string('ip_address', 45)->nullable()->index();
                $table->text('user_agent')->nullable();
                $table->string('device_type')->default('desktop'); // mobile, desktop, tablet
                $table->text('referer')->nullable();
                $table->string('utm_source')->nullable();
                $table->timestamp('visited_at')->useCurrent()->index();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
