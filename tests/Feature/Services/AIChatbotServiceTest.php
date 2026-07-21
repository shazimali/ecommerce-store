<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\Models\Order;
use App\Models\ProductHead;
use App\Services\AIChatbotService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AIChatbotServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AIChatbotService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AIChatbotService();
    }

    #[Test]
    public function test_it_resolves_order_tracking_context_from_database()
    {
        $user = \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $order = Order::create([
            'user_id'         => $user->id,
            'order_id'        => 'ORD-10022',
            'phone'           => '03001234567',
            'address'         => '123 Main Street',
            'billing_address' => '123 Main Street',
            'country_id'      => 1,
            'city_id'         => 1,
            'status'          => 'DISPATCHED',
            'total'           => 4500,
            'track_number'    => 'TRK-987654',
        ]);

        $context = $this->service->buildDatabaseContext('Where is my order ORD-10022?');

        $this->assertStringContainsString('ORDER INFO', $context);
        $this->assertStringContainsString('DISPATCHED', $context);
        $this->assertStringContainsString('TRK-987654', $context);
    }

    #[Test]
    public function test_it_resolves_matching_products_context_from_database()
    {
        ProductHead::create([
            'title'      => 'Kitchen Storage Shelf Rack',
            'slug'       => 'kitchen-storage-shelf-rack',
            'code'       => 'KITCHEN-RACK-01',
            'sku'        => 'KITCHEN-RACK-SKU',
            'order'      => 1,
            'short_desc' => 'Durable plastic kitchen storage rack',
            'description'=> 'Full product description here',
            'status'     => 'ACTIVE',
            'image'      => 'rack.jpg',
        ]);

        $context = $this->service->buildDatabaseContext('Show kitchen storage products');

        $this->assertStringContainsString('FEATURED/MATCHING PRODUCTS', $context);
        $this->assertStringContainsString('Kitchen Storage Shelf Rack', $context);
        $this->assertStringContainsString('/products/kitchen-storage-shelf-rack', $context);
    }

    #[Test]
    public function test_it_handles_general_please_list_all_products_queries()
    {
        ProductHead::create([
            'title'      => 'Everyday Plastic Chair',
            'slug'       => 'everyday-plastic-chair',
            'code'       => 'CHAIR-01',
            'sku'        => 'CHAIR-SKU',
            'order'      => 1,
            'short_desc' => 'Durable plastic chair',
            'description'=> 'Plastic chair for home',
            'status'     => 'ACTIVE',
            'image'      => 'chair.jpg',
        ]);

        $context = $this->service->buildDatabaseContext('please list all products');

        $this->assertStringContainsString('FEATURED/MATCHING PRODUCTS', $context);
        $this->assertStringContainsString('Everyday Plastic Chair', $context);
    }

    #[Test]
    public function test_it_includes_categories_and_full_catalog_link_in_context()
    {
        \App\Models\Category::create([
            'title' => 'Kitchen Storage Solutions',
            'slug'  => 'kitchen-storage-solutions',
            'order' => 1,
        ]);

        $context = $this->service->buildDatabaseContext('what categories do you have?');

        $this->assertStringContainsString('STORE CATEGORIES', $context);
        $this->assertStringContainsString('Kitchen Storage Solutions', $context);
        $this->assertStringContainsString('/shop', $context);
    }

    #[Test]
    public function test_it_calculates_cosine_similarity_correctly()
    {
        $vectorA = [1.0, 0.0, 0.0];
        $vectorB = [1.0, 0.0, 0.0];
        $vectorC = [0.0, 1.0, 0.0];

        $identical = $this->service->cosineSimilarity($vectorA, $vectorB);
        $orthogonal = $this->service->cosineSimilarity($vectorA, $vectorC);

        $this->assertEqualsWithDelta(1.0, $identical, 0.0001);
        $this->assertEqualsWithDelta(0.0, $orthogonal, 0.0001);
    }

    #[Test]
    public function test_it_ranks_products_using_rag_vector_embeddings()
    {
        $embeddingRack = $this->service->generateEmbedding('kitchen rack organizer');
        $embeddingToy = $this->service->generateEmbedding('baby toy box');

        $rack = ProductHead::create([
            'title'      => 'Kitchen Organizer Rack',
            'slug'       => 'kitchen-organizer-rack',
            'code'       => 'K-RACK',
            'sku'        => 'K-SKU',
            'order'      => 1,
            'short_desc' => 'Kitchen storage rack',
            'description'=> 'Storage rack',
            'status'     => 'ACTIVE',
            'image'      => 'rack.jpg',
            'embedding'  => $embeddingRack,
        ]);

        $toy = ProductHead::create([
            'title'      => 'Baby Toy Chest Box',
            'slug'       => 'baby-toy-chest-box',
            'code'       => 'B-TOY',
            'sku'        => 'B-SKU',
            'order'      => 2,
            'short_desc' => 'Toy box for babies',
            'description'=> 'Toy chest box',
            'status'     => 'ACTIVE',
            'image'      => 'toy.jpg',
            'embedding'  => $embeddingToy,
        ]);

        $context = $this->service->buildDatabaseContext('Show kitchen organizer products');

        $this->assertStringContainsString('Kitchen Organizer Rack', $context);
    }

    #[Test]
    public function test_it_responds_to_greetings_with_welcome_message()
    {
        $greetings = ['hi', 'hello', 'hey', 'good morning', 'aoa'];
        foreach ($greetings as $greet) {
            $reply = $this->service->chat($greet);
            $this->assertStringContainsString("Everyday Plastic AI Assistant", $reply);
        }
    }

    #[Test]
    public function test_it_prompts_for_order_number_when_tracking_request_has_no_id()
    {
        $response = $this->service->chat('track my order');

        $this->assertStringContainsString('Order ID', $response);
        $this->assertStringContainsString('Tracking Number', $response);
    }

    #[Test]
    public function test_it_provides_fallback_response_when_api_key_is_not_configured()
    {
        config(['services.openrouter.api_key' => null]);

        $reply = $this->service->chat('What is your shipping policy?');

        $this->assertStringContainsString('WHATSAPP', $reply);
    }
}
