<?php

namespace App\Interfaces\API\Admin\ProductColors;

use App\Http\Requests\API\Admin\ProductColors\StoreProductColorRequest;
use App\Http\Requests\API\Admin\ProductColors\UpdateProductColorRequest;
use Illuminate\Http\Request;

interface ProductColorInterface
{
    public function getAll(Request $request);
    public function store(StoreProductColorRequest $request);
    public function edit(int $id);
    public function update(UpdateProductColorRequest $request, int $id);
    public function destroy(int $id);
}
