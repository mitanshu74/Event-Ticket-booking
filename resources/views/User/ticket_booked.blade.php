@extends('User.layout.partials.master')

@section('title', 'booked ticket')

@section('content')


    <div class="container mt-5">
        <div class="pc-content pt-5 pb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="mb-0">👤 Profile Information</h4>
                    <div class="button">
                        <a href="{{ route('user.home') }}" class="btn btn-success rounded text-white">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">🎟 My Booked Events</h5>
                    </div>
                    <div class="card-body" style="height: 450px">
                        {!! $html->table(['class' => 'table table-striped table-bordered', 'id' => 'UserbookingTable']) !!}

                        {!! $html->scripts() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            // Laravel errors from session
            @if ($errors->any())
                let errorMsg = '';
                @foreach ($errors->all() as $error)
                    errorMsg += '{{ $error }}<br>';
                @endforeach
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: errorMsg
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}'
                });
            @endif

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}'
                });
            @endif

            // Use DataTable's draw event to attach SweetAlert to dynamic buttons
            let table = $('#UserbookingTable').DataTable();

            table.on('draw', function() {

                // Cancel booking confirmation
                $('.cancel-booking-form').off('submit').on('submit', function(e) {
                    e.preventDefault();
                    const form = this;
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, cancel it!',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });

                // Pay booking confirmation
                $('.pay-booking-btn').off('click').on('click', function(e) {
                    e.preventDefault();
                    const url = $(this).attr('href');
                    Swal.fire({
                        title: 'Proceed to payment?',
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
@endsection
