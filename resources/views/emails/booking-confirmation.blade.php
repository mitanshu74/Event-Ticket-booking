<!DOCTYPE html>
<html>

<head>
    <title>Booking Confirmation</title>
</head>

<body>
    <h2>Booking Confirmed!</h2>
    <p>Hello {{ $booking->user->username }},</p>
    <p>Your booking for the event <strong>{{ $booking->event->name }}</strong> has been confirmed.</p>
    <p><strong>Tickets Booked:</strong> {{ $booking->tickets_booked }}</p>
    <p><strong>Total Price:</strong> ₹ {{ $booking->total_price }}</p>
    <p>Event Date: {{ $booking->event->date->format('d-m-Y') }}</p>
    <p>Venue: {{ $booking->event->location }}</p>
    <p>Thank you for booking with us!</p>
</body>

</html>
