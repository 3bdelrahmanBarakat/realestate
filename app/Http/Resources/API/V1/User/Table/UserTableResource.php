<?php

namespace App\Http\Resources\API\V1\User\Table;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserTableResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'last_login_at' => Carbon::parse($this->last_login_at)->format("d M Y H:i:s"),
            'properties_count' => $this->properties_count,
        ];
    }
}
