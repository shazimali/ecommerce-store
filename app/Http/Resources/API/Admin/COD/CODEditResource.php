<?php

namespace App\Http\Resources\API\Admin\COD;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CODEditResource extends JsonResource
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
            'api_test_url' => $this->api_test_url,
            'api_url' => $this->api_url,
            'api_key' => $this->api_key,
            'api_password' => $this->api_password,
            'status' => $this->status,
            'countries' => $this->countries
        ];
    }
}
