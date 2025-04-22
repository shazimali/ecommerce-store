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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['email', 'first_name', 'last_name', 'city', 'country_id', 'postal_code', 'address', 'country']);
            $table->enum('status', ['PLACED', 'PACKED', 'IN_TRANSIT', 'DELIVERED', 'CANCELLED'])->default('PLACED')->change();
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('city');
            $table->string('first_name')->nullable();
            $table->string('email');
            $table->string('last_name')->nullable();
            $table->string('country')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('address')->nullable();
            $table->dropColumn(['user_id']);
        });
    }
};
