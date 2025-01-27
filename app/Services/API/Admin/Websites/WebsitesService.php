<?php

namespace App\Services\API\Admin\Websites;

use App\Http\Requests\API\Admin\Websites\StoreWebsiteRequest;
use App\Http\Requests\API\Admin\Websites\UpdateWebsiteRequest;
use App\Http\Resources\API\Admin\Websites\WebsiteEditResource;
use App\Http\Resources\API\Admin\Websites\WebsiteListResource;
use App\Interfaces\API\Admin\Websites\WebsitesInterface;
use App\Models\Website;
use Illuminate\Http\Request;

class WebsitesService implements WebsitesInterface
{

    public function getAll(Request $request)
    {
        $itemsPerPage = $request->get('item_per_page', 10);
        $websites = Website::paginate($itemsPerPage);
        if ($websites) {
            return  WebsiteListResource::collection($websites);
        } else {
            return response()->json(['message' => 'Website not found'], 200);
        }
    }

    public function store(StoreWebsiteRequest $request)
    {
        $websites = Website::create($request->all());
        if ($websites) {
            return response()->json(['message' => 'Website Stored Successfully'], 200);
        } else {
            return response()->json(['message' => 'Website Not found'], 500);
        }
    }
    public function edit(int $id)
    {
        $websites = Website::find($id);
        if ($websites) {
            return new WebsiteEditResource($websites);
        } else {
            return response()->json(['message' => 'Data does not exist'], 500);
        }
    }
    public function update(UpdateWebsiteRequest $request, int $id)
    {
        $websites = Website::find($id);
        if ($websites) {
            $data = [
                'title' => $request->title,
                'domain' => $request->domain,
                'phone' => $request->phone,
                'phone1' => $request->phone1,
                'address' => $request->address,
                'logo' => $request->logo,
                'news' => $request->news,
                'email' => $request->email,
                'status' => $request->status,
                'order' => $request->order,
                'wel_msg' => $request->wel_msg,
                'about' => $request->about,

            ];
            $websites->update($data);
            return response()->json(['message', 'Data Updated Successfully'], 200);
        } else {
            return response()->json(['message', 'Data Not Updated'], 201);
        }
    }
    public function destroy(int $id)
    {
        $websites = Website::find($id);
        if ($websites) {
            $websites->delete();
            return response()->json(['message' => 'Website delete Successfully'], 200);
        } else {
            return response()->json(['message' => 'Website not exist'], 404);
        }
    }
}
