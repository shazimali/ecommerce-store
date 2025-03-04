<?php

namespace App\Http\Controllers\API\Admin\Facilities;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Facilities\StoreFacilitiesRequest;
use App\Http\Requests\API\Admin\Facilities\UpdateFacilitiesRequest;
use App\Services\API\Admin\Facilities\FacilitiesService;
use Illuminate\Http\Request;

class FacilitiesController extends Controller
{
    public $facilitiesService;

    public function __construct(FacilitiesService $facilitiesService)
    {
        $this->facilitiesService = $facilitiesService;
    }

    public function index(Request $request)
    {
        return $this->facilitiesService->getAll($request);
    }

    public function getAllCountries()
    {
        return $this->facilitiesService->getAllCountries();
    }

    public function store(StoreFacilitiesRequest $request)
    {
        return $this->facilitiesService->store($request);
    }

    public function edit(int $id)
    {
        return $this->facilitiesService->edit($id);
    }

    public function update(UpdateFacilitiesRequest $request, int $id)
    {
        return $this->facilitiesService->update($request, $id);
    }

    public function destroy(int $id)
    {
        return $this->facilitiesService->destroy($id);
    }
}
