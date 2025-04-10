<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    public function index()
    {
        return view('blogs.index', [
            'blogs' => Blog::active()->whereHas('countries', function ($q) {
                $q->where('country_id', getLocation()->id);
            })->paginate(2)
        ]);
    }

    public function detail($slug)
    {

        return view('blogs.detail', [
            'blog' => Blog::active()->where('slug', $slug)->first()
        ]);
    }
}
