<?php

namespace App\Http\Controllers;

use App\Events\AdminNotification;
use App\Events\NewNotification;
use App\Models\Collection;
use App\Models\Country;
use App\Models\Facility;
use App\Models\ProductHead;

class HomeController extends Controller
{
    function index()
    {
        event(new AdminNotification('You have a new order' . 'ED#' . rand(1, 200)));
        $collections = Collection::active()->top()->with(['websites' => function ($q) {
            $q->where('website_id', website()->id);
        }])->get();

        $bottom_collection = Collection::active()->bottom()->with(['websites' => function ($q) {
            $q->where('website_id', website()->id);
        }])->first();
        return view('home', [
            'new_products' => ProductHead::active()->new()->orderBy('order')->paginate(8),
            'trending_products' => ProductHead::active()->trending()->orderBy('order')->paginate(8),
            'featured_products' => ProductHead::active()->featured()->orderBy('order')->paginate(8),
            'collections' => $collections,
            'bottom_collection' => $bottom_collection
        ]);
    }
}
