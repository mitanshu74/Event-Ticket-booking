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

                </div>
            </div>
        </div>
        </div>
        {!! $html->scripts() !!}
    @endsection
    @push('script')
        <script>
            $(document).ready(function() {
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
                            showLoader();
                            $.ajax({
                                url: "{{ route('admin.MultiDelete') }}",
                                type: "POST",
                                data: {
                                    ids: ids,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(data) {
                                    hideLoader();
                                    $('.dataTable').DataTable().ajax.reload();
                                    Swal.fire({
                                        icon: data.success ? 'success' : 'Error',
                                        title: data.success ? 'Deleted !' : 'Error',
                                        text: data.message,
                                        confirmButtonText: 'OK'
                                    });
                                },
                                error: function(xhr) {
                                    hideLoader();
                                    $('.dataTable').DataTable().ajax.reload(null, false);
                                    Swal.fire('Error !', 'Record Not Found!', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
