@extends('Admin.layout.partials.master')
@section('title', 'Admin - Manage SubAdmin')
@section('content')
    <div class="pc-content">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="mb-0">Manage SubAdmin</h4>
                <div class="button">
                    <a href="{{ route('admin.deshboard') }}" class="btn btn-success rounded text-white">Back</a>
                    <a href="{{ route('subadmin.create') }}" class="btn btn-primary rounded text-white">Add Sub Admin</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {!! $html->table() !!}
                </div>
            </div>
        </div>
    </div>
    {!! $html->scripts() !!}
@endsection
