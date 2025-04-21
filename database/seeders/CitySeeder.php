<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get(env('COD_API') . 'getAllCities/format/json/', [
            'api_key' => env('COD_API_KEY'),
            'api_password' => env('COD_API_PASSWORD')
        ]);

        $res_data = $response->json();
        if ($res_data) {
            foreach ($res_data['city_list'] as $key => $city) {
                City::create([
                    'name' => $city['name']
                ]);
            }
        }
    }
}
