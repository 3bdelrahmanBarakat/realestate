<?php

namespace App\Http\Requests\API\V1\Appointment;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:400',
            'employee_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'start_date_time' => 'required|date|unique:appointments,start_date_time',
            'status' => 'nullable|string'
        ];
    }
}
