<?php

namespace App\Services\API\Admin\Banners;

use App\Http\Requests\API\Admin\Banners\StoreBannerRequest;
use App\Http\Requests\API\Admin\Banners\UpdateBannerRequest;
use App\Http\Resources\API\Admin\Banners\BannerEditResource;
use App\Http\Resources\API\Admin\Banners\BannerListResource;
use App\Http\Resources\API\Admin\Websites\WebsiteListResource;
use App\Interfaces\API\Admin\Banners\BannerInterface;
use App\Models\Banner;
use App\Models\BannerWebsite;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannersService implements BannerInterface
{
    public function getAll(Request $request)
    {
        $search = $request->search;
        $website_id = $request->website_id;

        $query = Banner::query();

        $query->when($search, function ($q) use ($search) {
            return $q->where('title', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
        });

        $query->when($website_id, function ($q) use ($website_id) {
            return $q->whereHas('websites', function ($inner_q) use ($website_id) {
                return $inner_q->where('id', $website_id);
            });
        });

        return BannerListResource::collection($query->paginate($request->item_per_page));
    }

    public function getAllWebsites()
    {
        $websites = Website::active()->get();
        if ($websites) {
            return WebsiteListResource::collection($websites);
        }
        return response()->json(['message' => 'No website found'], 201);
    }

    public function store(StoreBannerRequest $request)
    {
        $data = $request->except('websites');
        try {
            if ($request->hasFile('image')) {
                $data['image'] = Storage::disk('public')->put('/', $request->file('image'));
            }
            if ($request->hasFile('mob_image')) {
                $data['mob_image'] = Storage::disk('public')->put('/', $request->file('mob_image'));
            }
            $banners = Banner::create($data);
            $banners->websites()->attach($request->websites);

            return response()->json(['message' => 'Banner Stored Successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 201);
        }
    }

    public function edit(int $id)
    {
        $banner = Banner::with('websites')->find($id);
        if ($banner) {
            return new BannerEditResource($banner);
        } else {
            return response()->json(['message' => 'Banners not found'], 201);
        }
    }

    public function update(UpdateBannerRequest $request, int $id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            $data = [
                'title' => $request->title,
                'heading' => $request->heading,
                'sub_heading' => $request->sub_heading,
                'btn_text' => $request->btn_text,
                'btn_link' => $request->btn_link,
                'order' => $request->order,
            ];
            if ($request->hasFile('image')) {
                if (!is_null($banner->image) &&  Storage::exists($banner->image)) {
                    Storage::delete($banner->image);
                }
                $data['image'] = Storage::disk('public')->put('/', $request->file('image'));
            }
            if ($request->hasFile('mob_image')) {
                if (!is_null($banner->mob_image) &&  Storage::exists($banner->mob_image)) {
                    Storage::delete($banner->mob_image);
                }
                $data['mob_image'] = Storage::disk('public')->put('/', $request->file('mob_image'));
            }
            $banner->update($data);
            $banner->websites()->sync($request->websites);
            return  response()->json(['message' => 'Banner updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Banner not found'], 201);
        }
    }

    public function destroy(int $id)
    {
        $banner = Banner::with('websites')->whereId($id)->first();
        if ($banner) {
            $is_banner_attached_with_website = BannerWebsite::where('website_id', $id)->first();
            if ($is_banner_attached_with_website)
                return  response()->json(['message' => 'Banners attached with website, can not delete.'], 201);

            if (!is_null($banner->image) && Storage::exists($banner->image)) {
                Storage::delete($banner->image);
            }
            if (!is_null($banner->mob_image) && Storage::exists($banner->mob_image)) {
                Storage::delete($banner->mob_image);
            }
            $banner->delete();
            return  response()->json(['message' => 'Banners deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Banners not found'], 201);
        }
    }
}
