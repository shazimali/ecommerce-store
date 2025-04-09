<?php

namespace App\Services\API\Admin\Blogs;

use App\Http\Requests\API\Admin\Blogs\StoreBlogRequest;
use App\Http\Requests\API\Admin\Blogs\UpdateBlogRequest;
use App\Http\Resources\API\Admin\Blogs\BlogsEditResource;
use App\Http\Resources\API\Admin\Blogs\BlogsListResource;
use App\Http\Resources\API\Admin\Countries\CountryListResource;
use App\Interfaces\API\Admin\Blogs\BlogsInterface;
use App\Models\Blog;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function getAllCountries()
    {
        $countries = Country::all();
        if ($countries) {
            return CountryListResource::collection($countries);
        }
        return response()->json(['message' => 'No country found'], 201);
    }

    public function store(StoreBlogRequest $request)
    {

        $data = $request->all();
        try {
            if ($request->hasFile('image')) {
                $data['image'] = Storage::disk('public')->put('/', $request->file('image'));
            }
            $blog = Blog::create($data);
            $blog->countries()->attach($data['countries']);
            return response()->json(['message' => 'Blog Stored Successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 201);
        }
    }

    public function edit(int $id)
    {
        $blog  = Blog::find($id);
        if ($blog) {
            return new BlogsEditResource($blog);
        } else {
            return response()->json(['message' => 'Blog not exists'], 201);
        }
    }

    public function update(UpdateBlogRequest $request, int $id)
    {
        $blog  = Blog::find($id);
        if ($blog) {
            $data = [
                'title' => $request->title,
                'slug' => $request->slug,
                'description' => $request->description,
                'seo_title' => $request->seo_title,
                'seo_desc' => $request->seo_desc,
                'status' => $request->status,
            ];
            if ($request->hasFile('image')) {
                if (Storage::exists($blog->image)) {
                    Storage::delete($blog->image);
                }
                $data['image'] = Storage::disk('public')->put('/', $request->file('image'));
            }
            $blog->update($data);
            $blog->countries()->sync($request->countries);
            return response()->json(['message' => 'Blog updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Blog not found.'], 201);
        }
    }

    public function destroy(int $id)
    {

        $blog  = Blog::find($id);
        if ($blog) {
            $blog->countries()->detach();
            $blog->delete();
            return response()->json(['message' => 'Blog Deleted Successfully'], 200);
        } else {
            return response()->json(['message' => 'Blog not found.'], 201);
        }
    }
}
