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

<body>

    <section class="background-main-image">
        <div class="container py-4 h-100">
            <div class="row d-flex justify-content-center align-items-center 100vh">
                <div class="col col-xl-10 mx-4">
                    <div class="card" style="border-radius: 1rem; box-shadow: 3px 3px 25px #0A306C;">
                        <div class="row p-4 ">

                            {{-- <div class="col-md-10 col-lg-7 mt-4 d-flex ">
                                <div class="card-body text-black" style="position: relative;left: 250px;"> --}}

                            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                                class="needs-validation" novalidate>
                                @csrf
                                @method('PUT')

                                <div class="text-center mb-3">
                                    <span class="h1 fw-bold mb-0 login_heading">User Information</span>
                                </div>

                                {{-- Username --}}
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username"
                                        class="form-control @error('username') is-invalid @enderror"
                                        value="{{ old('username', Auth::user()->username) }}" required>
                                    @error('username')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', Auth::user()->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div class="mb-3">
                                    <label class="form-label">New Password <small class="text-muted">(Leave blank to
                                            keep current)</small></label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Enter New Password">
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Phone Number --}}
                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" name="number"
                                        class="form-control @error('number') is-invalid @enderror"
                                        value="{{ old('number', Auth::user()->number) }}" required>
                                    @error('number')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Address --}}
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" required>{{ old('address', Auth::user()->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Gender --}}
                                <div class="mb-3">
                                    <label class="form-label">Gender</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="male"
                                            {{ old('gender', Auth::user()->gender) == 'male' ? 'checked' : '' }}>
                                        <label class="form-check-label">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="female"
                                            {{ old('gender', Auth::user()->gender) == 'female' ? 'checked' : '' }}>
                                        <label class="form-check-label">Female</label>
                                    </div>
                                    @error('gender')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Profile Image --}}
                                <div class="mb-3">
                                    <label class="form-label">Profile Image</label>
                                    <input type="file" name="UserImage" id="imageInput"
                                        class="form-control @error('UserImage') is-invalid @enderror" accept="image/*"
                                        onchange="displayImage()">
                                    @error('UserImage')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <img id="previewImage"
                                        src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : '' }}"
                                        alt="Selected Image"
                                        style="height:100px; width:100px; border:1px solid #ccc; margin-top:10px;">
                                </div>
                                <div class="col-1">
                                    <button type="submit" class="btn btn-success btn-sm w-100">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</body>

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
