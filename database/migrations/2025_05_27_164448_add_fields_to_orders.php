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
            $table->string('weight')->nullable();
            $table->integer('piece')->nullable();
            $table->text('special_instructions')->nullable();
            $table->string('track_number')->nullable();
            $table->string('slip_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['weight', 'piece', 'special_instructions', 'track_number', 'slip_link']);
        });
    }
};
