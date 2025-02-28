<?php

namespace App\Interfaces\API\Admin\Categories;

use App\Http\Requests\API\Admin\Categories\StoreCategoryRequest;
use App\Http\Requests\API\Admin\Categories\UpdateCategoryRequest;
use Illuminate\Http\Request;

interface CategoryInterface
{
    public function getAll(Request $request);
    public function getAllCountries();
    public function getAllWebsites();
    public function store(StoreCategoryRequest $request);
    public function edit(int $id);
    public function update(UpdateCategoryRequest $request, int $id);
    public function destroy(int $id);
}
