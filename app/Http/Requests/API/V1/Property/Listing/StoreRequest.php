<?php

namespace App\Http\Requests\API\V1\Property\Listing;

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
            'property_id' => 'required|integer|exists:properties,id|unique:property_listings,property_id',
            'admin_id' => 'required|integer|exists:users,id',
            'status' => 'required|string',
            'revenue' => 'required|numeric',
        ];
    }
}
