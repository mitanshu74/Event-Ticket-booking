@extends('User.layout.partials.master')

@section('title', 'Event Details')

@section('content')


    <!-- Event Details -->
    <div class="container py-5 mt-5" style="padding-top:120px;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg ">
                    <!-- Event Image -->
                    <img src="{{ $event->image ? asset('storage/' . $event->image) : '' }}" class="event_image"
                        alt="{{ $event->title }}">

                    <div class="card-body">
                        <!-- Event Title -->
                        <h2 class="fw-bold mb-3">{{ $event->name }}</h2>

                        <!-- Event Info -->
                        <p class="mb-2"><strong>📅 Date:</strong> {{ $event->date->format('d-m-Y') }}</p>
                        <p class="mb-2"><strong>⏰ Time:</strong> 7:00 PM - 11:00 PM</p>
                        <p class="mb-2"><strong>📍 Venue:</strong> {{ $event->location }}</p>
                        <p class="mb-4 text-muted">
                            Join us for a night of unforgettable music performances featuring top artists from around the
                            world. Experience live concerts like never before in an electrifying atmosphere.
                        </p>

                        <!-- Event Highlights -->
                        <h5 class="fw-bold mb-2">Event Highlights:</h5>
                        <ul class="mb-4">
                            <li>Live performances by top international and local artists</li>
                            <li>Food & beverage stalls</li>
                            <li>Exclusive merchandise</li>
                            <li>VIP lounge with special seating</li>
                            <li>Interactive fan experiences</li>
                        </ul>

                        <!-- Book Ticket Button -->
                        <a href="{{ url('/user/booking') }}" class="btn btn-gradient w-100 btn-lg">🎟️ Book Tickets Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
