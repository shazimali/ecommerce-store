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
        Schema::create('product_heads', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('code')->nullable();
            $table->string('sku')->unique();
            $table->integer('order')->default(0);
            $table->string('short_desc');
            $table->integer('discount')->default(0);
            $table->longText('description')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_desc')->nullable();
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('INACTIVE');
            $table->tinyInteger('is_new')->default(0);
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('coming_soon')->default(0);
            $table->string('nav_image')->nullable();
            $table->string('mobile_image')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_heads');
    }
};
