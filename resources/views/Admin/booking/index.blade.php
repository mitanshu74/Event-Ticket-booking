    @extends('Admin.layout.partials.master')
    @section('title', 'Admin - Manage Booking')

    @section('content')
        <div class="pc-content pb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="mb-0">Manage Booking</h4>
                    <div class="button">
                        <a href="{{ route('admin.deshboard') }}" class="btn btn-success rounded text-white">Back</a>
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

                        {!! $html->table() !!}
                    </div>
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

                function showLoader() {
                    overlay.style.display = 'flex';
                }

                $(document).on('click', '#select-all', function() {
                    $('.task-checkbox').prop('checked', this.checked);
                });

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
                                    $('.dataTable').DataTable().ajax.reload();
                                    Swal.fire({
                                        icon: data.success ? 'success' : 'Error',
                                        title: data.success ? 'Deleted !' : 'Error',
                                        text: data.message,
                                        confirmButtonText: 'OK'
                                    });
                                },
                            });
                        }
                    });
                });

                $(document).on('submit', '.cancel-form', function(e) {
                    e.preventDefault();
                    const form = this;
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you really want to Cansel this booking ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, cancel it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            showLoader();
                            form.submit();
                        }
                    });
                });

                $(document).on('submit', '.delete-form', function(e) {
                    e.preventDefault();
                    const form = $(this);
                    Swal.fire({
                        title: 'Are you sure ?',
                        text: "this booking will be deleted permantly",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'yes ,delete',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (!result.isConfirmed) return;

                        $.ajax({
                            url: form.attr('action'),
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                $('.dataTable').DataTable().ajax.reload();
                                Swal.fire({
                                    icon: data.success ? 'success' : 'Error',
                                    title: data.success ? 'Deleted' : 'Error',
                                    text: data.message,
                                    confirmButtonText: 'ok'
                                });
                            },
                            error: function(xhr) {
                                $('.dataTable').DataTable().ajax.reload();
                                Swal.fire('Error!', 'Event Not Found', 'error');
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
