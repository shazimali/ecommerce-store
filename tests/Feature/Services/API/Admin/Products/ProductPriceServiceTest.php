<?php

namespace Tests\Feature\Services\API\Admin\Products;

use Tests\TestCase;
use App\Services\API\Admin\Products\ProductPriceService;
use App\Models\ProductHead;
use App\Models\ProductHeadPrice;
use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductPriceServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $productPriceService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productPriceService = new ProductPriceService();
    }

    public function test_get_prices_by_product_id()
    {
        // Arrange
        $product = ProductHead::factory()->create();
        ProductHeadPrice::factory()->count(3)->create(['product_head_id' => $product->id]);

        // Act
        $response = $this->productPriceService->getPricesByProductID($product->id);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $data = $response->getData();
        $this->assertCount(3, $data->prices);
    }

    public function test_store_price()
    {
        // Arrange
        $product = ProductHead::factory()->create();
        $country = Country::factory()->create();
        
        $data = [
            'product_head_id' => $product->id,
            'country_id' => $country->id,
            'price' => 100.50,
            'discount' => 10,
        ];

        // Act
        $response = $this->productPriceService->storePrice($data);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Product price saved successfully.', $response->getData()->message);
        
        $this->assertDatabaseHas('product_head_prices', [
            'product_head_id' => $product->id,
            'country_id' => $country->id,
            'price' => 100.50,
        ]);
    }

    public function test_edit_price()
    {
        // Arrange
        $price = ProductHeadPrice::factory()->create();
        
        // Act
        $response = $this->productPriceService->editPrice($price->id);

        // Assert
        $this->assertInstanceOf(\App\Http\Resources\API\Admin\Products\ProductPricesEditResource::class, $response);
        $this->assertEquals($price->id, $response->resource->id);
    }

    public function test_update_price()
    {
        // Arrange
        $price = ProductHeadPrice::factory()->create();
        
        $data = [
            'price' => 200.00,
            'discount' => 20,
        ];
        
        // Act
        $response = $this->productPriceService->updatePrice($price->id, $data);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Product price updated successfully.', $response->getData()->message);
        
        $this->assertDatabaseHas('product_head_prices', [
            'id' => $price->id,
            'price' => 200.00,
        ]);
    }

    public function test_delete_price()
    {
        // Arrange
        $price = ProductHeadPrice::factory()->create();
        
        // Act
        $response = $this->productPriceService->deletePrice($price->id);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Product price deleted successfully.', $response->getData()->message);
        $this->assertDatabaseMissing('product_head_prices', ['id' => $price->id]);
    }
}
