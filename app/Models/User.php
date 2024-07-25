<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        "name",
        "phone",
        "email",
        "role",
        'gender',
        "image",
        "password",
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function actions()
    {
        return $this->hasMany(PropertyAction::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function listings()
    {
        return $this->hasMany(PropertyListing::class, 'admin_id');
    }
}
