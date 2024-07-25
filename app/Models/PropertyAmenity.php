<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAmenity extends Model
{
    use HasFactory;
    protected $table = 'property_amenities';
    protected $fillable = [
        'property_id',
        'amenity'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
