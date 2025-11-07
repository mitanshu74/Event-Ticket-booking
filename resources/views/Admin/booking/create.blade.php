@extends('Admin.layout.partials.master')
@section('title', 'Admin - Booking')

@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Booking</h4>
                        <a href="{{ route('booking.index') }}" class="btn btn-success rounded text-white">Back</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('booking.store') }}" id="bookingform" method="POST" class="needs-validation"
                            novalidate>
                            @csrf

                            @include('admin.booking.form')

                            <button type="submit" class="btn btn-primary">Booking</button>
                        </form>
                        <div id="loading-overlay">
                            <div class="spinner"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).on('submit', '.delete-form', function(e) {
            e.preventDefault();

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
                    form.submit();
                }
            });
        });
    </script>


    <script>
        const form = document.getElementById('bookingform');
        const overlay = document.getElementById('loading-overlay');

        form.addEventListener('submit', function() {
            overlay.style.display = 'flex';
        });
        const userSelect = document.getElementById('user_id');
        const emailInput = document.getElementById('email');
        const eventSelect = document.getElementById('event_id');
        const priceInput = document.getElementById('price');
        const dateInput = document.getElementById('date');
        const ticketsInput = document.getElementById('tickets_booked');
        const totalPriceInput = document.getElementById('total_price');

        function updateUserEmail() {
            emailInput.value = userSelect.selectedOptions[0]?.dataset.email || '';
        }

        function updateEventDetails() {
            const option = eventSelect.selectedOptions[0];
            priceInput.value = option?.dataset.price || 0;
            dateInput.value = option?.dataset.date || '';
            updateTotalPrice();
        }

        function updateTotalPrice() {
            const price = parseFloat(priceInput.value) || 0;
            const tickets = parseInt(ticketsInput.value) || 0;
            totalPriceInput.value = price * tickets;
        }

        userSelect.addEventListener('change', updateUserEmail);
        eventSelect.addEventListener('change', updateEventDetails);
        ticketsInput.addEventListener('input', updateTotalPrice);

        window.addEventListener('DOMContentLoaded', () => {
            updateUserEmail();
            updateEventDetails();
            updateTotalPrice();
        });
    </script>
@endpush
