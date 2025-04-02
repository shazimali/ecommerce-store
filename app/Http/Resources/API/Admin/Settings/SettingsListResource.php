<?php

namespace App\Http\Resources\API\Admin\Settings;

use App\Http\Resources\API\Admin\Countries\CountryListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingsListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'key' => $this->key,
            'value' => $this->value,
            'country_id' => $this->country_id,
            'country' => new CountryListResource($this->country),
            'created_at' => $this->created_at->toDateString(),


        ];
    }
}
