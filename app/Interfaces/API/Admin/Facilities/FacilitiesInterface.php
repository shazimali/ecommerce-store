<?php

namespace App\Interfaces\API\Admin\Facilities;

use App\Http\Requests\API\Admin\Facilities\StoreFacilitiesRequest;
use App\Http\Requests\API\Admin\Facilities\UpdateFacilitiesRequest;
use Illuminate\Http\Request;

interface FacilitiesInterface
{
    public function getAll(Request $request);
    public function getAllCountries();
    public function store(StoreFacilitiesRequest $request);
    public function edit(int $id);
    public function update(UpdateFacilitiesRequest $request, int $id);
    public function destroy(int $id);
}
