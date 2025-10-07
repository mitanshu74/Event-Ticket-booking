@extends('User.layout.partials.master')
@section('title', 'Payment Success')
@section('content')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'success',
                title: 'Payment Successful!',
                html: `
            <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
            <p><strong>Event:</strong> {{ $event->name }}</p>
            <p><strong>Tickets:</strong> {{ $booking->tickets_booked }}</p>
            <p><strong>Amount Paid:</strong> ₹{{ $payment->amount }}</p>
        `,
                confirmButtonText: 'Go to Home'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('user.home') }}";
                }
            });
        });
    </script>

@endsection
