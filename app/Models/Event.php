<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's plural naming convention
    protected $table = 'events';

    // The attributes that are mass assignable
    protected $fillable = [
        'name',
        'date',
        'location',
        'total_tickets',
        'price',
        'image',
    ];

    protected $casts = [
        'date' => 'date',
        'total_tickets' => 'integer',
    ];
}
