<?php

namespace App\Http\Requests\API\V1\Property;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'marketer_name' => 'sometimes|required|string|max:255',
            'distinctive_address' => 'sometimes|string|max:255',
            'type' => 'sometimes|required|in:for rent,for sale',
            'title' => 'sometimes|string|max:255',
            'location_link' => 'sometimes|numeric|max:1500',
            'city' => 'sometimes|string|max:255',
            'purpose' => 'sometimes|required|in:residential,commercial',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'area' => 'sometimes|required|numeric',
            'floor' => 'nullable|integer',
            'previously_occupied' => 'nullable|boolean',
            'property_age' => 'nullable|integer',
            'property_facing' => 'nullable|string',
            'owner_name' => 'sometimes|required|string|max:255',
            'owner_phone' => 'sometimes|required|string|max:15',
            'guard_name' => 'nullable|string|max:255',
            'guard_phone' => 'nullable|string|max:15',
            'images' => 'nullable|array',
            'images.*' => 'image',
            'rental_type' => 'required_if:type,for rent|in:monthly,yearly,quarterly,semi-annually',
            // 'commercialLandDetail' => 'required_if:purpose,commercial|array',
            // 'commercialLandDetail.land_width' => 'required_if:purpose,commercial|numeric',
            // 'commercialLandDetail.land_length' => 'required_if:purpose,commercial|numeric',
            // 'commercialLandDetail.masterplan_number' => 'required_if:purpose,commercial|string|max:255',
            // 'commercialLandDetail.land_number' => 'required_if:purpose,commercial|string|max:255',
            // 'commercialLandDetail.price_per_meter' => 'required_if:purpose,commercial|numeric',
            'features' => 'nullable|array',
            'features.in_building_or_villa' => 'nullable|in:building,villa',
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
            'other_attachment' => 'nullable|file',
            'available_date' => 'sometimes|date',
            'status' => 'sometimes|string|max:255',
            'is_active' => 'sometimes|boolean',
        ];
    }
}
