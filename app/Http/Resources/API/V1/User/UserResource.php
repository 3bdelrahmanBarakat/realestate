<?php

namespace App\Http\Resources\API\V1\User;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{


    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => Str::apa($this->name),
            'phone' => $this->phone,
            'gender' =>$this->gender? $this->gender: null,
            "role" => $this->role,
            'email_verified' => $this->email_verified_at ? true : false,
            'image' => $this->image ? url("/storage/uploads/users/profile/{$this->image}") : null,
            'created_at' => Carbon::parse($this->created_at)->format("d M Y")
        ];
    }
}
