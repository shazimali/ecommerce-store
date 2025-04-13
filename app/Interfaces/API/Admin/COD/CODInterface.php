<?php

namespace App\Interfaces\API\Admin\COD;

use App\Http\Requests\API\Admin\COD\StoreCODRequest;
use App\Http\Requests\API\Admin\COD\UpdateCODRequest;
use Illuminate\Http\Request;

interface CODInterface
{
    public function getAll(Request $request);
    public function getAllCountries();
    public function store(StoreCODRequest $request);
    public function edit(int $id);
    public function update(UpdateCODRequest $request, int $id);
    public function destroy(int $id);
}
