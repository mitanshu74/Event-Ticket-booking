@extends('Admin.layout.partials.master')
@section('title', 'Admin - Manage Event')

@section('content')
    <div class="pc-content pb-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="mb-0">Manage Event</h4>
                <div class="button">
                    <a href="{{ route('admin.home') }}" class="btn btn-success rounded text-white">Back</a>
                    <a href="{{ route('admin.addEvent') }}" class="btn btn-primary rounded text-white">Add Event</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    {!! $html->table(['class' => 'table table-striped table-bordered', 'id' => 'events-table']) !!}
                </div>
            </div>
        </div>
    </div>
    {!! $html->scripts() !!}
@endsection
@push('script')
    <script>
        $(document).on('submit', '.delete-form', function(e) {
            e.preventDefault();
            const form = $(this);

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
                    url: form.attr('action'),
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
                        Swal.fire('Error!', 'Event Not Found!', 'error');
                    }
                });
            });
        });
    </script>
@endpush
