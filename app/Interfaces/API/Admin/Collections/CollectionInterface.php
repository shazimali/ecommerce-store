<?php

namespace App\Interfaces\API\Admin\Collections;

use App\Http\Requests\API\Admin\COD\StoreCODRequest;
use App\Http\Requests\API\Admin\COD\UpdateCODRequest;
use App\Http\Requests\API\Admin\Collections\StoreCollectionRequest;
use App\Http\Requests\API\Admin\Collections\UpdateCollectionRequest;
use Illuminate\Http\Request;

interface CollectionInterface
{
    public function getAll(Request $request);
    public function getAllExtra();
    public function store(StoreCollectionRequest $request);
    public function edit(int $id);
    public function update(UpdateCollectionRequest $request, int $id);
    public function destroy(int $id);
}
