<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('payment'))
        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Payment Details</h5>
            </div>
            <div class="card-body">
                <p><strong>Payment ID:</strong> {{ session('payment')->razorpay_payment_id }}</p>
                <p><strong>Amount:</strong> ₹{{ session('payment')->amount }}</p>
            </div>
            <div class="card-body">
                <a href="{{ route('user.home') }}" class="btn btn-primary rounded text-white">Back to Home</a>
            </div>
        </div>
    @endif

</body>

</html>
