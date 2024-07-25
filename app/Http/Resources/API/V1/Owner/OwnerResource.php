<?php

namespace App\Http\Resources\API\V1\Owner;

use App\Http\Resources\API\V1\Property\PropertyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnerResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'properties' => PropertyResource::collection($this->whenLoaded('properties')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
