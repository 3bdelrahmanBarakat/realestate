<?php

namespace App\Http\Resources\API\V1\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HiddenPropertyResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'company_name' => $this->company_name,
            'company_phone' => $this->company_phone,
            'property' => PropertyResource::make($this->whenLoaded('property'))
        ];
    }
}
