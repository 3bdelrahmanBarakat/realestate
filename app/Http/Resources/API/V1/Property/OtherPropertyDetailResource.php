<?php

namespace App\Http\Resources\API\V1\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OtherPropertyDetailResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'detail' => $this->detail,
        ];
    }
}
