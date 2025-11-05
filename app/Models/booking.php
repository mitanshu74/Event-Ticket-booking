<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\event;

class booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'event_id',
        'tickets_booked',
        'total_price',
        'booking_type',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // A booking belongs to an event
    // relationships many to one
    // This booking belongs to one event via the event_id column in the bookings table
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
