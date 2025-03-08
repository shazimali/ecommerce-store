<?php

namespace Tests\Feature\Livewire;

use App\Livewire\ProductDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProductDetailTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ProductDetail::class)
            ->assertStatus(200);
    }
}
