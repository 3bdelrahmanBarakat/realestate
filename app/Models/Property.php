<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketer_name',
        'admin_id',
        'owner_id',
        'distinctive_address',
        'type',
        'unit_type',
        'purpose',
        'description',
        'deposit',
        'price',
        'area',
        'floor',
        'previously_occupied',
        'city',
        'district',
        'property_age',
        'location_link',
        'property_facing',
        'owner_name',
        'owner_phone',
        'guard_name',
        'guard_phone',
        'other_detail',
        'other_attachment',
        'available_date',
        'status',
        'is_active'
    ];

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function rentalDetail()
    {
        return $this->hasOne(RentalDetail::class);
    }

    public function features()
    {
        return $this->hasOne(PropertyFeature::class);
    }

    public function actions()
    {
        return $this->hasOne(PropertyAction::class);
    }

    public function otherFeatures()
    {
        return $this->hasMany(OtherPropertyFeature::class);
    }

    public function amenities()
    {
        return $this->hasMany(PropertyAmenity::class);
    }

    public function otherDetails()
    {
        return $this->hasMany(OtherPropertyDetail::class);
    }

    public function listings()
    {
        return $this->hasMany(PropertyListing::class);
    }

    public function hiddenProperties()
    {
        return $this->hasMany(HiddenProperty::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

}
