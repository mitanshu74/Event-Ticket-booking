@extends('Admin.layout.partials.master')
@section('title', 'Admin - Manage Event')
@section('content')
    <div class="pc-content">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="mb-0">Manage Event</h4>
                <a href="{{ route('admin.addEvent') }}" class="btn btn-primary rounded text-white">Add Event</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {!! $html->table() !!}
                </div>
            </div>
        </div>
        <script>
            {!! $html->scripts() !!}
        </script>
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
@endsection
