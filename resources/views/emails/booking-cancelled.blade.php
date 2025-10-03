<!DOCTYPE html>
<html>

<head>
    <title>Booking Cancelled</title>
</head>

<body>
    <h2>Booking Cancelled</h2>
    <p>Hello {{ $booking->user->username }},</p>
    <p>Your booking for the event <strong>{{ $booking->event->name }}</strong> has been cancelled.</p>
    <p><strong>Tickets Cancelled:</strong> {{ $booking->tickets_booked }}</p>
    <p>Event Date: {{ $booking->event->date->format('d-m-Y') }}</p>
    <p>Venue: {{ $booking->event->location }}</p>
    <p>If you have already made a payment, it will be refunded according to our policy.</p>
    <p>Thank you.</p>
</body>

</html>
