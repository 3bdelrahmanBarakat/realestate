<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'rental_type'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
