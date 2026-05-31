<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Country;

class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->country,
            'iso' => $this->faker->countryCode,
            'iso3' => $this->faker->countryISOAlpha3,
            'dial' => $this->faker->e164PhoneNumber,
            'currency' => $this->faker->currencyCode,
            'currency_name' => $this->faker->currencyCode,
        ];
    }
}
