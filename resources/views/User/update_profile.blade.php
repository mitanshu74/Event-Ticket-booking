<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="{{ asset('Admin\Bootstrap\css\bootstrap.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        .login_heading {
            color: #0A306C;
        }

        .login_btn {
            border: 1px solid #0A306C;
        }

        .login_btn:hover {
            color: white;
            background-color: #0A306C;
        }

        .side-image {
            width: 93%;
            height: 658px !important;
        }

        .card-body {
            padding-right: 50px !important;
        }

        .select_image {
            height: 100px !important;
            width: 100px;
        }

        .login_heading {}
    </style>
</head>
<!-- KEEP YOUR HEAD & CSS SAME -->

<body class="bg-light">

    <section class="py-5">
        <div class="container">

            <div class="card shadow-sm border-0 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="mb-0">👤 Profile Information</h4>
                        <a href="{{ route('user.home') }}" class="btn btn-success rounded text-white">Back</a>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                            class="row g-3 needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control"
                                    value="{{ old('username', Auth::guard('web')->user()->username) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', Auth::guard('web')->user()->email) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Leave blank to keep same">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="tel" name="number" class="form-control"
                                    value="{{ old('number', Auth::guard('web')->user()->number) }}" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2" required>{{ old('address', Auth::guard('web')->user()->address) }}</textarea>
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
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Profile Image</label>
                                <input type="file" name="UserImage" class="form-control" id="imageInput"
                                    onchange="displayImage()">
                                <img id="previewImage"
                                    src="{{ Auth::guard('web')->user()->image ? asset('storage/' . Auth::guard('web')->user()->image) : '' }}"
                                    class="mt-2 rounded border" style="height:80px; width:80px;">
                            </div>

                            <div class="col-12 text-end">
                                <button class="btn btn-primary">Update Profile</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
    </section>
    @if (session('user_profile_update'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Profile Updated',
                text: 'Your profile has been updated successfully!',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <script>
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>

    <script>
        function displayImage() {
            const imageInput = document.getElementById('imageInput');
            const previewImage = document.getElementById('previewImage');

            if (imageInput.files && imageInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                };

                reader.readAsDataURL(imageInput.files[0]);

            } else {
                previewImage.src = '';
            }
        }
    </script>
</body>

</html>
