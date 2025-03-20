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
        Schema::create('product_head_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_head_id');
            $table->unsignedBigInteger('country_id')->index();
            $table->decimal('price', 8, 2);
            $table->integer('discount')->default(0);
            $table->date('discount_from')->nullable();
            $table->date('discount_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_head_prices');
    }
};
