<?php

namespace App\Http\Resources\API\V1\Admin;

use App\Http\Resources\API\V1\Roles\PermissionResource;
use App\Http\Resources\API\V1\Roles\RolesResource;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => Str::apa($this->name),
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'email_verified' => $this->email_verified_at ? true : false,
            'image' => $this->image ? url("/storage/uploads/users/profile/{$this->image}") : null,
            'role' =>  $this->role,
            'created_at' => Carbon::parse($this->created_at)->format("d M Y"),
        ];
    }
}
