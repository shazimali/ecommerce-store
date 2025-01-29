<?php

namespace App\Http\Controllers\API\Admin\SubCategories;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\SubCategories\StoreSubCategoryRequest;
use App\Http\Requests\API\Admin\SubCategories\UpdateSubCategoryRequest;
use App\Services\API\Admin\SubCategories\subCategoryService;
use Illuminate\Http\Request;

class subCategoryController extends Controller
{
    public $subCategoryService;

    public function __construct(subCategoryService  $subCategoryService)
    {
        $this->subCategoryService = $subCategoryService;
    }

    public function index(Request $request)
    {
        return $this->subCategoryService->getAll($request);
    }

    public function getAllCategories()
    {
        return $this->subCategoryService->getAllCategories();
    }

    public function store(StoreSubCategoryRequest $request)
    {
        return $this->subCategoryService->store($request);
    }

    public function edit(int $id)
    {
        return $this->subCategoryService->edit($id);
    }

    public function update(UpdateSubCategoryRequest $request, int $id)
    {
        return $this->subCategoryService->update($request, $id);
    }

    public function destroy(int $id)
    {
        return $this->subCategoryService->destroy($id);
    }
}
