<?php

namespace App\Services\API\Admin\Pages;

use App\Http\Requests\API\Admin\Pages\StorePagesRequest;
use App\Http\Requests\API\Admin\Pages\UpdatePagesRequest;
use App\Http\Resources\API\Admin\Countries\CountryListResource;
use App\Http\Resources\API\Admin\Pages\PagesEditResource;
use App\Http\Resources\API\Admin\Pages\PagesListResource;
use App\Interfaces\API\Admin\Pages\PagesInterface;
use App\Models\Country;
use App\Models\Page;
use Illuminate\Http\Request;

class PagesService implements PagesInterface
{
    public function getAll(Request $request)
    {
        $page  = Page::paginate($request->item_per_page);
        if ($request->search) {
            $page->where('name', 'like', "%{$request->search}%")
                ->orWhere('id', 'like', "%{$request->search}%");
        }
        if ($page) {
            return PagesListResource::collection($page);
        }
        return response()->json(['message' => 'Page Not found'], 200);
    }

    public function getAllCountries()
    {
        $countries = Country::all();
        if ($countries) {
            return CountryListResource::collection($countries);
        }
        return response()->json(['message' => 'No country found'], 201);
    }

    public function store(StorePagesRequest $request)
    {
        $data = $request->all();
        if ($data) {

            $page = Page::create($data);
            $page->countries()->attach($data['countries']);
            return response()->json(['message' => 'Page Stored Successfully'], 200);
        } else {
            return response()->json(['message' => 'Pages Not Stored'], 201);
        }
    }

    public function edit(int $id)
    {
        $page = Page::find($id);
        if ($page) {
            return new PagesEditResource($page);
        } else {
            return response()->json(['message' => 'Page not fount'], 201);
        }
    }

    public function update(UpdatePagesRequest $request, int $id)
    {
        $page  = Page::find($id);
        if ($page) {
            $data = [
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'status' => $request->status,
                'seo_title' => $request->seo_title,
                'seo_description' => $request->seo_description,
            ];

            $page->update($data);
            $page->countries()->sync($request->countries);
            return response()->json(['message' => 'Page updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Page not found.'], 201);
        }
    }

    public function destroy(int $id)
    {
        $page  = Page::find($id);
        if ($page) {
            $page->countries()->detach();
            $page->delete();
            return response()->json(['message' => 'Page Deleted Successfully'], 200);
        } else {
            return response()->json(['message' => 'Page not found.'], 201);
        }
    }
}
