<?php

namespace App\Http\Controllers\API\Admin\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Blogs\StoreBlogRequest;
use App\Http\Requests\API\Admin\Blogs\UpdateBlogRequest;
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
        $this->authorize('blog_access');
        return $this->blogsService->getAll($request);
    }

    public function getAllCountries()
    {
        return $this->blogsService->getAllCountries();
    }

    public function store(StoreBlogRequest $request)
    {
        $this->authorize('blog_create');
        return $this->blogsService->store($request);
    }

    public function edit(int $id)
    {
        $this->authorize('blog_edit');
        return $this->blogsService->edit($id);
    }

    public function update(UpdateBlogRequest $request, int $id)
    {
        $this->authorize('blog_edit');
        return $this->blogsService->update($request, $id);
    }

    public function destroy(int $id)
    {
        $this->authorize('blog_delete');
        return $this->blogsService->destroy($id);
    }
}
