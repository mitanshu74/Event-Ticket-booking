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
        document.addEventListener('DOMContentLoaded', function() {
            $(document).on('submit', '.cancel-booking-form', function(e) {
                e.preventDefault();
                const form = this;

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
                        form.submit();
                    }
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
@endsection
