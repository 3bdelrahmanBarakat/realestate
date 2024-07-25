<?php

namespace App\Http\Resources\API\V1\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyBooleanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'private_entrance' => $this->private_entrance,
            'has_board' => $this->has_board,
            'has_floor_seating' => $this->has_floor_seating,
            'has_masahb' => $this->has_masahb,
        ];
    }
}
