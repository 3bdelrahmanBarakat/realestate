<?php

namespace App\Http\Requests\API\V1\Property;

use Illuminate\Foundation\Http\FormRequest;

class HideRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'company_name' => 'nullable|string|max:255',
            'company_phone' => 'nullable|string|max:15',
            'reason' => 'nullable|string|max:3000'
        ];
    }
}
