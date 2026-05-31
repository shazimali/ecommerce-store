<?php

namespace App\Interfaces\API\Admin\Collections;

use App\Http\Requests\API\Admin\COD\StoreCODRequest;
use App\Http\Requests\API\Admin\COD\UpdateCODRequest;
use App\Http\Requests\API\Admin\Collections\StoreCollectionRequest;
use App\Http\Requests\API\Admin\Collections\UpdateCollectionRequest;
use Illuminate\Http\Request;

interface CollectionInterface
{
    public function getAll(array $filters, int $perPage);
    public function getAllExtra();
    public function store(array $data);
    public function edit(int $id);
    public function update(int $id, array $data);
    public function destroy(int $id);
}
