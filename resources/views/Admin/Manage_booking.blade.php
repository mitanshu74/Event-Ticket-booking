@extends('Admin.layout.partials.master')
@section('title', 'Admin - Manage Booking')

@section('content')
    <div class="pc-content pb-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="mb-0">Manage Booking</h4>
                <a href="{{ route('booking.create') }}" class="btn btn-primary rounded text-white">Booking</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    {!! $html->table(['class' => 'table table-striped table-bordered', 'id' => 'events-table']) !!}
                </div>
            </div>
        </div>
    </div>
    {!! $html->scripts() !!}
    <script>
        $(document).on('submit', '.delete-form', function(e) {
            e.preventDefault(); // prevent default form submit

            const form = this;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // submit the form if confirmed
                }
            });
        });
    </script>
    <script>
        document.addEventListener('submit', function(e) {
            if (e.target.classList.contains('cancel-form')) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to cancel this booking!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.submit();
                    }
                });
            }
        });
    </script>


    @if (session('delete-booking'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('delete-booking') }}',
                showConfirmButton: true,
            });
        </script>
    @endif
    @if (session('booking'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('booking') }}',
                showConfirmButton: true,
            });
        </script>
    @endif


@endsection
