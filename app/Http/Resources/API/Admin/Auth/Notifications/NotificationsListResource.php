<?php

namespace App\Http\Resources\API\Admin\Auth\Notifications;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationsListResource extends JsonResource
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
            'description' => $this->description,
            'is_read' => $this->is_read,
            'created_at' => $this->created_at->toDateString()
        ];
    }
}
