@extends('Admin.layout.partials.master')
@section('title', 'Admin - Manage SubAdmin')
@section('content')
    <div class="pc-content">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="mb-0">Manage SubAdmin</h4>
                <div class="button">
                    <a href="{{ route('admin.home') }}" class="btn btn-success rounded text-white">Back</a>
                    <a href="{{ route('admin.addSubAdmin') }}" class="btn btn-primary rounded text-white">Add Sub Admin</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {!! $html->table() !!}
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
            const form = $(this);

            Swal.fire({
                title: 'Are you sure?',
                text: "This SubAdmin will be deleted permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
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
                        $('.dataTable').DataTable().ajax.reload(null, false);
                        Swal.fire({
                            icon: data.success ? 'success' : 'error',
                            title: data.success ? 'Deleted!' : 'Error',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function(xhr) {
                        $('.dataTable').DataTable().ajax.reload(null, false);
                        Swal.fire('error', 'SubAdmin Not Found!', 'error');
                    }
                });
            });
        });
    </script>
    {!! $html->scripts() !!}
@endpush
