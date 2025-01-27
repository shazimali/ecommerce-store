<?php

namespace App\Http\Controllers\API\Admin\Websites;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Websites\StoreWebsiteRequest;
use App\Http\Requests\API\Admin\Websites\UpdateWebsiteRequest;
use App\Services\API\Admin\Websites\WebsitesService;
use Illuminate\Http\Request;

class WebsitesController extends Controller
{
    public $websiteService;

    public function __construct(WebsitesService  $websiteService)
    {
        $this->websiteService = $websiteService;
    }

    public function index(Request $request)
    {
        return $this->websiteService->getAll($request);
    }

    public function store(StoreWebsiteRequest $request)
    {
        return $this->websiteService->store($request);
    }

    public function edit(int $id)
    {
        return $this->websiteService->edit($id);
    }

    public function update(UpdateWebsiteRequest $request, int $id)
    {
        return $this->websiteService->update($request, $id);
    }

    public function destroy(int $id)
    {
        return $this->websiteService->destroy($id);
    }
}
