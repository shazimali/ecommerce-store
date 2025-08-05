<?php

namespace App\Http\Controllers\API\Admin\Collections;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Collections\StoreCollectionRequest;
use App\Http\Requests\API\Admin\Collections\UpdateCollectionRequest;
use App\Services\API\Admin\Collections\CollectionsService;
use Illuminate\Http\Request;

class CollectionsController extends Controller
{
    public $collectionService;

    public function __construct(CollectionsService $collectionService)
    {
        $this->collectionService = $collectionService;
    }

    public function index(Request $request)
    {
        $this->authorize('collection_access');
        return $this->collectionService->getAll($request);
    }

    public function getAllExtra()
    {
        $this->authorize('collection_create');
        return $this->collectionService->getAllExtra();
    }

    public function store(StoreCollectionRequest $request)
    {
        $this->authorize('collection_create');
        return $this->collectionService->store($request);
    }

    public function edit(int $id)
    {
        $this->authorize('collection_edit');
        return $this->collectionService->edit($id);
    }

    public function update(UpdateCollectionRequest $request, int $id)
    {
        $this->authorize('collection_edit');
        return $this->collectionService->update($request, $id);
    }

    public function destroy(int $id)
    {
        $this->authorize('collection_delete');
        return $this->collectionService->destroy($id);
    }
}
