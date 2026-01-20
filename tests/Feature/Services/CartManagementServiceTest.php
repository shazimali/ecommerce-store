<?php

namespace Tests\Feature\Services;

use Tests\TestCase;
use App\Services\CartManagementService;
use App\Models\ProductHead;
use App\Models\Country;
use App\Models\ProductHeadPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;


class CartManagementServiceTest extends TestCase
{
    use RefreshDatabase;
    protected $testCountry;

    protected function setUp(): void
    {
        parent::setUp();

        // Start a session for cookies to work
        $this->withoutMiddleware();

        // Create ONE test country for all tests
        $this->testCountry = Country::create([
            'name' => 'Pakistan',
            'iso' => 'PK',
            'iso3' => 'PAK',
            'dial' => '92',
            'currency' => 'PKR',
            'currency_name' => 'Pakistani Rupee',
        ]);

        // Set location in session (in case getLocation uses session)
        session(['country_id' => $this->testCountry->id]);
        session()->save();
    }

    // ============================================
    // START WITH THESE 3 SIMPLE TESTS
    // ============================================

    public function test_it_can_add_product_to_empty_cart()
    {
        // Create a simple product
        $product = $this->createSimpleProduct('test-product', 1000);

        // Add to cart
        $count = CartManagementService::addCartItems('test-product', 'Red');

        // Check it worked
        $this->assertEquals(1, $count);

        $cart = CartManagementService::getCartItemsFromCookies();
        $this->assertCount(1, $cart);
        $this->assertEquals('test-product', $cart[0]['slug']);
        $this->assertEquals('Red', $cart[0]['color']);
        $this->assertEquals(1, $cart[0]['quantity']);
    }

    public function test_it_increments_quantity_when_adding_same_product()
    {
        $product = $this->createSimpleProduct('test-product', 1000);
        // Add once
        CartManagementService::addCartItems('test-product', 'Red');

        // Add again (same product, same color)
        CartManagementService::addCartItems('test-product', 'Red');

        $cart = CartManagementService::getCartItemsFromCookies();

        // Should have 1 item with quantity 2
        $this->assertCount(1, $cart);
        $this->assertEquals(2, $cart[0]['quantity']);
        $this->assertEquals(2000, $cart[0]['total_amount']); // 2 * 1000
    }

    public function test_it_can_calculate_grand_total()
    {
        $product1 = $this->createSimpleProduct('product-1', 1000);
        $product2 = $this->createSimpleProduct('product-2', 2000);

        CartManagementService::addCartItems('product-1', '');
        CartManagementService::addCartItems('product-2', '');

        $cart = CartManagementService::getCartItemsFromCookies();
        $total = CartManagementService::calculateGrandTotal($cart);

        $this->assertEquals(3000, $total); // 1000 + 2000
    }

    // ============================================
    // ADD THESE AFTER THE FIRST 3 PASS
    // ============================================

    public function test_it_can_remove_item_from_cart()
    {
        $product = $this->createSimpleProduct('test-product', 1000);

        CartManagementService::addCartItems('test-product', 'Red');
        CartManagementService::addCartItems('test-product', 'Blue');

        // Remove Red
        $cart = CartManagementService::removeCartItem('test-product', 'Red');
        $this->assertCount(1, $cart);
        $this->assertEquals('Blue', $cart[1]['color']);
    }

    public function test_it_can_clear_entire_cart()
    {
        $product = $this->createSimpleProduct('test-product', 1000);

        CartManagementService::addCartItems('test-product', 'Red');
        CartManagementService::clearCartItems();

        $cart = CartManagementService::getCartItemsFromCookies();
        $this->assertEmpty($cart);
    }

    public function test_it_can_increment_quantity()
    {
        $product = $this->createSimpleProduct('test-product', 1000);

        CartManagementService::addCartItems('test-product', 'Red');
        $cart = CartManagementService::incrementQuantityToCartItem('test-product', 'Red');

        $this->assertEquals(2, $cart[0]['quantity']);
        $this->assertEquals(2000, $cart[0]['total_amount']);
    }

    public function test_it_can_decrement_quantity()
    {
        $product = $this->createSimpleProduct('test-product', 1000);

        CartManagementService::addCartItemsFromProductDetailPage('test-product', 'Red', 5);
        $cart = CartManagementService::decrementQuantityToCartItem('test-product', 'Red');

        $this->assertEquals(4, $cart[0]['quantity']);
    }

