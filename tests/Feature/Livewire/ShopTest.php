<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Shop;
use App\Models\Category;
use App\Models\ProductHead;
use App\Models\SubCategory;
use App\Models\ProductColor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

use App\Models\Country;
use App\Models\Setting;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a default country for getLocation()
        $country = Country::factory()->create([
            'iso' => 'PK',
            'name' => 'Pakistan',
            'currency' => 'PKR'
        ]);

        // Create default settings for getSettingVal()
        Setting::create([
            'key' => 'shop_filter_price_from',
            'title' => 'Shop Filter Price From',
            'value' => '0',
            'country_id' => $country->id
        ]);
        Setting::create([
            'key' => 'shop_filter_price_to',
            'title' => 'Shop Filter Price To',
            'value' => '1000',
            'country_id' => $country->id
        ]);
    }

    /** @test */
    public function it_renders_successfully()
    {
        Livewire::test(Shop::class)
            ->assertStatus(200);
    }

    /** @test */
    public function it_displays_products()
    {
        $product = ProductHead::factory()->create(['title' => 'Test Product', 'status' => 'ACTIVE']);
        \App\Models\ProductHeadPrice::create([
            'product_head_id' => $product->id,
            'country_id' => Country::first()->id,
            'price' => 100,
            'discount' => 0
        ]);

        Livewire::test(Shop::class)
            ->assertSee('Test Product');
    }

    /** @test */
    public function it_filters_by_search()
    {
        $apple = ProductHead::factory()->create(['title' => 'Apple', 'status' => 'ACTIVE']);
        \App\Models\ProductHeadPrice::create([
            'product_head_id' => $apple->id,
            'country_id' => Country::first()->id,
            'price' => 100,
            'discount' => 0
        ]);

        $banana = ProductHead::factory()->create(['title' => 'Banana', 'status' => 'ACTIVE']);
        \App\Models\ProductHeadPrice::create([
            'product_head_id' => $banana->id,
            'country_id' => Country::first()->id,
            'price' => 100,
            'discount' => 0
        ]);

        Livewire::test(Shop::class)
            ->set('search', 'Apple')
            ->assertSee('Apple')
            ->assertDontSee('Banana');
    }

    /** @test */
    public function it_filters_by_color()
    {
        $product1 = ProductHead::factory()->create(['title' => 'Red Shirt', 'status' => 'ACTIVE']);
        \App\Models\ProductHeadPrice::create([
            'product_head_id' => $product1->id,
            'country_id' => Country::first()->id,
            'price' => 100,
            'discount' => 0
        ]);
        ProductColor::create([
            'product_head_id' => $product1->id, 
            'color_name' => 'Red',
            'color_image' => 'red.jpg',
            'image1' => 'red_full.jpg'
        ]);

        $product2 = ProductHead::factory()->create(['title' => 'Blue Shirt', 'status' => 'ACTIVE']);
        \App\Models\ProductHeadPrice::create([
            'product_head_id' => $product2->id,
            'country_id' => Country::first()->id,
            'price' => 200,
            'discount' => 0
        ]);
        ProductColor::create([
            'product_head_id' => $product2->id, 
            'color_name' => 'Blue',
            'color_image' => 'blue.jpg',
            'image1' => 'blue_full.jpg'
        ]);

        Livewire::test(Shop::class)
            ->set('color', 'Red')
            ->assertSee('Red Shirt')
            ->assertDontSee('Blue Shirt');
    }

    /** @test */
    public function it_adds_product_to_cart()
    {
        $product = ProductHead::factory()->create(['slug' => 'test-product', 'status' => 'ACTIVE']);
        
        // Add price detail which is required by CartManagementService
        \App\Models\ProductHeadPrice::create([
            'product_head_id' => $product->id,
            'country_id' => Country::first()->id,
            'price' => 100,
            'discount' => 0
        ]);

        Livewire::test(Shop::class)
            ->call('addToCart', 'test-product')
            ->assertDispatched('update-cart');
    }
}
