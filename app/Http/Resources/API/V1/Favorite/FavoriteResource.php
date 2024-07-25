<?php

namespace App\Http\Resources\API\V1\Favorite;

use App\Http\Resources\API\V1\Property\PropertyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'property' => PropertyResource::make($this->whenLoaded('property'))
        ];
    }
}
