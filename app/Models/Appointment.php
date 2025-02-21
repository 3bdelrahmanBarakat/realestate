<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'employee_id',
        'user_id',
        'property_id',
        'start_date_time',
        'end_date_time',
        'status'
    ];
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
