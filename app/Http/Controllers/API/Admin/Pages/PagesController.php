<?php

namespace App\Http\Controllers\API\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Pages\StorePagesRequest;
use App\Http\Requests\API\Admin\Pages\UpdatePagesRequest;
use App\Services\API\Admin\Pages\PagesService;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public $pagesService;

    public function __construct(PagesService $pagesService)
    {
        $this->pagesService = $pagesService;
    }

    public function index(Request $request)
    {
        $this->authorize('page_access');
        return $this->pagesService->getAll($request);
    }

    public function getAllCountries()
    {
        return $this->pagesService->getAllCountries();
    }

    public function store(StorePagesRequest $request)
    {
        $this->authorize('page_create');
        return $this->pagesService->store($request);
    }

    public function edit(int $id)
    {
        $this->authorize('page_edit');
        return $this->pagesService->edit($id);
    }

    public function update(UpdatePagesRequest $request, int $id)
    {
        $this->authorize('page_edit');
        return $this->pagesService->update($request, $id);
    }

    public function destroy(int $id)
    {
        $this->authorize('page_delete');
        return $this->pagesService->destroy($id);
    }
}
