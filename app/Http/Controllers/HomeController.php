<?php

namespace App\Http\Controllers;

use App\Events\AdminNotification;
use App\Events\NewNotification;
use App\Models\Collection;
use App\Models\Country;
use App\Models\Facility;
use App\Models\ProductHead;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    function index()
    {
        $websiteId = website()->id;

        $data = Cache::remember('home_page_' . $websiteId, now()->addMinutes(15), function () use ($websiteId) {
            return [
                'new_products'      => ProductHead::active()->new()->orderBy('order')->paginate(8),
                'trending_products' => ProductHead::active()->trending()->orderBy('order')->paginate(8),
                'featured_products' => ProductHead::active()->featured()->orderBy('order')->paginate(8),
                'collections'       => Collection::active()->top()->with(['websites' => function ($q) use ($websiteId) {
                    $q->where('website_id', $websiteId);
                }])->get(),
                'bottom_collection' => Collection::active()->bottom()->with(['websites' => function ($q) use ($websiteId) {
                    $q->where('website_id', $websiteId);
                }])->first(),
                'start_collection'  => Collection::active()->start()->with(['websites' => function ($q) use ($websiteId) {
                    $q->where('website_id', $websiteId);
                }])->first(),
            ];
        });

        return view('home', $data);
    }
}
