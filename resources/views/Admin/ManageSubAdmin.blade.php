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
                    {!! $html->table(['class' => 'table table-striped table-bordered', 'id' => 'subAdmin-table']) !!}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).on('submit', '.delete-form', function(e) {
            e.preventDefault();
            const form = $(this);
            const deleteUrl = form.attr('action');

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
                    url: deleteUrl,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        $('#subAdmin-table').DataTable().ajax.reload(null, false);
                        Swal.fire({
                            icon: data.success ? 'success' : 'error',
                            title: data.success ? 'Deleted!' : 'Error',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Something went wrong!', 'error');
                    }
                });
            });
        });
    </script>
    {!! $html->scripts() !!}

    @if (session('add_subAdmin'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('add_subAdmin') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if (session('Update-SubAdmin'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('Update-SubAdmin') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
