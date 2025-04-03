<?php

namespace App\Http\Controllers\API\Admin\SocialMedias;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\SocialMedias\StoreSocialMediasRequest;
use App\Http\Requests\API\Admin\SocialMedias\UpdateSocialMediasRequest;
use App\Services\API\Admin\SocialMedias\SocialMediasService;
use Illuminate\Http\Request;

class SocialMediasController extends Controller
{
    public $socialMediasService;

    public function __construct(SocialMediasService $socialMediasService)
    {
        $this->socialMediasService = $socialMediasService;
    }

    public function index(Request $request)
    {
        $this->authorize('social_media_access');
        return $this->socialMediasService->getAll($request);
    }

    public function getAllWebsites()
    {
        $this->authorize('social_media_access');
        return $this->socialMediasService->getAllWebsites();
    }

    public function store(StoreSocialMediasRequest $request)
    {
        $this->authorize('social_media_create');
        return $this->socialMediasService->store($request);
    }

    public function edit(int $id)
    {
        $this->authorize('social_media_edit');
        return $this->socialMediasService->edit($id);
    }

    public function update(UpdateSocialMediasRequest $request, int $id)
    {
        $this->authorize('social_media_edit');
        return $this->socialMediasService->update($request, $id);
    }

    public function destroy(int $id)
    {
        $this->authorize('social_media_delete');
        return $this->socialMediasService->destroy($id);
    }
}
