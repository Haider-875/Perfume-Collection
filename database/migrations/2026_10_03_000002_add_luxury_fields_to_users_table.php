<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('customer')->after('email'); // admin, customer
            $table->string('phone')->nullable()->after('role');
            $table->string('city')->nullable()->after('phone');
            $table->text('address')->nullable()->after('city');
            $table->string('avatar')->nullable()->after('address');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'city', 'address', 'avatar']);
        });
    }
};
