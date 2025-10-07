@extends('User.layout.partials.master')
@section('title', 'Event Details')
@section('content')
    <div class="container py-5 mt-5" style="padding-top:120px;">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg p-4">
                    <div class="row align-items-center">

                        <!-- Event Image -->
                        <div class="col-md-6 text-center">
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                                class="img-fluid rounded" style="max-height:500px;">
                        </div>

                        <!-- Booking Form -->
                        <div class="col-md-6">
                            <form id="bookingForm" method="POST" action="{{ route('razorpay.payment') }}">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h2 class="fw-bold mb-0">{{ $event->name }}</h2>
                                    @if ($event->total_tickets > 0)
                                        <span class="badge bg-success">Available</span>
                                    @else
                                        <span class="badge bg-danger">Sold Out</span>
                                    @endif
                                </div>

                                <p><strong>📅 Date :</strong> {{ $event->date->format('d-m-Y') }}
                                    @error('date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </p>
                                <p><strong>⏰ Time :</strong> 7:00 PM - 11:00 PM

                                </p>
                                {{-- event_id --}}
                                <p><strong>📍 Venue :</strong> {{ $event->location }}</p>
                                <p><strong>💰 Price per Ticket :</strong> ₹ {{ $event->price }}</p>

                                <div class="mb-3">
                                    <label class="form-label"><strong>🎫 Number of Tickets:</strong></label>
                                    <input type="number" name="tickets_booked" id="ticket_quantity" class="form-control"
                                        min="1" value="{{ old('tickets_booked', 1) }}">
                                    @error('tickets_booked')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><strong>🧾 Total Price:</strong></label>
                                    <input type="text" id="total_price" name="amount" class="form-control"
                                        value="₹ {{ $event->price }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label d-block">Booking Type</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="booking_type" value="online"
                                            checked>
                                        <label class="form-check-label">Online</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-gradient w-100 btn-lg">Proceed to Pay</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ticketInput = document.getElementById('ticket_quantity');
        const totalPriceInput = document.getElementById('total_price');
        const pricePerTicket = {{ $event->price }};

        ticketInput.addEventListener('input', () => {
            const quantity = parseInt(ticketInput.value) || 1;
            totalPriceInput.value = '₹ ' + (quantity * pricePerTicket);
        });
    </script>
@endsection
