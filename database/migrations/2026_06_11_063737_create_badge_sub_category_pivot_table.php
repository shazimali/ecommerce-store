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
        Schema::create('badge_sub_category', function (Blueprint $table) {
            $table->unsignedBigInteger('badge_id')->index();
            $table->foreign('badge_id')->references('id')->on('badges')->onDelete('cascade');
            $table->unsignedBigInteger('sub_category_id')->index();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->primary(['badge_id', 'sub_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badge_sub_category');
    }
};
