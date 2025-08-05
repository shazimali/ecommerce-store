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
        Schema::create('collection_product_head', function (Blueprint $table) {
            $table->unsignedBigInteger('collection_id')->index();
            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('cascade');
            $table->unsignedBigInteger('product_head_id')->index();
            $table->foreign('product_head_id')->references('id')->on('product_heads')->onDelete('cascade');
            $table->primary(['collection_id', 'product_head_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_product_head');
    }
};
