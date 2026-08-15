<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\ProductHead;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    function index()
    {
        // ── Collections (rarely change — cache 6 hours) ────────────────────────
        $collections = Cache::remember('home_collections', 21_600, function () {
            return Collection::active()->top()->with(['websites' => function ($q) {
                $q->where('website_id', website()->id);
            }])->get();
        });

        $bottom_collection = Cache::remember('home_bottom_collection', 21_600, function () {
            return Collection::active()->bottom()->with(['websites' => function ($q) {
                $q->where('website_id', website()->id);
            }])->first();
        });

        $start_collection = Cache::remember('home_start_collection', 21_600, function () {
            return Collection::active()->start()->with(['websites' => function ($q) {
                $q->where('website_id', website()->id);
            }])->first();
        });

        // ── Products (change more often — cache 1 hour) ────────────────────────
        $new_products = Cache::remember('home_new_products', 3_600, function () {
            return ProductHead::active()->new()->orderBy('order')->paginate(8);
        });

        $trending_products = Cache::remember('home_trending_products', 3_600, function () {
            return ProductHead::active()->trending()->orderBy('order')->paginate(8);
        });

        $featured_products = Cache::remember('home_featured_products', 3_600, function () {
            return ProductHead::active()->featured()->orderBy('order')->paginate(8);
        });

        return view('home', compact(
            'new_products',
            'trending_products',
            'featured_products',
            'collections',
            'bottom_collection',
            'start_collection',
        ));
    }
}
