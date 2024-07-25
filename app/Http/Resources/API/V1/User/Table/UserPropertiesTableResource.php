<?php

namespace App\Http\Resources\API\V1\User\Table;

use App\Http\Resources\API\V1\Property\PropertyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPropertiesTableResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'id' => $this->resource['user']['id'],
                'name' => $this->resource['user']['name'],
                'email' => $this->resource['user']['email'],
                'phone' => $this->resource['user']['phone'],
                'last_login_at' => $this->resource['user']['last_login_at'],
            ],
            'properties' => $this->resource['properties']->mapWithKeys(function ($propertyData) {
                return [
                    $propertyData->property->id => [
                        'called' => $propertyData->called,
                        'whatsapp' => $propertyData->whatsapp,
                        'sent_message' => $propertyData->sent_message,
                        'viewed' => $propertyData->viewed,
                        'property' => new PropertyResource($propertyData->property),
                    ]
                ];
            })->toArray(),
        ];
    }
}
