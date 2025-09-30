<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // if sub-admin log in
use Illuminate\Notifications\Notifiable;

class SubAdmin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'sub_admin'; // make sure this table exists in DB

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];
    protected $attributes = [
        'role' => 2, // default role
    ];

    protected $hidden = [
        'password',
    ];
}
