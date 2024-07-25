<?php

namespace App\Http\Resources\API\V1\Property;

use App\Http\Resources\API\V1\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'revenue' => $this->revenue,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'admin' => UserResource::make($this->whenLoaded('admin')),
            'property' => PropertyResource::make($this->whenLoaded('property')),
        ];
    }
}
