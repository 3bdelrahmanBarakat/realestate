<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherPropertyDetail extends Model
{
    use HasFactory;

    protected $table = 'other_property_details';
    protected $fillable = [
        'property_id',
        'detail'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }


}
