<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\booking;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

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

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i:s A',
        'end_time' => 'datetime:H:i:s A',
        'price' => 'integer',
        'total_tickets' => 'integer',
    ];

    public function bookings()
    {
        return $this->hasMany(booking::class, 'event_id');
    }
}
