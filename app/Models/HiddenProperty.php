<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HiddenProperty extends Model
{
    use HasFactory;
    protected $table = 'hidden_properties';
    protected $fillable = [
        'property_id',
        'company_name',
        'company_phone',
        'reason'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
