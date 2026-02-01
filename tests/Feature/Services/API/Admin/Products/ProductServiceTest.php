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
        $request = Request::create('/api/admin/products', 'GET', ['items_per_page' => 10]);
        $response = $this->productService->getAll($request);

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
        
        $request = \App\Http\Requests\API\Admin\Products\StoreProductRequest::create('/api/admin/products', 'POST', $data);
        $request->files->set('image', $image);

        // Act
        $response = $this->productService->store($request);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Product Stored Successfully ', $response->getData()->message);
        
        $this->assertDatabaseHas('product_heads', [
            'title' => 'Test Product',
            'slug' => 'test-product',
        ]);
        
        $product = ProductHead::where('slug', 'test-product')->first();
        $this->assertNotNull($product->image);
        // We can't easily check actual file storage with simple fake() if method uses custom upload logic, 
        // but we can check the DB record has a path.
        
        $this->assertTrue($product->sub_categories->contains($subCategory->id));
    }

    public function test_destroy_product()
    {
        // Arrange
        Storage::fake('public');
        $product = ProductHead::factory()->create();
        // Ensure no sub-category attached to allow deletion
        
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
        $this->assertEquals(201, $response->getStatusCode()); // Service returns 201 on error
        $this->assertEquals('Product attached with sub category, can not delete.', $response->getData()->message);
        $this->assertDatabaseHas('product_heads', ['id' => $product->id]);
    }

    public function test_store_price()
    {
        // Arrange
        $product = ProductHead::factory()->create();
        $country = \App\Models\Country::factory()->create();
        
        $data = [
            'product_head_id' => $product->id,
            'country_id' => $country->id,
            'price' => 100.50,
            'discount' => 10,
        ];
        
        $request = \App\Http\Requests\API\Admin\Products\StoreProductPriceRequest::create('/api/admin/products/prices', 'POST', $data);
        
        // Act
        $response = $this->productService->storePrice($request);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Product price saved successfully.', $response->getData()->message);
        
        $this->assertDatabaseHas('product_head_prices', [
            'product_head_id' => $product->id,
            'country_id' => $country->id,
            'price' => 100.50,
        ]);
    }

    public function test_update_price()
    {
        // Arrange
        $price = \App\Models\ProductHeadPrice::factory()->create();
        
        $data = [
            'price' => 200.00,
            'discount' => 20,
        ];
        
        $request = \App\Http\Requests\API\Admin\Products\UpdateProductPriceRequest::create('/api/admin/products/prices/' . $price->id, 'PUT', $data);
        
        // Act
        $response = $this->productService->updatePrice($request, $price->id);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Product price updated successfully.', $response->getData()->message);
        
        $this->assertDatabaseHas('product_head_prices', [
            'id' => $price->id,
            'price' => 200.00,
        ]);
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

    public function test_edit_price()
    {
        // Arrange
        $price = \App\Models\ProductHeadPrice::factory()->create();
        
        // Act
        $response = $this->productService->editPrice($price->id);

        // Assert
        $this->assertInstanceOf(\App\Http\Resources\API\Admin\Products\ProductPricesEditResource::class, $response);
        $this->assertEquals($price->id, $response->resource->id);
    }

    public function test_delete_price()
    {
        // Arrange
        $price = \App\Models\ProductHeadPrice::factory()->create();
        
        // Act
        $response = $this->productService->deletePrice($price->id);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Product price deleted successfully.', $response->getData()->message);
        $this->assertDatabaseMissing('product_head_prices', ['id' => $price->id]);
    }
}
