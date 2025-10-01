<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="{{ asset('Admin\Bootstrap\css\bootstrap.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        .login_heading {
            color: #0A306C;
        }

        .login_btn {
            border: 1px solid #0A306C;
        }

        .login_btn:hover {
            color: white;
            background-color: #0A306C;
        }

        .side-image {
            width: 93%;
            height: 658px !important;
        }

        .card-body {
            padding-right: 50px !important;
        }

        .select_image {
            height: 100px !important;
            width: 100px;
        }

        .login_heading {}
    </style>
</head>
<!-- KEEP YOUR HEAD & CSS SAME -->

<body class="bg-light">

    <section class="py-5">
        <div class="container">

            <div class="pc-content pb-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="mb-0">👤 Profile Information</h4>
                        <a href="{{ route('show_profile') }}" class="btn btn-primary rounded text-white">Update
                            Profile</a>
                    </div>
                    <div class="card-body">

                        <div class="card-header bg-white border-0">
                            <h5 class="mb-0">🎟 My Booked Events</h5>
                        </div>
                        <div class="card-body">

                            @if (Auth::user()->bookings->isEmpty())
                                <p class="text-muted">No bookings yet.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Event</th>
                                                <th>Price</th>
                                                <th>Tickets</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (Auth::user()->bookings as $index => $booking)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $booking->event->name }}</td>
                                                    <td>₹{{ $booking->event->price }}</td>
                                                    <td>{{ $booking->tickets_booked }}</td>
                                                    <td>₹{{ $booking->total_price }}</td>
                                                    <td>
                                                        @if (strtolower($booking->status) == 'confirmed')
                                                            <span class="badge bg-success">{{ $booking->status }}</span>
                                                        @elseif(strtolower($booking->status) == 'cancelled')
                                                            <span class="badge bg-danger">{{ $booking->status }}</span>
                                                        @else
                                                            <span
                                                                class="badge bg-secondary">{{ $booking->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $booking->created_at->format('d M Y') }}</td>
                                                    <td>
                                                        <form action="{{ route('user.booking.cancel', $booking->id) }}"
                                                            method="POST" class="cancel-booking-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            @if ($booking->status == 'confirmed')
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-warning">Cancel</button>
                                                            @endif
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.cancel-booking-form');

            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Prevent default form submission

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, cancel it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit form if confirmed
                        }
                    });
                });
            });
        });
    </script>


    @if (session('user-booking-cansel'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('user-booking-cansel') }}',
                showConfirmButton: true,
            });
        </script>
    @endif


    <script>
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>

</body>

</html>
