    @extends('Admin.layout.partials.master')
    @section('title', 'Admin - Manage Booking')

    @section('content')
        <div class="pc-content pb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="mb-0">Manage Booking</h4>
                    <div class="button">
                        <a href="{{ route('admin.home') }}" class="btn btn-success rounded text-white">Back</a>
                        <a href="{{ route('booking.create') }}" class="btn btn-primary rounded text-white">Booking</a>
                    </div>

                </div>
                @if (Auth::guard('admin')->user()->role == 1)
                    <div class="mx-3 mt-3">
                        <button id="bulkDeleteBtn" class="btn btn-danger ">Delete Selected</button>
                    </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">

                        {!! $html->table(['class' => 'table table-striped table-bordered', 'id' => 'bookingTable']) !!}
                    </div>
                    {{-- loader --}}
                    <div id="loading-overlay">
                        <div class="spinner"></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        {!! $html->scripts() !!}
    @endsection
    @push('script')
        <script>
            $(document).ready(function() {

                const overlay = document.getElementById('loading-overlay');
                // Show overlay
                function showLoader() {
                    overlay.style.display = 'flex';
                }

                // Select/Deselect All Checkboxes
                $(document).on('click', '#select-all', function() {
                    $('.task-checkbox').prop('checked', this.checked);
                });

                // Multi-delete
                $('#bulkDeleteBtn').on('click', function() {
                    let ids = [];
                    $('.task-checkbox:checked').each(function() {
                        ids.push($(this).val());
                    });

                    if (ids.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Booking Selected',
                            text: 'Please select at least one booking to delete.',
                            showCancelButton: true,
                        });
                        return;
                    }
                    Swal.fire({
                        title: 'Are you sure ?',
                        text: "Selected bookings will be deleted permanently.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('admin.MultiDelete') }}",
                                type: "POST",
                                data: {
                                    ids: ids,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(data) {
                                    if (data.success) {
                                        Swal.fire('Deleted!', data.message, 'success');
                                        $('#bookingTable').DataTable().ajax.reload();
                                        $('#select-all').prop('checked', false);
                                    } else {
                                        Swal.fire('Error!', data.message, 'error');
                                    }
                                },
                            });
                        }
                    });
                });

                // delete button
                $(document).on('click', '.delete-form button', function(e) {
                    e.preventDefault();
                    const form = $(this).closest('form');

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
                            $.ajax({
                                url: form.attr('action'),
                                type: 'POST',
                                data: form.serialize(),
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message ||
                                            'Booking deleted successfully.',
                                        showConfirmButton: true,
                                    });
                                    // Refresh datatable
                                    $('#bookingTable').DataTable().ajax.reload();
                                },
                                error: function(xhr) {
                                    $('#bookingTable').DataTable().ajax.reload();
                                    Swal.fire('Error!', 'Booked Ticket Not Found!',
                                        'error');
                                }
                            });
                        }
                    });
                });

                // Cancel confirmation with AJAX
                $(document).on('submit', '.cancel-form', function(e) {
                    e.preventDefault(); // prevent default submit
                    const form = this;
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to cancel this booking?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, cancel it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // submit the form normally
                            showLoader();
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
