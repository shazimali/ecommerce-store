<?php

namespace App\Services\API\Admin\SocialMedias;

use App\Http\Requests\API\Admin\SocialMedias\StoreSocialMediasRequest;
use App\Http\Requests\API\Admin\SocialMedias\UpdateSocialMediasRequest;
use App\Http\Resources\API\Admin\SocialMedias\SocialMediasEditResource;
use App\Http\Resources\API\Admin\SocialMedias\SocialMediasListResource;
use App\Interfaces\API\Admin\SocialMedias\SocialMediasInterface;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediasService implements SocialMediasInterface
{
    public function getAll(Request $request)
    {
        $itemPerPage = $request->get('item_per_page', 10);
        $socialMedias = SocialMedia::paginate($itemPerPage);
        if ($socialMedias) {
            return SocialMediasListResource::collection($socialMedias);
        } else {
            return response()->json(['message', 'Social Medias Not exist'], 201);
        }
    }

    public function store(StoreSocialMediasRequest $request)
    {
        $socialMedias = SocialMedia::create($request->all());
        if ($socialMedias) {
            return response()->json(['message' => 'Social Medias Stored Successfully'], 200);
        } else {
            return response()->json(['message' => 'Social Medias Not Stored'], 201);
        }
    }

    public function edit(int $id)
    {
        $socialMedias = SocialMedia::find($id);
        if ($socialMedias) {
            return new SocialMediasEditResource($socialMedias);
        } else {
            return response()->json(['message' => 'Social Medias not exist'], 201);
        }
    }

    public function update(UpdateSocialMediasRequest $request, int $id)
    {
        $socialMedias = SocialMedia::find($id);
        if ($socialMedias) {
            $data = [
                'title' => $request->title,
                'class' => $request->class,
                'url' => $request->url
            ];
            $socialMedias->update($data);
            return  response()->json(['message' => 'Social Medias updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Social Medias not found'], 201);
        }
    }

    public function destroy(int $id)
    {
        $socialMedias = SocialMedia::find($id);
        if ($socialMedias) {
            $socialMedias->delete();
            return response()->json(['message' => 'Social Medias Deleted Successfully'], 200);
        } else {
            return response()->json(['message' => 'Social Medias not found'], 201);
        }
    }
}
