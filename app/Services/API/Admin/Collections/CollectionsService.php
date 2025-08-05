<?php

namespace App\Services\API\Admin\Collections;

use App\Http\Requests\API\Admin\Collections\StoreCollectionRequest;
use App\Http\Requests\API\Admin\Collections\UpdateCollectionRequest;
use App\Http\Resources\API\Admin\Collections\CollectionEditResource;
use App\Http\Resources\API\Admin\Collections\CollectionsListResource;
use App\Http\Resources\API\Admin\Countries\CountryListResource;
use App\Http\Resources\API\Admin\Products\ProductListResource;
use App\Http\Resources\API\Admin\Websites\WebsiteListResource;
use App\Interfaces\API\Admin\Collections\CollectionInterface;
use App\Models\Collection;
use App\Models\Country;
use App\Models\ProductHead;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollectionsService implements CollectionInterface
{
    public function getAll(Request $request)
    {
        $search = $request->search;
        $country_id = $request->country_id;

        $query = Collection::query();

        $query->when($search, function ($q) use ($search) {
            return $q->where('title', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        });

        $query->when($country_id, function ($q) use ($country_id) {
            return $q->whereHas('countries', function ($inner_q) use ($country_id) {
                return $inner_q->where('id', $country_id);
            });
        });

        return CollectionsListResource::collection($query->paginate($request->item_per_page));
    }
    public function getAllExtra()
    {
        return response()->json([
            'websites' => WebsiteListResource::collection(Website::active()->get()),
            'products' => ProductListResource::collection(ProductHead::active()->get())
        ], 200);
    }
    public function store(StoreCollectionRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = Storage::disk('public')->put('/', $request->file('image'));
        }
        if ($request->hasFile('mob_image')) {
            $data['mob_image'] = Storage::disk('public')->put('/', $request->file('mob_image'));
        }

        $collection = Collection::create($data);
        $collection->products()->attach($request->products);
        $collection->websites()->attach($request->websites);
        if ($collection) {
            return response()->json(['message' => 'Collection Stored Successfully '], 200);
        } else {
            return response()->json(['message' => 'Collection Not Stored'], 201);
        }
    }
    public function edit(int $id)
    {
        $collection = Collection::find($id);
        if ($collection) {
            return new CollectionEditResource($collection);
        } else {
            return response()->json(['message', 'Collection does not exist'], 201);
        }
    }
    public function update(UpdateCollectionRequest $request, int $id)
    {
        $collection = Collection::find($id);
        if ($collection) {
            $data = [
                'title' => $request->title,
                'slug' => $request->slug,
                'order' => $request->order,
                'status' => $request->status,
                'position' => $request->position
            ];
            if ($request->hasFile('image')) {
                if (!is_null($collection->image)) {
                    Storage::delete($collection->image);
                }
                $data['image'] = Storage::disk('public')->put('/', $request->file('image'));
            }
            if ($request->hasFile('mob_image')) {
                if (!is_null($collection->mob_image)) {
                    Storage::delete($collection->mob_image);
                }
                $data['mob_image'] = Storage::disk('public')->put('/', $request->file('mob_image'));
            }
            $collection->update($data);
            $collection->websites()->sync($request->websites);
            $collection->products()->sync($request->products);
            return  response()->json(['message' => 'Collection updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Collection not found'], 201);
        }
    }
    public function destroy(int $id)
    {
        $collection = Collection::with('websites')->whereId($id)->first();
        if ($collection) {
            $collection->websites()->sync([]);
            $collection->products()->sync([]);
            if (!is_null($collection->image)) {
                Storage::delete($collection->image);
            }
            if (!is_null($collection->mob_image)) {
                Storage::delete($collection->mob_image);
            }
            $collection->delete();
            return  response()->json(['message' => 'Category deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Category not found'], 201);
        }
    }
}
