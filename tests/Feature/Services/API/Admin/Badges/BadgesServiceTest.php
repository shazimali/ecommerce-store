<?php

namespace Tests\Feature\Services\API\Admin\Badges;

use App\Models\Badge;
use App\Models\SubCategory;
use App\Services\API\Admin\Badges\BadgesService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BadgesServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected BadgesService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BadgesService();
    }

    public function test_get_all_returns_paginated_badges()
    {
        Badge::create([
            'title' => 'Badge 1',
            'status' => 'ACTIVE',
            'image' => 'badges/badge1.jpg'
        ]);

        Badge::create([
            'title' => 'Badge 2',
            'status' => 'ACTIVE',
            'image' => 'badges/badge2.jpg'
        ]);

        $filters = [];
        $perPage = 10;

        $result = $this->service->getAll($filters, $perPage);

        $this->assertInstanceOf(\Illuminate\Contracts\Pagination\LengthAwarePaginator::class, $result);
        $this->assertEquals(2, $result->count());
    }

    public function test_store_creates_badge_with_relationships_and_image()
    {
        Storage::fake('public');

        $subCategory = SubCategory::create([
            'title' => 'Test SubCat',
            'slug' => 'test-subcat',
            'order' => 1,
            'image' => 'subcategories/test.jpg'
        ]);

        $data = [
            'title' => 'New Badge',
            'status' => 'ACTIVE',
            'image' => UploadedFile::fake()->image('badge.jpg'),
            'sub_categories' => [$subCategory->id]
        ];

        $badge = $this->service->store($data);

        $this->assertInstanceOf(Badge::class, $badge);
        $this->assertDatabaseHas('badges', [
            'title' => 'New Badge',
            'status' => 'ACTIVE'
        ]);

        $this->assertCount(1, $badge->sub_categories);
        Storage::disk('public')->assertExists($badge->image);
    }

    public function test_edit_returns_badge_model()
    {
        $badge = Badge::create([
            'title' => 'Badge 1',
            'status' => 'ACTIVE',
            'image' => 'badges/test.jpg'
        ]);

        $result = $this->service->edit($badge->id);

        $this->assertInstanceOf(Badge::class, $result);
        $this->assertEquals($badge->id, $result->id);
    }

    public function test_update_modifies_badge_and_syncs_subcategories()
    {
        Storage::fake('public');

        $badge = Badge::create([
            'title' => 'Old Title',
            'status' => 'ACTIVE',
            'image' => 'badges/old.jpg'
        ]);

        $subCategory = SubCategory::create([
            'title' => 'Test SubCat',
            'slug' => 'test-subcat',
            'order' => 1,
            'image' => 'subcategories/test.jpg'
        ]);

        $data = [
            'title' => 'Updated Title',
            'status' => 'INACTIVE',
            'sub_categories' => [$subCategory->id],
            'image' => UploadedFile::fake()->image('new.jpg')
        ];

        $updatedBadge = $this->service->update($badge->id, $data);

        $this->assertInstanceOf(Badge::class, $updatedBadge);
        $this->assertDatabaseHas('badges', [
            'id' => $badge->id,
            'title' => 'Updated Title',
            'status' => 'INACTIVE'
        ]);

        $badge->refresh();
        $this->assertCount(1, $badge->sub_categories);
        Storage::disk('public')->assertExists($badge->image);
    }

    public function test_destroy_deletes_badge_and_relationship()
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('test.jpg');
        $imagePath = Storage::disk('public')->put('badges', $image);

        $badge = Badge::create([
            'title' => 'To Delete',
            'status' => 'ACTIVE',
            'image' => $imagePath
        ]);

        $subCategory = SubCategory::create([
            'title' => 'Test SubCat',
            'slug' => 'test-subcat',
            'order' => 1,
            'image' => 'subcategories/test.jpg'
        ]);

        $badge->sub_categories()->attach($subCategory);

        $result = $this->service->destroy($badge->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('badges', ['id' => $badge->id]);
        $this->assertDatabaseMissing('badge_sub_category', [
            'badge_id' => $badge->id,
            'sub_category_id' => $subCategory->id
        ]);

        Storage::disk('public')->assertMissing($imagePath);
    }
}
