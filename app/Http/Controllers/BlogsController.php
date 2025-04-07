<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    public function index()
    {
        return view('blogs.index');
    }

    public function detail($slug)
    {
        
        return view('blogs.index',[
            'data' => Blog::active()->where('slug',$slug)->first();
        ]);
    }
}
