<?php

namespace Tests\Feature\Services\API\Admin\Pages;

use App\Models\Country;
use App\Models\Page;
use App\Models\User;
use App\Services\API\Admin\Pages\PagesService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tests\TestCase;

class PagesServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PagesService $pagesService;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pagesService = new PagesService();

        // Create an authenticated user if needed (adjust if you're not using factories)
        // $this->user = User::factory()->create();
        // $this->actingAs($this->user);
    }

    /**
     * Create a fake page for testing
     */
    private function createPage(array $attributes = []): Page
    {
        $defaults = [
            'title' => $attributes['title'] ?? 'Test Page ' . Str::random(5),
            'slug' => $attributes['slug'] ?? Str::slug('test-page-' . Str::random(5)),
            'content' => $attributes['content'] ?? 'This is test content for the page.',
            'status' => $attributes['status'] ?? 'ACTIVE',
            'seo_title' => $attributes['seo_title'] ?? 'Test SEO Title',
            'seo_description' => $attributes['seo_description'] ?? 'Test SEO Description',
            'position' => $attributes['position'] ?? 'HEADER',
        ];

        return Page::create(array_merge($defaults, $attributes));
    }

    /**
     * Create a fake country for testing
     */
    private function createCountry(array $attributes = []): Country
    {
        $defaults = [
            'name' => $attributes['name'] ?? 'Country ' . Str::random(5),
            'iso' => $attributes['iso'] ?? strtoupper(Str::random(2)),
            'iso3' => $attributes['iso3'] ?? strtoupper(Str::random(3)),
            'dial' => $attributes['dial'] ?? '+' . rand(1, 999),
            'currency' => $attributes['currency'] ?? strtoupper(Str::random(3)),
            'currency_name' => $attributes['currency_name'] ?? 'Currency ' . Str::random(5),
        ];

        return Country::create(array_merge($defaults, $attributes));
    }

    /**
     * Create multiple pages
     */
    private function createPages(int $count, array $attributes = []): void
    {
        for ($i = 0; $i < $count; $i++) {
            $this->createPage($attributes);
        }
    }

    /**
     * Create multiple countries
     */
    private function createCountries(int $count, array $attributes = []): void
    {
        for ($i = 0; $i < $count; $i++) {
            $this->createCountry($attributes);
        }
    }

    /** @test */
    public function test_it_can_get_all_pages_with_pagination()
    {
        // Arrange
        $this->createPages(15);

        $request = new Request(['item_per_page' => 10]);

        // Act
        $result = $this->pagesService->getAll($request);

        // Assert
        $this->assertCount(10, $result->collection);
    }

    /** @test */
    public function test_it_can_search_pages_by_id()
    {
        // Arrange
        $page = $this->createPage();

        $request = new Request([
            'item_per_page' => 10,
            'search' => $page->id
        ]);

        // Act
        $result = $this->pagesService->getAll($request);

        // Assert
        $this->assertCount(1, $result->collection);
    }

    /** @test */
    public function test_it_can_get_all_countries()
    {
        // Arrange
        $this->createCountries(5);

        // Act
        $result = $this->pagesService->getAllCountries();

        // Assert
        $this->assertCount(5, $result->collection);
    }


    /** @test */
    public function test_it_can_edit_a_page()
    {
        // Arrange
        $country1 = $this->createCountry();
        $country2 = $this->createCountry();

        $page = $this->createPage();
        $page->countries()->attach([$country1->id, $country2->id]);

        // Act
        $result = $this->pagesService->edit($page->id);

        // Assert
        $this->assertInstanceOf(\App\Http\Resources\API\Admin\Pages\PagesEditResource::class, $result);
    }

    /** @test */
    public function it_returns_error_when_editing_non_existent_page()
    {
        // Act
        $result = $this->pagesService->edit(999);

        // Assert
        $this->assertEquals(201, $result->status());
        $this->assertEquals('Page not fount', $result->getData()->message);
    }

    /** @test */
    public function test_it_can_destroy_a_page()
    {
        // Arrange
        $country1 = $this->createCountry();
        $country2 = $this->createCountry();

        $page = $this->createPage();
        $page->countries()->attach([$country1->id, $country2->id]);

        // Act
        $result = $this->pagesService->destroy($page->id);

        // Assert
        $this->assertEquals(200, $result->status());
        $this->assertEquals('Page Deleted Successfully', $result->getData()->message);

        $this->assertDatabaseMissing('custom_pages', ['id' => $page->id]);

        // Verify pivot records are also deleted
        $this->assertDatabaseMissing('page_country', ['page_id' => $page->id]);
    }

    /** @test */
    public function it_returns_error_when_destroying_non_existent_page()
    {
        // Act
        $result = $this->pagesService->destroy(999);

        // Assert
        $this->assertEquals(201, $result->status());
        $this->assertEquals('Page not found.', $result->getData()->message);
    }

    /** @test */
    public function test_it_can_filter_active_pages()
    {
        // Arrange
        $this->createPage(['status' => 'ACTIVE']);
        $this->createPage(['status' => 'ACTIVE']);
        $this->createPage(['status' => 'INACTIVE']);

        // Act
        $activePages = Page::active()->get();

        // Assert
        $this->assertCount(2, $activePages);
    }

    /** @test */
    public function test_it_can_filter_header_pages()
    {
        // Arrange
        $this->createPage(['position' => 'HEADER', 'title' => 'Header Page 1']);
        $this->createPage(['position' => 'HEADER', 'title' => 'Header Page 2']);
        $this->createPage(['position' => 'FOOTER', 'title' => 'Footer Page 1']);

        // Act
        $headerPages = Page::header()->get();

        // Assert
        $this->assertCount(2, $headerPages);
        $this->assertTrue($headerPages->every(fn($page) => $page->position === 'HEADER'));
    }

    /** @test */
    public function test_it_can_filter_footer_pages()
    {
        // Arrange
        $this->createPage(['position' => 'FOOTER']);
        $this->createPage(['position' => 'FOOTER']);
        $this->createPage(['position' => 'HEADER']);

        // Act
        $footerPages = Page::footer()->get();

        // Assert
        $this->assertCount(2, $footerPages);
    }
}
