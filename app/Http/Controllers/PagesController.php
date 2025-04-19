<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    function index($slug)
    {
        return view('page', ['page' => Page::where('slug', $slug)->first()]);
    }
}
