<?php

namespace App\Services\API\Admin\SocialMedias;

use App\Http\Requests\API\Admin\SocialMedias\StoreSocialMediasRequest;
use App\Http\Requests\API\Admin\SocialMedias\UpdateSocialMediasRequest;
use App\Http\Resources\API\Admin\SocialMedias\SocialMediasEditResource;
use App\Http\Resources\API\Admin\SocialMedias\SocialMediasListResource;
use App\Http\Resources\API\Admin\Websites\WebsiteListResource;
use App\Interfaces\API\Admin\SocialMedias\SocialMediasInterface;
use App\Models\SocialMedia;
use App\Models\Website;
use Illuminate\Http\Request;

class SocialMediasService implements SocialMediasInterface
{
    public function getAll(Request $request)
    {
        $socialMedias = SocialMedia::paginate($request->itemPerPage);
        if ($socialMedias) {
            return SocialMediasListResource::collection($socialMedias);
        } else {
            return response()->json(['message', 'Social Media Not exist'], 201);
        }
    }

    public function getAllWebsites()
    {
        $websites = Website::active()->get();
        if ($websites) {
            return WebsiteListResource::collection($websites);
        }
        return response()->json(['message' => 'No website found'], 201);
    }

    public function store(StoreSocialMediasRequest $request)
    {
        $data = $request->except('websites');
        $socialMedia = SocialMedia::create($data);
        if ($socialMedia) {
            $socialMedia->websites()->attach($request->websites);
            return response()->json(['message' => 'Social Media Stored Successfully'], 200);
        } else {
            return response()->json(['message' => 'Social Media Not Stored'], 201);
        }
    }

    public function edit(int $id)
    {
        $socialMedias = SocialMedia::find($id);
        if ($socialMedias) {
            return new SocialMediasEditResource($socialMedias);
        } else {
            return response()->json(['message' => 'Social Media not exist'], 201);
        }
    }

    public function update(UpdateSocialMediasRequest $request, int $id)
    {
        $socialMedia = SocialMedia::find($id);
        if ($socialMedia) {
            $data = [
                'title' => $request->title,
                'class' => $request->class,
                'url' => $request->url
            ];
            $socialMedia->update($data);
            $socialMedia->websites()->sync($request->websites);
            return  response()->json(['message' => 'Social Media updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Social Media not found'], 201);
        }
    }

    public function destroy(int $id)
    {
        $socialMedia = SocialMedia::find($id);
        if ($socialMedia) {
            $socialMedia->websites()->detach();
            $socialMedia->delete();
            return response()->json(['message' => 'Social Media Deleted Successfully'], 200);
        } else {
            return response()->json(['message' => 'Social Media not found'], 201);
        }
    }
}
