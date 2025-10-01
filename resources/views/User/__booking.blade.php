@extends('User.layout.partials.master')

@section('title', 'Event Details - Music Fiesta 2025')

@section('content')
    <div class="container py-5 mt-5" style="padding-top:120px;">
        <div class="card shadow-lg p-4">
            <h2 class="fw-bold mb-4 text-center book">Book Your Tickets</h2>

            <form onsubmit="return bookTickets(event)">
                <!-- Ticket Selection -->
                <div class="mb-4">
                    {{ request()->get('id') }}

                    <label class="form-label fw-semibold">General Ticket (₹500)</label>
                    <input type="number" id="general" min="0" value="0" class="form-control w-25">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">VIP Ticket (₹1500)</label>
                    <input type="number" id="vip" min="0" value="0" class="form-control w-25">
                </div>

                <!-- User Info -->
                <div class="mb-3">
                    <input type="text" id="name" placeholder="Full Name" class="form-control mb-2" required>
                    <input type="email" id="email" placeholder="Email Address" class="form-control mb-2" required>
                    <input type="tel" id="phone" placeholder="Phone Number" class="form-control" required>
                </div>

                <!-- Summary -->
                <div class="alert alert-info">
                    <p>Total Tickets: <span id="totalTickets">0</span></p>
                    <p>Total Price: ₹<span id="totalPrice">0</span></p>
                </div>

                <button type="submit" class="btn btn-gradient w-100">Confirm Booking</button>
            </form>
        </div>
    </div>
@endsection
