<?php

namespace App\Http\controllers\API\Admin\Banners;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Banners\StoreBannerRequest;
use App\Http\Requests\API\Admin\Banners\UpdateBannerRequest;
use App\Services\API\Admin\Banners\BannersService;
use Illuminate\Http\Request;

class BannersController extends Controller
{
    public  $bannerService;

    public function __construct(BannersService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index(Request $request)
    {
        $this->authorize('banner_access');
        return $this->bannerService->getAll($request);
    }

    public function getAllWebsites()
    {
        return $this->bannerService->getAllWebsites();
    }

    public function store(StoreBannerRequest $request)
    {
        $this->authorize('banner_create');
        return $this->bannerService->store($request);
    }

    public function edit(int $id)
    {
        $this->authorize('banner_update');
        return $this->bannerService->edit($id);
    }

    public function update(UpdateBannerRequest $request, int $id)
    {
        $this->authorize('banner_update');
        return $this->bannerService->update($request, $id);
    }

    public function destroy(int $id)
    {
        $this->authorize('banner_delete');
        return $this->bannerService->destroy($id);
    }
}
