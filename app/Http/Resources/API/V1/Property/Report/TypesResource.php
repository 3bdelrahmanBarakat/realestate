<?php

namespace App\Http\Resources\API\V1\Property\Report;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypesResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return $this->resource;
    }
}
