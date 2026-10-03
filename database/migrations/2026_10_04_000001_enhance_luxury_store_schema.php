<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add impression_of and secondary_image to products if not exists
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'impression_of')) {
                $table->string('impression_of')->nullable()->after('name');
            }
            if (!Schema::hasColumn('products', 'fragrance_notes_pyramid')) {
                $table->json('fragrance_notes_pyramid')->nullable()->after('base_notes_summary');
            }
        });

        // 2. Add permissions and is_active to users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'permissions')) {
                $table->text('permissions')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('permissions');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'impression_of')) {
                $table->dropColumn('impression_of');
            }
            if (Schema::hasColumn('products', 'fragrance_notes_pyramid')) {
                $table->dropColumn('fragrance_notes_pyramid');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'permissions')) {
                $table->dropColumn('permissions');
            }
            if (Schema::hasColumn('users', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
