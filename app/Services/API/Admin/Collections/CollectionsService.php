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
    use \App\Traits\FileUploadTrait;

    public function getAll(array $filters, int $perPage)
    {
        $search = $filters['search'] ?? null;
        $country_id = $filters['country_id'] ?? null;

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

        return $query->paginate($perPage);
    }

    public function getAllExtra()
    {
        return [
            'websites' => WebsiteListResource::collection(Website::active()->get()),
            'products' => ProductListResource::collection(ProductHead::active()->get())
        ];
    }

    public function store(array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $this->uploadFile($data['image'], '/', 'public');
        }
        if (isset($data['mob_image']) && $data['mob_image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['mob_image'] = $this->uploadFile($data['mob_image'], '/', 'public');
        }

        $collection = Collection::create($data);
        
        if (isset($data['products'])) {
            $collection->products()->attach($data['products']);
        }
        
        if (isset($data['websites'])) {
            $collection->websites()->attach($data['websites']);
        }

        return $collection;
    }

    public function edit(int $id)
    {
        return Collection::find($id);
    }

    public function update(int $id, array $data)
    {
        $collection = Collection::find($id);
        
        if (!$collection) {
            return null;
        }

        $updateData = [
            'title' => $data['title'],
            'slug' => $data['slug'],
            'order' => $data['order'],
            'status' => $data['status'],
            'position' => $data['position']
        ];

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if (!is_null($collection->image)) {
                $this->deleteFile($collection->image, 'public');
            }
            $updateData['image'] = $this->uploadFile($data['image'], '/', 'public');
        }

        if (isset($data['mob_image']) && $data['mob_image'] instanceof \Illuminate\Http\UploadedFile) {
            if (!is_null($collection->mob_image)) {
                $this->deleteFile($collection->mob_image, 'public');
            }
            $updateData['mob_image'] = $this->uploadFile($data['mob_image'], '/', 'public');
        }

        $collection->update($updateData);

        if (isset($data['websites'])) {
            $collection->websites()->sync($data['websites']);
        }
        
        if (isset($data['products'])) {
            $collection->products()->sync($data['products']);
        }

        return $collection;
    }

    public function destroy(int $id)
    {
        $collection = Collection::with('websites')->whereId($id)->first();
        
        if (!$collection) {
            return false;
        }

        $collection->websites()->sync([]);
        $collection->products()->sync([]);
        
        if (!is_null($collection->image)) {
            $this->deleteFile($collection->image, 'public');
        }
        
        if (!is_null($collection->mob_image)) {
            $this->deleteFile($collection->mob_image, 'public');
        }
        
        return $collection->delete();
    }
}
