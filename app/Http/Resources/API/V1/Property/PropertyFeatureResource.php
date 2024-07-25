<?php

namespace App\Http\Resources\API\V1\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyFeatureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'classification' => $this->classification,
            'rooms_num' => $this->rooms_num,
            'toilets_num' => $this->toilets_num,
            'bedrooms_num' => $this->bedrooms_num,
            'living_rooms_num' => $this->living_rooms_num,
            'has_board' => $this->has_board,
            'has_floor_seating' => $this->has_floor_seating,
            'has_roof' => $this->has_roof,
            'has_mashab' => $this->has_mashab,
            'has_private_entrance' => $this->has_private_entrance,
        ];
    }
}
