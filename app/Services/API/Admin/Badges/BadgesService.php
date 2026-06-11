<?php

namespace App\Services\API\Admin\Badges;

use App\Models\Badge;
use Illuminate\Support\Facades\Storage;

class BadgesService
{
    /**
     * Get all badges with pagination and filters.
     */
    public function getAll(array $filters, int $perPage)
    {
        $search = $filters['search'] ?? null;
        $query = Badge::query()->with('sub_categories');

        $query->when($search, function ($q) use ($search) {
            return $q->where('title', 'like', "%{$search}%");
        });

        return $query->paginate($perPage);
    }

    /**
     * Store a new badge.
     */
    public function store(array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = Storage::disk('public')->put('badges', $data['image']);
        }

        $badge = Badge::create($data);

        if (isset($data['sub_categories'])) {
            $badge->sub_categories()->attach($data['sub_categories']);
        }

        return $badge;
    }

    /**
     * Get details of a badge for editing.
     */
    public function edit(int $id)
    {
        return Badge::with('sub_categories')->find($id);
    }

    /**
     * Update a badge.
     */
    public function update(int $id, array $data)
    {
        $badge = Badge::find($id);
        if (!$badge) {
            return null;
        }

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($badge->image) {
                Storage::disk('public')->delete($badge->image);
            }
            $data['image'] = Storage::disk('public')->put('badges', $data['image']);
        }

        $badge->update($data);

        if (isset($data['sub_categories'])) {
            $badge->sub_categories()->sync($data['sub_categories']);
        }

        return $badge;
    }

    /**
     * Delete a badge.
     */
    public function destroy(int $id): bool
    {
        $badge = Badge::find($id);
        if (!$badge) {
            return false;
        }

        if ($badge->image) {
            Storage::disk('public')->delete($badge->image);
        }

        return $badge->delete();
    }
}
