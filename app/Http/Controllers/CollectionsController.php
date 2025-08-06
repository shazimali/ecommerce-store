<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($slug)
    {
        return view('collections', [
            'collection' => Collection::active()->where('slug', $slug)->with('products')->first()
        ]);
    }
}
