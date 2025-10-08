<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Table name (optional, Laravel will assume 'events' automatically)
    protected $table = 'events';

    // Fillable fields for mass assignment
    protected $fillable = [
        'name',
        'date',
        'start_time',
        'end_time',
        'location',
        'price',
        'total_tickets',
        'image',
    ];

    // Optional: Cast columns to specific types
    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i:s A',
        'end_time' => 'datetime:H:i:s A',
        'price' => 'integer',
        'total_tickets' => 'integer',
    ];
}
