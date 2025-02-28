<?php

namespace App\Services\API\Admin\Websites;

use App\Http\Requests\API\Admin\Websites\StoreWebsiteRequest;
use App\Http\Requests\API\Admin\Websites\UpdateWebsiteRequest;
use App\Http\Resources\API\Admin\Websites\WebsiteEditResource;
use App\Http\Resources\API\Admin\Websites\WebsiteListResource;
use App\Interfaces\API\Admin\Websites\WebsitesInterface;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebsitesService implements WebsitesInterface
{

    public function getAll(Request $request)
    {
        $websites = Website::where('title', 'like', "%{$request->search}%")
            ->orWhere('domain', 'like', "%{$request->search}%")
            ->orWhere('phone', 'like', "%{$request->search}%")
            ->orWhere('email', 'like', "%{$request->search}%")
            ->orWhere('order', 'like', "%{$request->search}%")
            ->orWhere('status', 'like', "%{$request->search}%")
            ->paginate($request->item_per_page);
        if ($websites) {
            return  WebsiteListResource::collection($websites);
        } else {
            return response()->json(['message' => 'Website not found'], 200);
        }
    }

    public function store(StoreWebsiteRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('logo')) {
            $data['logo'] = Storage::disk('public')->put('/', $request->file('logo'));
        }
        $website = Website::create($data);
        if ($website) {
            return response()->json(['message' => 'Website Stored Successfully'], 200);
        } else {
            return response()->json(['message' => 'Website Not found'], 201);
        }
    }
    public function edit(int $id)
    {
        $websites = Website::find($id);
        if ($websites) {
            return new WebsiteEditResource($websites);
        } else {
            return response()->json(['message' => 'Data does not exist'], 201);
        }
    }
    public function update(UpdateWebsiteRequest $request, int $id)
    {
        $website = Website::find($id);
        if ($website) {
            $data = [
                'title' => $request->title,
                'domain' => $request->domain,
                'phone' => $request->phone,
                'phone1' => $request->phone1,
                'address' => $request->address,
                'news' => $request->news,
                'email' => $request->email,
                'status' => $request->status,
                'order' => $request->order,
                'wel_msg' => $request->wel_msg,
                'about' => $request->about,
            ];
            if ($request->hasFile('logo')) {
                if (Storage::exists($website->logo)) {
                    Storage::delete($website->logo);
                }
                $data['logo'] = Storage::disk('public')->put('/', $request->file('logo'));
            }
            $website->update($data);

            return response()->json(['message' => 'Website Updated Successfully'], 200);
        } else {
            return response()->json(['message' => 'Website Not Updated'], 201);
        }
    }
    public function destroy(int $id)
    {
        $websites = Website::find($id);
        if ($websites) {
            $websites->delete();
            return response()->json(['message' => 'Website delete Successfully'], 200);
        } else {
            return response()->json(['message' => 'Website not exist'], 201);
        }
    }
}
