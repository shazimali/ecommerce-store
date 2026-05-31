<?php

namespace App\Http\Controllers\API\Admin\Collections;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Collections\StoreCollectionRequest;
use App\Http\Requests\API\Admin\Collections\UpdateCollectionRequest;
use App\Interfaces\API\Admin\Collections\CollectionInterface;
use App\Http\Resources\API\Admin\Collections\CollectionsListResource;
use App\Http\Resources\API\Admin\Collections\CollectionEditResource;
use Illuminate\Http\Request;

class CollectionsController extends Controller
{
    protected $collectionService;

    public function __construct(CollectionInterface $collectionService)
    {
        $this->collectionService = $collectionService;
    }

    public function index(Request $request)
    {
        $this->authorize('collection_access');
        
        $filters = [
            'search' => $request->search,
            'country_id' => $request->country_id,
        ];

        $collections = $this->collectionService->getAll($filters, $request->item_per_page ?? 10);
        
        return CollectionsListResource::collection($collections);
    }

    public function getAllExtra()
    {
        $this->authorize('collection_create');
        
        return response()->json($this->collectionService->getAllExtra(), 200);
    }

    public function store(StoreCollectionRequest $request)
    {
        $this->authorize('collection_create');
        
        $data = $request->validated();
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }
        
        if ($request->hasFile('mob_image')) {
            $data['mob_image'] = $request->file('mob_image');
        }

        $collection = $this->collectionService->store($data);

        if ($collection) {
            return response()->json(['message' => 'Collection Stored Successfully'], 200);
        }

        return response()->json(['message' => 'Collection Not Stored'], 422);
    }

    public function edit(int $id)
    {
        $this->authorize('collection_edit');
        
        $collection = $this->collectionService->edit($id);

        if ($collection) {
            return new CollectionEditResource($collection);
        }

        return response()->json(['message' => 'Collection does not exist'], 404);
    }

    public function update(UpdateCollectionRequest $request, int $id)
    {
        $this->authorize('collection_edit');
        
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }
        
        if ($request->hasFile('mob_image')) {
            $data['mob_image'] = $request->file('mob_image');
        }

        $collection = $this->collectionService->update($id, $data);

        if ($collection) {
            return response()->json(['message' => 'Collection updated successfully.'], 200);
        }

        return response()->json(['message' => 'Collection not found'], 404);
    }

    public function destroy(int $id)
    {
        $this->authorize('collection_delete');
        
        $deleted = $this->collectionService->destroy($id);

        if ($deleted) {
            return response()->json(['message' => 'Category deleted successfully.'], 200);
        }

        return response()->json(['message' => 'Category not found'], 404);
    }
}
