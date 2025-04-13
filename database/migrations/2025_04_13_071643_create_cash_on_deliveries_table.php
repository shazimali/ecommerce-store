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
        Schema::create('cash_on_deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('api_test_url')->nullable();
            $table->string('api_url');
            $table->string('api_key');
            $table->string('api_password');
            $table->enum('status', ['DEFAULT', 'ACTIVE', 'INACTIVE']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_on_deliveries');
    }
};
