<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Complete Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body onload="startPayment()">
    <h3 style="text-align: center">Processing Payment...</h3>

    <form name="razorpayForm" action="{{ route('razorpay.success') }}" method="POST">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="event_id" value="{{ $event->id }}">
    </form>

    <script>
        function startPayment() {
            var options = {
                "key": "{{ $razorpayKey }}",
                "amount": "{{ $amount * 100 }}",
                "currency": "INR",
                "name": "{{ $name }}",
                "description": "Event Booking",
                "order_id": "{{ $orderId }}",
                "handler": function(response) {
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                    document.forms['razorpayForm'].submit();
                },
                "prefill": {
                    "name": "{{ $name }}",
                    "email": "{{ $email }}",
                    "contact": "{{ $phone }}"
                },
                "theme": {
                    "color": "#3399cc"
                },
                "modal": {
                    "ondismiss": function() {
                        window.location.href = "{{ route('user.event.details', ['id' => $event->id]) }}";
                    }
                }
            };
            var rzp = new Razorpay(options);
            rzp.open();
        }
    </script>
</body>

</html>
