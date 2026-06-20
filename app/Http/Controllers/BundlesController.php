<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class BundlesController extends Controller
{
    public function shop()
    {
        return view('bundles.shop');
    }

    public function detail($slug)
    {
        $bundle = Bundle::where('slug', $slug)->active()->first();
        if ($bundle) {
            $reviews = ProductReview::where('bundle_id', $bundle->id)->where('status', 'ACTIVE')->get();
            return view('bundles.detail', [
                'bundle' => $bundle,
                'reviews' => $reviews,
            ]);
        }
        return abort(404);
    }
}
