<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductHeadPrice;
use App\Models\ProductHead;
use App\Models\Country;

class ProductHeadPriceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductHeadPrice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_head_id' => ProductHead::factory(),
            'country_id' => Country::factory(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'discount' => 0,
        ];
    }
}
