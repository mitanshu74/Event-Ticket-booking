@extends('Admin.layout.partials.master')
@section('title', 'Admin - Add SubAdmin')
@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Add SubAdmin</h4>
                        <a href="{{ route('subadmin.index') }}" class="btn btn-success rounded text-white">Back</a>
                    </div>
                    <div class="card-body">
                        <form class="g-3 needs-validation" id="subAdminForm" action="{{ route('subadmin.store') }}"
                            method="POST" novalidate>
                            @csrf
                            @include('admin.subAdmin.form')
                            <div class="col-12 mt-3">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>


                            <div id="loading-overlay">
                                <div class="spinner"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script>
        const form = document.getElementById('subAdminForm');
        const overlay = document.getElementById('loading-overlay');

        form.addEventListener('submit', function() {
            overlay.style.display = 'flex';
        });
    </script>
@endpush
