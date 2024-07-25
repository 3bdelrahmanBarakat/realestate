<?php

namespace App\Http\Resources\API\V1\Appointment;

use App\Http\Resources\API\V1\Property\PropertyResource;
use App\Http\Resources\API\V1\User\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start_date_time' => $this->start_date_time,
            'end_date_time' => $this->end_date_time,
            'status' => $this->status,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'phone' => $this->user->phone,
            ],
            'employee' => [
                'id' => $this->employee->id,
                'name' => $this->employee->name,
                'phone' => $this->employee->phone,
            ],
            'property' => [
                'id' => $this->property->id,
                'distinctive_address' => $this->property->distinctive_address,
            ],
            'created_at' => Carbon::parse($this->created_at)->format("d M Y H:i:s"),
            'updated_at' => Carbon::parse($this->updated_at)->format("d M Y H:i:s"),
        ];
    }
}
