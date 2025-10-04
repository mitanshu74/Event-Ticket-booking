@extends('Admin.layout.partials.master')
@section('title', 'Admin - Manage Event')

@section('content')
    <div class="pc-content pb-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="mb-0">Manage Event</h4>
                <a href="{{ route('admin.addEvent') }}" class="btn btn-primary rounded text-white">Add Event</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    {!! $html->table(['class' => 'table table-striped table-bordered', 'id' => 'events-table']) !!}
                </div>
            </div>
        </div>

        @if (session('Add-Event'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('Add-Event') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif
    </div>
    {!! $html->scripts() !!}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).on('submit', '.delete-form', function(e) {
            e.preventDefault();
            const form = $(this);
            const deleteUrl = form.attr('action');

            Swal.fire({
                title: 'Are you sure?',
                text: "This event will be deleted permanently.",
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
                        $('#events-table').DataTable().ajax.reload();
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



@endsection
