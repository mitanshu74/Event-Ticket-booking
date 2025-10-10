@extends('User.layout.partials.master')

@section('title', 'booked ticket')

@section('content')

    <div class="container mt-5">
        <div class="pc-content pt-5 pb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="mb-0">👤 Profile Information</h4>
                </div>
                <div class="card-body">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">🎟 My Booked Events</h5>
                    </div>
                    {{-- loader --}}
                    <div id="loading-overlay">
                        <div class="spinner"></div>
                    </div>
                    <div class="card-body" style="height: auto;">
                        <div class="row g-4">
                            @forelse($bookings as $booking)
                                @php
                                    $event = $booking->event;
                                    $images = json_decode($event->image, true) ?? [];
                                    $firstImage = $images[0] ?? 'placeholder.jpg';
                                @endphp

                                <div class="col-md-3">
                                    <div class="event-card shadow-sm rounded-3 overflow-hidden border">
                                        <a href="{{ asset('storage/' . $firstImage) }}"
                                            data-lightbox="event-{{ $event->id }}">
                                            <img src="{{ asset('storage/' . $firstImage) }}" class="w-100"
                                                alt="{{ $event->name }}" style="height: 250px; object-fit: cover;">
                                        </a>

                                        {{-- Hidden images for lightbox --}}
                                        @if (count($images) > 1)
                                            @foreach (array_slice($images, 1) as $img)
                                                <a href="{{ asset('storage/' . $img) }}"
                                                    data-lightbox="event-{{ $event->id }}" class="d-none"></a>
                                            @endforeach
                                        @endif
                                        <div class="p-3">
                                            <h5 class="d-flex justify-content-between align-items-center">
                                                {{ $event->name }}
                                                @if ($booking->status === 'confirmed')
                                                    <span class="badge bg-success">Confirmed</span>
                                                @elseif ($booking->status === 'cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @else
                                                    <span class="badge bg-secondary">Pending</span>
                                                @endif
                                            </h5>
                                            <p class="mb-2">📅 {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
                                            </p>
                                            <p class="mb-2">📍 {{ $event->location }}</p>
                                            <p class="mb-2">⌚
                                                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') . ' to ' . \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                                            </p>
                                            {{-- Tickets --}}
                                            <p class="mb-2">💰<span class="ms-1">Price : {{ $event->price }}</span>
                                            </p>
                                            <p class="mb-2"> 🎟 Tickets :<span
                                                    class="ms-2">{{ $booking->tickets_booked }}</span></p>

                                            {{-- <p class="mb-2"> <span
                                                    class="total-price mb-2">{{ $booking->total_price }}</span>
                                            </p> --}}
                                            <p class="mb-2">💸<span class="ms-1">Total :
                                                    {{ $booking->total_price }}</span>
                                                {{-- <p class="mb-2"> ₹ <span class="ms-1">{{ $booking->total_price }}</span> --}}

                                                {{-- ₹ --}}
                                            <div class="mt-3">
                                                @if ($booking->status === 'pending')
                                                    <a href="{{ route('razorpay.payment.redirect', ['bookingId' => $booking->id, 'from' => 'ticket_booked']) }}"
                                                        class="btn btn-primary w-100 pay-booking-btn"> 💸 Pay Now </a>
                                                @elseif ($booking->status === 'confirmed')
                                                    <form action="{{ route('user.booking.cancel', $booking->id) }}"
                                                        method="POST" class="cancel-booking-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-warning w-100">
                                                            Cancel
                                                        </button>
                                                    </form>
                                                @endif

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            @empty
                                <div class="col-12 text-center">
                                    <p>No booked tickets found.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const overlay = document.getElementById('loading-overlay');
            // Show overlay
            function showLoader() {
                overlay.style.display = 'flex';
            }

            // Pay Now confirmation
            document.querySelectorAll('.pay-booking-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.href;

                    Swal.fire({
                        title: 'Proceed to Payment?',
                        text: "You will be redirected to Razorpay.",
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Pay Now',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            showLoader();
                            window.location.href = url;
                        }
                    });
                });
            });

            // Cancel confirmation
            document.querySelectorAll('.cancel-booking-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you really want to cancel this booking?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, cancel it!',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            showLoader();
                            form.submit();
                        }
                    });
                });
            });
            // Pay Now confirmation
            document.querySelectorAll('.pay-booking-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.href;

                    Swal.fire({
                        title: 'Proceed to Payment?',
                        text: "You will be redirected to Razorpay.",
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Pay Now',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            window.location.href = url;
                        }
                    });
                });
            });

        });
    </script>
@endpush
