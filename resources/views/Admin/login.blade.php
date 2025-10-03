<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

    <!-- External CSS & Fonts -->
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-solid.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.css">

    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: url("{{ asset('image/pattern.png') }}")
        }

        .gd__login {
            padding: 30px;
            background: #fff;
            border: 1px solid #e9e9e9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .2)
        }

        .gd__form__logo {
            margin-bottom: 10px;
            display: flex;
            justify-content: center
        }

        .sign_in {
            color: #0A306C;
            font-weight: 700
        }

        .form-group {
            margin-bottom: 20px
        }

        .label_custome {
            color: #0A306C;
            font-weight: 500
        }

        .label_custome span {
            color: red
        }

        .gd-form-control {
            width: 100%;
            padding: .75rem;
            font-size: 16px;
            color: #000;
            background: #f6f7fa;
            border: 1px solid #e9e9e9;
            border-radius: 5px;
            outline: none;
            transition: .3s
        }

        .gd-form-control:focus {
            background: #fff
        }

        .password-container {
            position: relative
        }

        .password-container input {
            padding-right: 35px
        }

        .password-container i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer
        }

        .gd-button {
            height: 40px;
            padding: 8px 22px;
            font-size: 14px;
            background: #0A306C;
            color: #fff;
            border: 1px solid #0A306C;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .3s;
            position: relative;
            right: 143px;
        }

        .gd-button:hover {
            background: #08295b;
            border-color: #08295b;
        }

        .login-buttons {
            text-align: center;
            display: flex;
            justify-content: center
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-4 m-auto col-12">
            <div class="gd__login">
                <div class="gd__form__logo">
                    <!-- <img src="{{ asset('image/logo_change2.png') }}" alt="Logo"> -->
                </div>
                <form class="gd__contact__form" method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf
                    <h1 class="text-center sign_in">Login</h1>

                    <div class="form-group">
                        <label class="label_custome">Email Address <span>*</span></label>
                        <input type="email" placeholder="Enter Your Email" name="email" class="gd-form-control"
                            value="{{ old('email') }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="label_custome">Password <span>*</span></label>
                        <div class="password-container position-relative">
                            <input type="password" placeholder="Enter Your password" name="password"
                                class="gd-form-control">
                            <i class="fa fa-eye-slash toggle-password"></i>
                        </div>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="login-buttons">
                        <input type="submit" name="admin_login" class="gd-button" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('.toggle-password');
            const passwordInput = document.querySelector('input[name="password"]');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
</body>

</html>
