<?php

namespace App\Http\Resources\API\V1\Property\Report;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'unique_clients_count' => $this->unique_clients_count,
            'call_clients_count' => $this->call_clients_count,
            'whatsapp_clients_count' => $this->whatsapp_clients_count,
            'chat_clients_count' => $this->chat_clients_count,
            'property_listings_count'=> $this->property_listings_count
        ];
    }
}
