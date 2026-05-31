<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductHead;

class ProductHeadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductHead::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'code' => $this->faker->word,
            'sku' => $this->faker->unique()->ean13,
            'short_desc' => $this->faker->text(50),
            'description' => $this->faker->paragraph,
            'status' => 'ACTIVE',
            'is_featured' => 0,
            'is_trending' => 0,
            'is_new' => 1,
            'coming_soon' => 0,
        ];
    }
}
