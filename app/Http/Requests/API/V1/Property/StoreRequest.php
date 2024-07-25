<?php

namespace App\Http\Requests\API\V1\Property;

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
            'distinctive_address' => 'required|string|max:255',
            'owner_id' => 'nullable|integer|exists:owners,id',
            'location_link' => 'required|string|max:8000',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'type' => 'required|in:for rent,for sale',
            'unit_type' => 'required|string|max:255',
            'purpose' => 'required|in:residential,commercial',
            'description' => 'required|string',
            'deposit' => 'nullable|numeric',
            'price' => 'required|numeric',
            'area' => 'required|numeric',
            'floor' => 'nullable|integer',
            'previously_occupied' => 'nullable|boolean',
            'property_age' => 'nullable|integer',
            'property_facing' => 'nullable|string',
            'owner_name' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:15',
            'guard_name' => 'nullable|string|max:255',
            'guard_phone' => 'nullable|string|max:15',
            'images' => 'required|array',
            'images.*' => 'image|max:10240',
            // 'rental_type' => 'required_if:type,for rent|in:monthly,yearly,quarterly,semi-annually,none',
            'rental_type' => 'nullable|in:monthly,yearly,quarterly,semi-annually,none',
            // 'commercialLandDetail' => 'required_if:purpose,commercial|array',
            // 'commercialLandDetail.land_width' => 'required_if:purpose,commercial|numeric',
            // 'commercialLandDetail.land_length' => 'required_if:purpose,commercial|numeric',
            // 'commercialLandDetail.masterplan_number' => 'required_if:purpose,commercial|string|max:255',
            // 'commercialLandDetail.land_number' => 'required_if:purpose,commercial|string|max:255',
            // 'commercialLandDetail.price_per_meter' => 'required_if:purpose,commercial|numeric',
            'features' => 'nullable|array',
            'features.classification' => 'nullable|in:for family,for individuals',
            'features.rooms_num' => 'nullable|integer',
            'features.toilets_num' => 'nullable|integer',
            'features.bedrooms_num' => 'nullable|integer',
            'features.living_rooms_num' => 'nullable|integer',
            'features.has_board' => 'nullable|boolean',
            'features.has_floor_seating' => 'nullable|boolean',
            'features.has_roof' => 'nullable|boolean',
            'features.has_mashab' => 'nullable|boolean',
            'features.has_private_entrance' => 'nullable|boolean',
            'other_features' => 'nullable|array',
            'other_details' => 'nullable|array',
            'amenities' => 'nullable|array',
            'other_attachment' => 'nullable|file|max:10240',
            'available_date' => 'required|date',
        ];
    }
}
