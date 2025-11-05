<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\booking;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'number',
        'address',
        'gender',
        'image',
        'otp',
        'otp_expires_at',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
    ];

    // booking table maa user_id ne foregoing key aaypi che 
    // relationships one to many
    // This user owns multiple bookings in the bookings table, and they are connected using the user_id column.
    public function bookings()
    {
        return $this->hasMany(booking::class, 'user_id');
    }
}
