<?php

namespace App\Services\API\Admin\Bundles\BundleColors;

use App\Http\Requests\API\Admin\Bundles\BundleColors\StoreBundleColorsRequest;
use App\Http\Requests\API\Admin\Bundles\BundleColors\UpdateBundleColorsRequest;
use App\Http\Resources\API\Admin\Bundles\BundleColors\BundleColorsEditResource;
use App\Http\Resources\API\Admin\Bundles\BundleColors\BundleColorsListResource;
use App\Interfaces\API\Admin\Bundles\BundleColors\BundleColorsInterface;
use App\Models\BundleColor;

class BundleColorsService implements BundleColorsInterface
{
    use \App\Traits\FileUploadTrait;

    public function getAll(int $id)
    {
        $bundleColor = BundleColor::where('bundle_id', $id)->get();
        if ($bundleColor) {
            return BundleColorsListResource::collection($bundleColor);
        } else {
            return response()->json(['message' => 'Bundle Color Not exist'], 201);
        }
    }

    public function store(StoreBundleColorsRequest $request)
    {
        $data['bundle_id'] = $request->bundle_id;
        $data['color_name'] = $request->color_name;
        if ($request->hasFile('color_image')) {
            $data['color_image'] = $this->uploadFile($request->file('color_image'));
        }
        if ($request->hasFile('image1')) {
            $data['image1'] = $this->uploadFile($request->file('image1'));
        }
        if ($request->hasFile('image2')) {
            $data['image2'] = $this->uploadFile($request->file('image2'));
        }
        if ($request->hasFile('image3')) {
            $data['image3'] = $this->uploadFile($request->file('image3'));
        }
        if ($request->hasFile('image4')) {
            $data['image4'] = $this->uploadFile($request->file('image4'));
        }
        if ($request->hasFile('image5')) {
            $data['image5'] = $this->uploadFile($request->file('image5'));
        }
        $bundleColor = BundleColor::create($data);
        if ($bundleColor) {
            return response()->json(['message' => 'Bundle Color Stored Successfully'], 200);
        } else {
            return response()->json(['message' => 'Bundle Color Not Store'], 201);
        }
    }

    public function edit(int $id)
    {
        $bundleColor = BundleColor::find($id);
        if ($bundleColor) {
            return new BundleColorsEditResource($bundleColor);
        } else {
            return response()->json(['message' => 'Bundle Color not exist'], 201);
        }
    }

    public function update(UpdateBundleColorsRequest $request, int $id)
    {
        $bundleColor = BundleColor::find($id);
        if ($bundleColor) {
            $data = [
                'bundle_id' => $request->bundle_id,
                'color_name' => $request->color_name,
            ];

            if ($request->hasFile('color_image')) {
                $this->deleteFile($bundleColor->color_image);
                $data['color_image'] = $this->uploadFile($request->file('color_image'));
            }
            if ($request->hasFile('image1')) {
                $this->deleteFile($bundleColor->image1);
                $data['image1'] = $this->uploadFile($request->file('image1'));
            }
            if ($request->hasFile('image2')) {
                $this->deleteFile($bundleColor->image2);
                $data['image2'] = $this->uploadFile($request->file('image2'));
            }
            if ($request->hasFile('image3')) {
                $this->deleteFile($bundleColor->image3);
                $data['image3'] = $this->uploadFile($request->file('image3'));
            }
            if ($request->hasFile('image4')) {
                $this->deleteFile($bundleColor->image4);
                $data['image4'] = $this->uploadFile($request->file('image4'));
            }
            if ($request->hasFile('image5')) {
                $this->deleteFile($bundleColor->image5);
                $data['image5'] = $this->uploadFile($request->file('image5'));
            }

            $bundleColor->update($data);
            return response()->json(['message' => 'Bundle Color updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Bundle Color not found'], 201);
        }
    }

    public function destroy(int $id)
    {
        $bundleColor = BundleColor::find($id);
        if ($bundleColor) {
            $this->deleteFile($bundleColor->color_image);
            $this->deleteFile($bundleColor->image1);
            $this->deleteFile($bundleColor->image2);
            $this->deleteFile($bundleColor->image3);
            $this->deleteFile($bundleColor->image4);
            $this->deleteFile($bundleColor->image5);

            $bundleColor->delete();
            return response()->json(['message' => 'Bundle Color Deleted Successfully'], 200);
        } else {
            return response()->json(['message' => 'Bundle Color not found'], 201);
        }
    }
}
