<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyListing extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_id',
        'admin_id',
        'status',
        'revenue'
    ];
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class);
    }
}
