<?php

namespace App\Http\Resources\API\V1\Property;

use App\Http\Resources\API\V1\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'marketer_name' => $this->marketer_name,
            'distinctive_address' => $this->distinctive_address,
            'location_link' => $this->location_link,
            'city' => $this->city,
            'district' => $this->district,
            'purpose' => $this->purpose,
            'type' => $this->type,
            'unit_type' => $this->unit_type,
            'area' => $this->area,
            'price' => $this->price,
            'floor' => $this->floor,
            'previously_occupied' => $this->previously_occupied,
            'property_age' => $this->property_age,
            'property_facing' => $this->property_facing,
            'owner_name' => $this->owner_name,
            'owner_phone' => $this->owner_phone,
            'guard_name' => $this->guard_name,
            'guard_phone' => $this->guard_phone,
            'description' => $this->description,
            'available_date' => $this->available_date,
            'is_active' => $this->is_active,
            'status' => $this->status,
            'isFavorited' => $this->isFavorited,
            'favoriteId' => $this->favoriteId,
            'other_attachment' => $this->other_attachment ? url("/storage/uploads/properties/attachments/{$this->other_attachment}") : null,
            'images' => PropertyImageResource::collection($this->whenLoaded('images')),
            'admin' => UserResource::make($this->whenLoaded('admin')),
            'features' => new PropertyFeatureResource($this->whenLoaded('features')),
            'other_features' => OtherPropertyFeatureResource::collection($this->whenLoaded('otherFeatures')),
            'other_details' => OtherPropertyDetailResource::collection($this->whenLoaded('otherDetails')),
            'amenities' => PropertyAmenityResource::collection($this->whenLoaded('amenities')),
            'rental_detail' => new RentalDetailResource($this->whenLoaded('rentalDetail')),
            'action_counts' => $this->when(isset($this->action_counts), $this->action_counts),
        ];
    }
}
