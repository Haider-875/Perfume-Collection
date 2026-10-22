<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('uploaded_files')) {
            Schema::create('uploaded_files', function (Blueprint $table) {
                $table->id();
                $table->string('path', 255)->unique();
                $table->string('filename', 255)->index();
                $table->string('folder', 100)->index();
                $table->string('mime_type', 100)->default('image/jpeg');
                $table->unsignedBigInteger('file_size')->default(0);
                $table->longText('file_data'); // base64 encoded binary data for 100% database portability
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploaded_files');
    }
};
