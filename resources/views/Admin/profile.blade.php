@extends('Admin.layout.partials.master')
@section('title', 'Admin - Profile')
@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Admin Profile</h4>
                        <a href="{{ route('admin.home') }}" class="btn btn-success rounded text-white">Back</a>
                    </div>
                    <div class="card-body">
                        <form class="row g-3 needs-validation" method="POST" action="{{ route('admin.profile.update') }}"
                            novalidate>
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <label for="adminName" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" id="adminName"
                                        value="{{ old('name', Auth::guard('admin')->user()->name) }}"
                                        placeholder="Enter Admin Name" required>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Email -->
                                <div class="col-md-6 mt-3">
                                    <label for="adminEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="adminEmail"
                                        value="{{ old('email', Auth::guard('admin')->user()->email) }}"
                                        placeholder="Enter Admin Email" required>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Password -->
                                <div class="col-md-6 mt-3 position-relative">
                                    <label for="adminPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control pe-5" name="password" id="adminPassword"
                                        placeholder="Enter New Password (optional)">

                                    <!-- Eye icon -->
                                    <span class="toggle-password"
                                        style="position: absolute; top: 72%; right: 20px;font-size:17px; transform: translateY(-50%); cursor: pointer;">
                                        <i class="fa fa-eye-slash" id="toggleAdminPassword"></i>
                                    </span>
                                </div>
                            </div>
                            <!-- Submit -->
                            <div class="col-12 mt-3">
                                <button class="btn btn-success" type="submit">Update</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    @if (session('profile-updated'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('profile-updated') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.toggle-password').on('click', function() {
                const passwordField = $('#adminPassword');
                const toggleIcon = $('#toggleAdminPassword');

                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    toggleIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    passwordField.attr('type', 'password');
                    toggleIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });
        });
    </script>
@endpush
