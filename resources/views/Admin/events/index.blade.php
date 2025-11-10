@extends('Admin.layout.partials.master')
@section('title', 'Admin - Manage Event')

@section('content')
    <div class="pc-content pb-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="mb-0">Manage Event</h4>
                <div class="button">
                    <a href="{{ route('admin.deshboard') }}" class="btn btn-success rounded text-white">Back</a>
                    <a href="{{ route('event.create') }}" class="btn btn-primary rounded text-white">Add Event</a>
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

