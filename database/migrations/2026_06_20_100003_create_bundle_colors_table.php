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
        Schema::create('bundle_colors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bundle_id')->index();
            $table->foreign('bundle_id')->references('id')->on('bundles')->onDelete('cascade');
            $table->string('color_name');
            $table->string('color_image');
            $table->string('image1');
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('image4')->nullable();
            $table->string('image5')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundle_colors');
    }
};
