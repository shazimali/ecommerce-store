<?php

namespace App\Http\Controllers\API\Admin\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Blogs\StoreBlogRequest;
use App\Services\API\Admin\Blogs\BlogsService;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    public $blogsService;

    public function __construct(BlogsService $blogsService)
    {
        $this->blogsService = $blogsService;
    }

    public function index(Request $request)
    {
        return $this->blogsService->getAll($request);
    }

    public function store(StoreBlogRequest $request)
    {
        return $this->blogsService->store($request);
    }
}
