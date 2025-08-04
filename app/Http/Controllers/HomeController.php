<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Facility;
use App\Models\ProductHead;

class HomeController extends Controller
{
    function index()
    {
        return view('home', [
            'new_products' => ProductHead::active()->new()->orderBy('order')->paginate(8),
            'trending_products' => ProductHead::active()->trending()->orderBy('order')->paginate(8),
            'featured_products' => ProductHead::active()->featured()->orderBy('order')->paginate(8),
        ]);
    }
}
