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
                        <form action="{{ route('booking.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <!-- User -->
                            <div class="mb-3">
                                <label for="user_id" class="form-label">User</label>
                                <select name="user_id" id="user_id"
                                    class="form-select @error('user_id') is-invalid @enderror" required>
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" data-email="{{ $user->email }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->username }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    readonly placeholder="Email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Event -->
                            <div class="mb-3">
                                <label for="event_id" class="form-label">Event</label>
                                <select name="event_id" id="event_id"
                                    class="form-select @error('event_id') is-invalid @enderror" required>
                                    <option value="">Select Event</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->id }}" data-date="{{ $event->date->format('Y-m-d') }}"
                                            data-price="{{ $event->price }}"
                                            {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                            {{ $event->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('event_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date -->
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" name="date" id="date"
                                    class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}"
                                    readonly required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" name="price" id="price"
                                    class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}"
                                    readonly placeholder="Price">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tickets Booked -->
                            <div class="mb-3">
                                <label for="tickets_booked" class="form-label">Tickets Booked</label>
                                <input type="number" name="tickets_booked" id="tickets_booked"
                                    class="form-control @error('tickets_booked') is-invalid @enderror"
                                    value="{{ old('tickets_booked') }}" min="1" required placeholder="Tickets">
                                @error('tickets_booked')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Total Price -->
                            <div class="mb-3">
                                <label for="total_price" class="form-label">Total Price</label>
                                <input type="number" name="total_price" id="total_price"
                                    class="form-control @error('total_price') is-invalid @enderror"
                                    value="{{ old('total_price', 0) }}" readonly placeholder="Total Ticket Price">
                                @error('total_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Booking Type -->
                            <div class="mb-3">
                                <label class="form-label d-block">Booking Type</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('booking_type') is-invalid @enderror"
                                        type="radio" name="booking_type" value="offline"
                                        {{ old('booking_type', 'offline') == 'offline' ? 'checked' : '' }}>
                                    <label class="form-check-label">Offline</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Booking</button>
                        </form>
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
            e.preventDefault(); // Prevent default form submit

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
                    form.submit(); // Only submit if confirmed
                }
            });
        });
    </script>


    <script>
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