    public function test_it_cannot_decrement_below_1()
    {
        $product = $this->createSimpleProduct('test-product', 1000);

        CartManagementService::addCartItems('test-product', 'Red');
        $cart = CartManagementService::decrementQuantityToCartItem('test-product', 'Red');

        // Should stay at 1
        $this->assertEquals(1, $cart[0]['quantity']);
    }

    public function test_it_can_add_multiple_quantity_from_detail_page()
    {
        $product = $this->createSimpleProduct('test-product', 1000);

        $count = CartManagementService::addCartItemsFromProductDetailPage('test-product', 'Red', 5);

        $cart = CartManagementService::getCartItemsFromCookies();
        $this->assertEquals(1, $count);
        $this->assertEquals(5, $cart[0]['quantity']);
        $this->assertEquals(5000, $cart[0]['total_amount']);
    }

    public function test_it_creates_separate_items_for_different_colors()
    {
        $product = $this->createSimpleProduct('test-product', 1000);

        CartManagementService::addCartItems('test-product', 'Red');
        $count = CartManagementService::addCartItems('test-product', 'Blue');

        $this->assertEquals(2, $count);

        $cart = CartManagementService::getCartItemsFromCookies();
        $this->assertCount(2, $cart);
    }

    // ============================================
    // DISCOUNT TESTS - THESE MIGHT REVEAL A BUG!
    // ============================================

    public function test_it_applies_active_discount()
    {
        // Product with 20% discount (active now)
        $product = $this->createProductWithDiscount(
            'discounted',
            1000,
            20,
            Carbon::yesterday(),
            Carbon::tomorrow()
        );

        CartManagementService::addCartItems('discounted', null);

        $cart = CartManagementService::getCartItemsFromCookies();

        // 1000 - 20% = 800
        // NOTE: This test might FAIL due to the bug in discount logic!
        // Your current code has >= instead of <=
        $this->assertEquals(800, $cart[0]['unit_amount']);
    }

    public function test_it_does_not_apply_expired_discount()
    {
        $product = $this->createProductWithDiscount(
            'expired',
            1000,
            20,
            Carbon::parse('2020-01-01'),
            Carbon::parse('2020-12-31')
        );

        CartManagementService::addCartItems('expired', null);

        $cart = CartManagementService::getCartItemsFromCookies();

        // Should be full price
        $this->assertEquals(1000, $cart[0]['unit_amount']);
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    /**
     * Create a simple test product
     * 
     * IMPORTANT: Update this method with your actual required fields!
     */
    private function createSimpleProduct(string $slug, int $price): ProductHead
    {


        // Create product
        $product = ProductHead::create([
            'slug' => $slug,
            'title' => "Test Product {$slug}",
            'image' => 'test.jpg',
            'description' => 'Test description',
            'short_desc' => 'Test short description',
            'category_id' => 1,
            'is_active' => true,
            'brand_id' => 1,
            'sku' => 'TEST-' . $slug,
        ]);

        // Create price detail
        ProductHeadPrice::create([
            'product_head_id' => $product->id,
            'country_id' => $this->testCountry->id,
            'price' => $price,
            'discount' => 0,
            'discount_from' => null,
            'discount_to' => null,
        ]);

        // Reload with relationships
        return $product->fresh(['price_detail', 'price_detail.country', 'colors']);
    }


    /**
     * Create product with discount
     */
    private function createProductWithDiscount(
        string $slug,
        int $price,
        int $discount,
        Carbon $from,
        Carbon $to
    ): ProductHead {
        $product = ProductHead::create([
            'slug' => $slug,
            'title' => "Test Product {$slug}",
            'image' => 'test.jpg',
            'description' => 'Test description',
            'short_desc' => 'Test short description',
            'category_id' => 1,
            'is_active' => true,
            'brand_id' => 1,
            'sku' => 'TEST-' . $slug,
        ]);

        ProductHeadPrice::create([
            'product_head_id' => $product->id,
            'country_id' => $this->testCountry->id,
            'price' => $price,
            'discount' => $discount,
            'discount_from' => $from,
            'discount_to' => $to,
        ]);

        return $product->fresh(['price_detail', 'price_detail.country', 'colors']);
    }
}
