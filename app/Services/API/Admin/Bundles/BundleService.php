<?php

namespace App\Services\API\Admin\Bundles;

use App\Http\Resources\API\Admin\Bundles\BundleEditResource;
use App\Http\Resources\API\Admin\Bundles\BundleListResource;
use App\Interfaces\API\Admin\Bundles\BundleInterface;
use App\Models\Bundle;
use App\Models\BundleColor;
use App\Models\BundlePrice;

class BundleService implements BundleInterface
{
    use \App\Traits\FileUploadTrait;

    public function getAll(array $filters, int $perPage)
    {
        $search = $filters['search'] ?? null;
        $query = Bundle::query();
        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
        }
        $bundles = $query->paginate($perPage);

        if ($bundles) {
            return BundleListResource::collection($bundles);
        } else {
            return response()->json(['message' => 'Bundle Not exist'], 201);
        }
    }

    public function store(array $data)
    {
        $data['coming_soon'] = ($data['coming_soon'] ?? false) == true ? 1 : 0;

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $this->uploadFile($data['image']);
            $data['nav_image'] = $this->createThumbnailFromPath($data['image'], 208, 208);
        }

        foreach (range(1, 5) as $i) {
            $key = "image$i";
            if (isset($data[$key]) && $data[$key] instanceof \Illuminate\Http\UploadedFile) {
                $data[$key] = $this->uploadFile($data[$key]);
            }
        }

        $bundle = Bundle::create($data);

        if ($bundle) {
            return response()->json(['message' => 'Bundle Stored Successfully'], 200);
        } else {
            return response()->json(['message' => 'Bundle Not Stored'], 201);
        }
    }

    public function edit(int $id)
    {
        $bundle = Bundle::find($id);
        if ($bundle) {
            return new BundleEditResource($bundle);
        } else {
            return response()->json(['message' => 'Bundle not exist'], 201);
        }
    }

    public function update(int $id, array $data)
    {
        $bundle = Bundle::find($id);
        if (!$bundle) {
            return response()->json(['message' => 'Bundle not found'], 201);
        }

        $data['coming_soon'] = ($data['coming_soon'] ?? 'false') == 'true' ? 1 : 0;

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $this->deleteFile($bundle->image);
            $this->deleteFile($bundle->nav_image);

            $data['image'] = $this->uploadFile($data['image']);
            $data['nav_image'] = $this->createThumbnailFromPath($data['image'], 208, 208);
        }

        foreach (range(1, 5) as $i) {
            $key = "image$i";
            if (isset($data[$key]) && $data[$key] instanceof \Illuminate\Http\UploadedFile) {
                $this->deleteFile($bundle->$key);
                $data[$key] = $this->uploadFile($data[$key]);
            }
        }

        $bundle->update($data);

        return response()->json(['message' => 'Bundle Updated Successfully'], 200);
    }

    public function destroy(int $id)
    {
        $bundle = Bundle::find($id);
        if ($bundle) {
            $this->deleteFile($bundle->image);
            $this->deleteFile($bundle->image1);
            $this->deleteFile($bundle->image2);
            $this->deleteFile($bundle->image3);
            $this->deleteFile($bundle->image4);
            $this->deleteFile($bundle->image5);
            $this->deleteFile($bundle->nav_image);

            // Deleting related bundle colors
            $bundleColors = BundleColor::where('bundle_id', $id)->get();
            if (count($bundleColors)) {
                foreach ($bundleColors as $bundle_color) {
                    $this->deleteFile($bundle_color->color_image);
                    $this->deleteFile($bundle_color->image1);
                    $this->deleteFile($bundle_color->image2);
                    $this->deleteFile($bundle_color->image3);
                    $this->deleteFile($bundle_color->image4);
                    $this->deleteFile($bundle_color->image5);
                    $bundle_color->delete();
                }
            }

            // Deleting related bundle prices
            $bundlePrices = BundlePrice::where('bundle_id', $id)->get();
            if (count($bundlePrices)) {
                foreach ($bundlePrices as $bundle_price) {
                    $bundle_price->delete();
                }
            }

            $bundle->delete();
            return response()->json(['message' => 'Bundle deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Bundle not found'], 201);
        }
    }
}
