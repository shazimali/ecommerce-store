<?php

namespace App\Http\Controllers\API\Admin\Badges;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Badges\StoreBadgeRequest;
use App\Http\Requests\API\Admin\Badges\UpdateBadgeRequest;
use App\Http\Resources\API\Admin\Badges\BadgeEditResource;
use App\Http\Resources\API\Admin\Badges\BadgeListResource;
use App\Models\SubCategory;
use App\Services\API\Admin\Badges\BadgesService;
use Illuminate\Http\Request;

class BadgesController extends Controller
{
    protected $badgesService;

    public function __construct(BadgesService $badgesService)
    {
        $this->badgesService = $badgesService;
    }

    public function index(Request $request)
    {
        $this->authorize('badge_access');

        $filters = [
            'search' => $request->search,
        ];

        $badges = $this->badgesService->getAll($filters, $request->item_per_page ?? 10);

        return BadgeListResource::collection($badges);
    }

    public function store(StoreBadgeRequest $request)
    {
        $this->authorize('badge_create');

        $data = $request->validated();

        $badge = $this->badgesService->store($data);

        if ($badge) {
            return response()->json(['message' => 'Badge Stored Successfully'], 200);
        }

        return response()->json(['message' => 'Badge Not Stored'], 422);
    }

    public function edit(int $id)
    {
        $this->authorize('badge_edit');

        $badge = $this->badgesService->edit($id);

        if ($badge) {
            return new BadgeEditResource($badge);
        }

        return response()->json(['message' => 'Badge does not exist'], 404);
    }

    public function update(UpdateBadgeRequest $request, int $id)
    {
        $this->authorize('badge_edit');

        $data = $request->validated();

        $badge = $this->badgesService->update($id, $data);

        if ($badge) {
            return response()->json(['message' => 'Badge updated successfully.'], 200);
        }

        return response()->json(['message' => 'Badge not found'], 404);
    }

    public function destroy(int $id)
    {
        $this->authorize('badge_delete');

        $deleted = $this->badgesService->destroy($id);

        if ($deleted) {
            return response()->json(['message' => 'Badge deleted successfully.'], 200);
        }

        return response()->json(['message' => 'Badge not found'], 404);
    }

    public function getAllSubCategories()
    {
        $this->authorize('badge_create');

        $subCategories = SubCategory::select('id', 'title')->get();

        return response()->json($subCategories, 200);
    }
}
