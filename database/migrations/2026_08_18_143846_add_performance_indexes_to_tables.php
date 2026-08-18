<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add performance indexes for common query patterns.
     * These indexes target WHERE + ORDER BY combinations used in
     * ProductHead scopes (active, new, trending, featured) and
     * the website() / getSettingVal() helpers.
     */
    public function up(): void
    {
        // product_heads: composite indexes for scopeActive + scopeNew/Trending/Featured
        Schema::table('product_heads', function (Blueprint $table) {
            if (!Schema::hasIndex('product_heads', 'product_heads_slug_index')) {
                $table->index('slug', 'product_heads_slug_index');
            }
            if (!Schema::hasIndex('product_heads', 'product_heads_status_is_new_order_index')) {
                $table->index(['status', 'is_new', 'order'], 'product_heads_status_is_new_order_index');
            }
            if (!Schema::hasIndex('product_heads', 'product_heads_status_is_trending_order_index')) {
                $table->index(['status', 'is_trending', 'order'], 'product_heads_status_is_trending_order_index');
            }
            if (!Schema::hasIndex('product_heads', 'product_heads_status_is_featured_order_index')) {
                $table->index(['status', 'is_featured', 'order'], 'product_heads_status_is_featured_order_index');
            }
        });

        // websites: composite index for active scope + domain lookup
        Schema::table('websites', function (Blueprint $table) {
            if (!Schema::hasIndex('websites', 'websites_status_domain_index')) {
                $table->index(['status', 'domain'], 'websites_status_domain_index');
            }
        });

        // settings: composite index for country_id + key lookups
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasIndex('settings', 'settings_country_id_key_index')) {
                $table->index(['country_id', 'key'], 'settings_country_id_key_index');
            }
        });

        // product_reviews: index for product_id + status (used in rating filter)
        Schema::table('product_reviews', function (Blueprint $table) {
            if (!Schema::hasIndex('product_reviews', 'product_reviews_product_id_status_index')) {
                $table->index(['product_id', 'status'], 'product_reviews_product_id_status_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_heads', function (Blueprint $table) {
            $table->dropIndexIfExists('product_heads_slug_index');
            $table->dropIndexIfExists('product_heads_status_is_new_order_index');
            $table->dropIndexIfExists('product_heads_status_is_trending_order_index');
            $table->dropIndexIfExists('product_heads_status_is_featured_order_index');
        });
        Schema::table('websites', function (Blueprint $table) {
            $table->dropIndexIfExists('websites_status_domain_index');
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->dropIndexIfExists('settings_country_id_key_index');
        });
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropIndexIfExists('product_reviews_product_id_status_index');
        });
    }
};
