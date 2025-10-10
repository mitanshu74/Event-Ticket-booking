@extends('User.layout.partials.master')

@section('title', 'booked ticket')

@section('content')

    <section class="py-5 mt-5">
        <div class="container pt-4">

            <div class="card shadow-sm border-0 mb-4">
                <div class="card hei">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="mb-0">👤 Profile Information</h4>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('User_profile.update') }}" enctype="multipart/form-data"
                            class="row g-3 needs-validation">
                            @csrf
                            @method('PUT')

                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control"
                                    value="{{ old('username', Auth::guard('web')->user()->username) }}">
                                @error('username')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', Auth::guard('web')->user()->email) }}">
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 password-wrapper">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Leave blank to keep same">
                                <i class="fa fa-eye-slash toggle-password"
                                    style="position: relative;left: 590px;bottom: 32px;"></i>
                                @error('password')
                                    <div class="invalid-feedback d-block" style="position: relative;bottom: 25px;">
                                        {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="number" name="number" class="form-control"
                                    value="{{ old('number', Auth::guard('web')->user()->number) }}">
                                @error('number')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2">{{ old('address', Auth::guard('web')->user()->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Gender</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="male"
                                        {{ old('gender', Auth::guard('web')->user()->gender) == 'male' ? 'checked' : '' }}>
                                    <label class="form-check-label">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="female"
                                        {{ old('gender', Auth::guard('web')->user()->gender) == 'female' ? 'checked' : '' }}>
                                    <label class="form-check-label">Female</label>
                                </div>
                                @error('gender')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Profile Image</label>
                                <input type="file" name="UserImage" class="form-control" id="imageInput"
                                    onchange="displayImage()">
                                <img id="previewImage"
                                    src="{{ Auth::guard('web')->user()->image ? asset('storage/' . Auth::guard('web')->user()->image) : '' }}"
                                    class="mt-2 rounded border" style="height:80px; width:80px;">
                                @error('UserImage')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 text-end">
                                <button class="btn btn-primary">Update Profile</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
    </section>

@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Success alert for profile update
            @if (session('user_profile_update'))
                Swal.fire({
                    icon: 'success',
                    title: 'Profile Updated',
                    text: '{{ session('user_profile_update') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            @endif

            // Password toggle
            const togglePassword = document.querySelector('.password-wrapper .toggle-password');
            const passwordInput = document.querySelector('.password-wrapper input[name="password"]');
            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }

            // Image preview
            const imageInput = document.getElementById('imageInput');
            const previewImage = document.getElementById('previewImage');
            if (imageInput) {
                imageInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }
        });
    </script>
@endpush
