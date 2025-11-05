@extends('User.layout.partials.master')
@section('title', 'Event Details')
@section('content')
    <div class="container py-5 mt-5" style="padding-top:120px;">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg p-4">
                    <div class="row align-items-center">

                        <div class="col-md-6 text-center">
                            @php
                                $images = json_decode($event->image, true) ?? [];
                                $firstImage = $images[0] ?? null;
                            @endphp

                            @if ($firstImage)
                                <a href="{{ asset('storage/' . $firstImage) }}" data-lightbox="event-gallery">
                                    <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $event->title }}"
                                        class="img-fluid rounded mb-3" style="max-height:500px; object-fit:cover;">
                                </a>
                            @endif
                            @if (count($images) > 1)
                              
                                @foreach (array_slice($images, 1) as $img)
                                    <a href="{{ asset('storage/' . $img) }}" data-lightbox="event-gallery"
                                        class="d-none"></a>
                                @endforeach
                            @endif

                            <div class="text-start">
                                <h5 class="fw-bold mb-3 text-primary">
                                    🍽 Additional Facilities
                                </h5>
                                <ul class="list-unstyled ps-2 mb-0">
                                    <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i><span
                                            class="fw-semibold fs-6">Welcome Drink</span></li>
                                    <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i><span
                                            class="fw-semibold fs-6">Lunch Included</span></li>
                                    <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i><span
                                            class="fw-semibold fs-6">Dinner Buffet</span></li>
                                    <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i><span
                                            class="fw-semibold fs-6">Swimming Pool Access</span></li>
                                    <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i><span
                                            class="fw-semibold fs-6">Live Music & Entertainment</span></li>
                                    <li class="mb-2"><i class="fa fa-check-circle text-success me-2"></i><span
                                            class="fw-semibold fs-6">Parking Facility</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form id="bookingForm" method="POST" action="{{ route('razorpay.payment') }}">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <input type="hidden" name="from_page" value="event_details">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h2 class="fw-bold mb-0">{{ $event->name }}</h2>
                                    @if ($event->total_tickets > 0)
                                        <span class="badge bg-success">Available</span>
                                    @else
                                        <span class="badge bg-danger">Sold Out</span>
                                    @endif
                                </div>

                                <p><strong>📅 Date :</strong> {{ $event->date->format('jS M Y') }}
                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </p>

                                <p><strong>⏰ Time :</strong> {{ $event->start_time->format('h:i A') }} -
                                    {{ $event->end_time->format('h:i A') }}</p>
                                <p><strong>📍 Venue :</strong> {{ $event->location }}</p>
                                <p><strong>💰 Price per Ticket :</strong> ₹ {{ $event->price }}</p>

                                <div class="mb-3">
                                    <label class="form-label"><strong>🎫 Number of Tickets:</strong></label>
                                    <input type="number" name="tickets_booked" id="ticket_quantity" class="form-control"
                                        value="{{ old('tickets_booked', 1) }}">
                                    @error('tickets_booked')
                                        <span class="text-danger">{{ $message }}</span>
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
