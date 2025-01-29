<?php

namespace App\Interfaces\API\Admin\SubCategories;

use App\Http\Requests\API\Admin\SubCategories\StoreSubCategoryRequest;
use App\Http\Requests\API\Admin\SubCategories\UpdateSubCategoryRequest;
use Illuminate\Http\Request;

interface subCategoryInterface
{
    public function getAll(Request $request);
    public function getAllCategories();
    public function store(StoreSubCategoryRequest $request);
    public function edit(int $id);
    public function update(UpdateSubCategoryRequest $request, int $id);
    public function destroy(int $id);
}
