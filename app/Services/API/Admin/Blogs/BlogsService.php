<?php

namespace App\Services\API\Admin\Blogs;

use App\Http\Requests\API\Admin\Blogs\StoreBlogRequest;
use App\Http\Requests\API\Admin\Blogs\UpdateBlogRequest;
use App\Http\Resources\API\Admin\Blogs\BlogsListResource;
use App\Interfaces\API\Admin\Blogs\BlogsInterface;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogsService implements BlogsInterface
{
    public function getAll(Request $request)
    {
        $blog  = Blog::paginate($request->item_per_page);
        if ($request->search) {
            $blog->where('name', 'like', "%{$request->search}%")
                ->orWhere('id', 'like', "%{$request->search}%");
        }
        if ($blog) {
            return BlogsListResource::collection($blog);
        }
        return response()->json(['message' => 'No Blog found'], 200);
    }

    public function store(StoreBlogRequest $request)
    {
        $data = $request->all();
        try {
            $blog = Blog::create($data);
            $blog->countries()->attach($data['countries']);
            return response()->json(['message' => 'Blog Stored Successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 201);
        }
    }
    public function edit(int $id) {}
    public function update(UpdateBlogRequest $request, int $id) {}
    public function destroy(int $id) {}
}
