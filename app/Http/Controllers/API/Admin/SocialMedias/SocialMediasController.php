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
        return $this->socialMediasService->getAll($request);
    }

    public function store(StoreSocialMediasRequest $request)
    {
        return $this->socialMediasService->store($request);
    }

    public function edit(int $id)
    {
        return $this->socialMediasService->edit($id);
    }

    public function update(UpdateSocialMediasRequest $request, int $id)
    {
        return $this->socialMediasService->update($request, $id);
    }

    public function destroy(int $id)
    {
        return $this->socialMediasService->destroy($id);
    }
}
