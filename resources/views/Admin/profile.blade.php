@extends('Admin.layout.partials.master')
@section('title', 'Admin - Profile')
@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Admin Profile</h4>
                        <a href="{{ route('admin.home') }}" class="btn btn-success rounded text-white">Back</a>
                    </div>
                    <div class="card-body">
                        <form class="row g-3 needs-validation" method="POST" action="{{ route('admin.profile.update') }}"
                            novalidate>
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="adminName" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" id="adminName"
                                        value="{{ old('name', auth()->guard('admin')->user()->name) }}"
                                        placeholder="Enter Admin Name" required>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Email -->
                                <div class="col-md-6 mt-3">
                                    <label for="adminEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="adminEmail"
                                        value="{{ old('email', auth()->guard('admin')->user()->email) }}"
                                        placeholder="Enter Admin Email" required>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Password -->
                                <div class="col-md-6 mt-3">
                                    <label for="adminPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="adminPassword"
                                        placeholder="Enter New Password (optional)">
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
@endsection