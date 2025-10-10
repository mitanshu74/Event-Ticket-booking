<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Complete Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body onload="startPayment()">
    <h3 style="text-align: center">Processing Payment...</h3>
    {{-- razorpay.payment blade --}}
    <form id="razorpaySuccessForm" action="{{ route('razorpay.success') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
        {{-- IMPORTANT: this is the origin flag we will use in success() --}}
        <input type="hidden" name="from_page" id="from_page" value="{{ $from_page ?? 'event_details' }}">
    </form>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        // Configure Razorpay checkout
        const options = {
            key: "{{ $razorpayKey }}",
            amount: {{ $amount * 100 }}, // paise
            currency: "INR",
            name: "{{ $event->name ?? 'Event' }}",
            order_id: "{{ $orderId }}",
            prefill: {
                name: "{{ $name }}",
                email: "{{ $email }}",
                contact: "{{ $phone }}"
            },
            handler: function(response) {
                // put razorpay response into hidden form and submit to server
                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                document.getElementById('razorpay_signature').value = response.razorpay_signature;
                document.getElementById('from_page').value = "{{ $from_page ?? 'event_details' }}";
                document.getElementById('razorpaySuccessForm').submit();
            },
            modal: {
                ondismiss: function() {
                    // optional: go back if user closed modal
                    window.location.href = "{{ url()->previous() }}";
                }
            }
        };

        // open checkout on page load — or on button click if you prefer
        const rzp = new Razorpay(options);
        rzp.open();
    </script>

</body>

</html>
