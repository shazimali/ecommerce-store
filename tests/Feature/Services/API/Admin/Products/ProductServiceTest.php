<?php

namespace Tests\Feature\Services\API\Admin\Products;

use Tests\TestCase;
use App\Services\API\Admin\Products\ProductService;
use App\Models\ProductHead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $productService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productService = new ProductService();
    }

    public function test_get_all_products()
    {
        // Arrange
        ProductHead::factory()->count(15)->create();

        // Act
        $response = $this->productService->getAll([], 10);

        // Assert
        $this->assertInstanceOf(AnonymousResourceCollection::class, $response);
        $this->assertCount(10, $response);
        $this->assertEquals(15, $response->resource->total());
    }

    public function test_store_product()
    {
        // Arrange
        Storage::fake('public');
        $subCategory = \App\Models\SubCategory::factory()->create();
        
        $data = [
            'title' => 'Test Product',
            'slug' => 'test-product',
            'code' => 'TP001',
            'sku' => 'TP-SKU-001',
            'short_desc' => 'Short Description',
            'description' => 'Description',
            'status' => 'ACTIVE',
            'is_new' => true,
            'is_trending' => false,
            'is_featured' => false,
            'coming_soon' => false,
            'sub_categories' => [$subCategory->id],
        ];

        $image = \Illuminate\Http\UploadedFile::fake()->image('product.jpg');
        $data['image'] = $image;

        // Act
        $response = $this->productService->store($data);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Product Stored Successfully ', $response->getData()->message);
        
        $this->assertDatabaseHas('product_heads', [
            'title' => 'Test Product',
            'slug' => 'test-product',
        ]);
        
        $product = ProductHead::where('slug', 'test-product')->first();
        $this->assertNotNull($product->image);
        
        $this->assertTrue($product->sub_categories->contains($subCategory->id));
    }

    public function test_destroy_product()
    {
        // Arrange
        Storage::fake('public');
        $product = ProductHead::factory()->create();
        
        // Act
        $response = $this->productService->destroy($product->id);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Product deleted successfully', $response->getData()->message);
        $this->assertDatabaseMissing('product_heads', ['id' => $product->id]);
    }

    public function test_destroy_product_fails_with_subcategory()
    {
        // Arrange
        $product = ProductHead::factory()->create();
        $subCategory = \App\Models\SubCategory::factory()->create();
        $product->sub_categories()->attach($subCategory->id);
        
        // Act
        $response = $this->productService->destroy($product->id);

        // Assert
        $this->assertEquals(201, $response->getStatusCode()); 
        $this->assertEquals('Product attached with sub category, can not delete.', $response->getData()->message);
        $this->assertDatabaseHas('product_heads', ['id' => $product->id]);
    }

    public function test_edit_product()
    {
        // Arrange
        $product = ProductHead::factory()->create();
        
        // Act
        $response = $this->productService->edit($product->id);

        // Assert
        $this->assertInstanceOf(\App\Http\Resources\API\Admin\Products\ProductEditResource::class, $response);
        $this->assertEquals($product->id, $response->resource->id);
    }
}
