<?php

namespace App\Interfaces\API\Admin\Products\ProductColors;

use App\Http\Requests\API\Admin\Products\ProductColors\StoreProductColorsRequest;
use App\Http\Requests\API\Admin\Products\ProductColors\UpdateProductColorsRequest;
use Illuminate\Http\Request;

interface ProductColorsInterface
{
    public function getAll(Request $request, int $id);
    public function store(StoreProductColorsRequest $request);
    public function edit(int $id);
    public function update(UpdateProductColorsRequest $request, int $id);
    public function destroy(int $id);
}
