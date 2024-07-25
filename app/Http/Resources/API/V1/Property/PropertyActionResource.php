<?php

namespace App\Http\Resources\API\V1\Property;

use App\Http\Resources\API\V1\User\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyActionResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'action' => $this->action,
            'property' => PropertyResource::make($this->whenLoaded('property')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'admin' => UserResource::make($this->whenLoaded('admin')),
            'created_at' => Carbon::parse($this->created_at)->format("d M Y H:i:s"),
            'updated_at' => Carbon::parse($this->updated_at)->format("d M Y H:i:s"),
        ];
    }
}
