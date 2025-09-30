<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];
    protected $attributes = [
        'role' => 2, // default role
    ];
    // public function isAdmin()
    // {
    //     return $this->role === 1;
    // }

    // public function isSubAdmin()
    // {
    //     return $this->role === 2;
    // }
}
