<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Eventify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #F8F9FA;
        }

        .heading {
            color: #0A306C;
            font-weight: 750;
        }

        .card {
            max-width: 500px;
            margin: 110px auto;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .btn-gradient {
            background: linear-gradient(90deg, #50E3C2, #4A90E2);
            color: #fff;
            border-radius: 30px;
            transition: all 0.5s;
        }

        .btn-gradient:hover {
            background: linear-gradient(90deg, #4A90E2, #50E3C2);
        }
    </style>
</head>

<body>
    <div class="card p-4">
        <h3 class="text-center heading mb-4">Register</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('user.register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                    placeholder="Enter full name" value="{{ old('username') }}">
                @error('username')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="Enter email" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 position-relative">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password"
                    class="form-control pe-5 @error('password') is-invalid @enderror" placeholder="Enter password">

                    <span class="toggle-password"
                    style="position: absolute; top: 70%; right: 15px; transform: translateY(-50%); cursor: pointer;">
                    <i class="fa fa-eye-slash" id="toggleIcon"></i>
                </span>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Mobile Number</label>
                <input type="number" name="number" class="form-control @error('number') is-invalid @enderror"
                    placeholder="Enter mobile number" value="{{ old('number') }}">
                @error('number')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter address">{{ old('address') }}</textarea>
                @error('address')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                    <option value="">Select Gender</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('gender')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Profile Image</label>
                <input type="file" name="UserImage" id="UserImage"
                    class="form-control @error('UserImage') is-invalid @enderror" accept="image/*">

                @error('UserImage')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror

                <div class="mt-2">
                    <img id="previewImage" src="#" alt="Preview"
                        style="width: 120px; height: 100px; display: none; border:1px solid #ccc; padding:3px;">
                </div>
            </div>

            <button type="submit" class="btn btn-gradient w-100">Register</button>
            <p class="text-center mt-3">Already have an account ? <a href="{{ route('user.login') }}">Login</a></p>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#UserImage").change(function(e) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $("#previewImage")
                        .attr("src", e.target.result)
                        .show();
                };
                reader.readAsDataURL(this.files[0]);
            });
        });
    <script>
        $(document).ready(function() {
            $('.toggle-password').on('click', function() {
                const passwordField = $('#password');
                const toggleIcon = $('#toggleIcon');

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
</body>

</html>
