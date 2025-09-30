@extends('Admin.layout.partials.master')
@section('title', 'Admin - Manage Booking')

@section('content')
    <div class="pc-content pb-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="mb-0">Manage Booking</h4>
                <a href="{{ route('booking.create') }}" class="btn btn-primary rounded text-white">Booking</a>
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
