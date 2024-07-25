<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'classification',
        'rooms_num',
        'toilets_num',
        'bedrooms_num',
        'living_rooms_num',
        'has_board',
        'has_floor_seating',
        'has_roof',
        'has_mashab',
        'has_private_entrance'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
