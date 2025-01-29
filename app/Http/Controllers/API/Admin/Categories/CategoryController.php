<?php

namespace App\Http\Controllers\API\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Categories\StoreCategoryRequest;
use App\Http\Requests\API\Admin\Categories\UpdateCategoryRequest;
use App\Services\API\Admin\Categories\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {

        return $this->categoryService->getAll($request);
    }

    public function getAllCountries()
    {
        return $this->categoryService->getAllCountries();
    }

    public function store(StoreCategoryRequest $request)
    {
        return $this->categoryService->store($request);
    }

    public function edit(int $id)
    {
        return $this->categoryService->edit($id);
    }

    public function update(UpdateCategoryRequest $request, int $id)
    {
        return $this->categoryService->update($request, $id);
    }

    public function destroy(int $id)
    {
        return $this->categoryService->destroy($id);
    }
}
