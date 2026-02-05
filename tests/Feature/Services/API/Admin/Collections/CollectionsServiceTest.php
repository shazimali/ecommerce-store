<?php

namespace Tests\Feature\Services\API\Admin\Collections;

use App\Models\Collection;
use App\Models\Website;
use App\Models\ProductHead;
use App\Services\API\Admin\Collections\CollectionsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Http\Requests\API\Admin\Collections\StoreCollectionRequest;
use App\Http\Requests\API\Admin\Collections\UpdateCollectionRequest;

class CollectionsServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected CollectionsService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CollectionsService();
    }

    public function test_get_all_returns_paginated_collection()
    {
        Collection::create([
            'title' => 'Collection 1',
            'slug' => 'collection-1',
            'status' => 'ACTIVE',
            'order' => 1,
            'position' => 'TOP',
            'image' => 'images/collection1.jpg',
            'mob_image' => 'images/collection1_mob.jpg'
        ]);

        Collection::create([
            'title' => 'Collection 2',
            'slug' => 'collection-2',
            'status' => 'ACTIVE',
            'order' => 2,
            'position' => 'TOP',
            'image' => 'images/collection2.jpg',
            'mob_image' => 'images/collection2_mob.jpg'
        ]);

        $filters = [];
        $perPage = 10;

        $result = $this->service->getAll($filters, $perPage);

        $this->assertInstanceOf(\Illuminate\Contracts\Pagination\LengthAwarePaginator::class, $result);
        $this->assertEquals(2, $result->count());
    }

    public function test_store_creates_collection_with_relationships_and_images()
    {
        Storage::fake('public');
        
        $website = Website::create([
            'title' => 'Test Website',
            'domain' => 'test.com',
            'phone' => '1234567890',
            'status' => 'ACTIVE'
        ]);

        $product = ProductHead::factory()->create();

        $data = [
            'title' => 'New Collection',
            'slug' => 'new-collection',
            'status' => 'ACTIVE',
            'order' => 1,
            'position' => 'TOP',
            'image' => UploadedFile::fake()->image('collection.jpg'),
            'mob_image' => UploadedFile::fake()->image('collection_mob.jpg'),
            'websites' => [$website->id],
            'products' => [$product->id]
        ];

        $collection = $this->service->store($data);

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertDatabaseHas('collections', [
            'title' => 'New Collection',
            'slug' => 'new-collection'
        ]);
        
        $this->assertCount(1, $collection->websites);
        $this->assertCount(1, $collection->products);
        
        Storage::disk('public')->assertExists($collection->image);
        Storage::disk('public')->assertExists($collection->mob_image);
    }

    public function test_edit_returns_collection_model()
    {
        $collection = Collection::create([
            'title' => 'Collection 1',
            'slug' => 'collection-1',
            'status' => 'ACTIVE',
            'order' => 1,
            'position' => 'TOP',
            'image' => 'images/test.jpg',
            'mob_image' => 'images/test_mob.jpg'
        ]);

        $result = $this->service->edit($collection->id);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals($collection->id, $result->id);
    }

    public function test_update_modifies_collection_and_relationships()
    {
        Storage::fake('public');

        $collection = Collection::create([
            'title' => 'Old Title',
            'slug' => 'old-slug',
            'status' => 'ACTIVE',
            'order' => 1,
            'position' => 'TOP',
            'image' => 'images/old.jpg',
            'mob_image' => 'images/old_mob.jpg'
        ]);

        $website = Website::create([
            'title' => 'Test Website',
            'domain' => 'test.com',
            'phone' => '1234567890',
            'status' => 'ACTIVE'
        ]);

        $product = ProductHead::factory()->create();

        $data = [
            'title' => 'Updated Title',
            'slug' => 'updated-slug',
            'status' => 'INACTIVE',
            'order' => 2,
            'position' => 'BOTTOM',
            'websites' => [$website->id],
            'products' => [$product->id],
            'image' => UploadedFile::fake()->image('new.jpg'),
            'mob_image' => UploadedFile::fake()->image('new_mob.jpg')
        ];

        $updatedCollection = $this->service->update($collection->id, $data);

        $this->assertInstanceOf(Collection::class, $updatedCollection);
        $this->assertDatabaseHas('collections', [
            'id' => $collection->id,
            'title' => 'Updated Title',
            'slug' => 'updated-slug',
            'status' => 'INACTIVE'
        ]);

        $collection->refresh();
        $this->assertCount(1, $collection->websites);
        $this->assertCount(1, $collection->products);
        
        Storage::disk('public')->assertExists($collection->image);
        Storage::disk('public')->assertExists($collection->mob_image);
    }

    public function test_destroy_deletes_collection_and_relationships()
    {
        Storage::fake('public');
        
        $image = UploadedFile::fake()->image('test.jpg');
        $imagePath = Storage::disk('public')->put('/', $image);

        $collection = Collection::create([
            'title' => 'To Delete',
            'slug' => 'to-delete',
            'status' => 'ACTIVE',
            'order' => 1,
            'position' => 'TOP',
            'image' => $imagePath,
            'mob_image' => $imagePath
        ]);

        $website = Website::create([
            'title' => 'Test Website',
            'domain' => 'test.com',
            'phone' => '1234567890',
            'status' => 'ACTIVE'
        ]);

        $collection->websites()->attach($website);

        $result = $this->service->destroy($collection->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('collections', ['id' => $collection->id]);
        $this->assertDatabaseMissing('collection_website', [
            'collection_id' => $collection->id,
            'website_id' => $website->id
        ]);
        
        Storage::disk('public')->assertMissing($imagePath);
    }
}
