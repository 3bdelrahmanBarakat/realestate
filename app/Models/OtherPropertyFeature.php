<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherPropertyFeature extends Model
{
    use HasFactory;
    protected $table = 'property_other_features';
    protected $fillable = ['property_id', 'feature'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
