<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Eventify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background: #F8F9FA;
        }

        .card {
            max-width: 400px;
            margin: 146px auto;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .heading {
            color: #0A306C;
            font-weight: 750;
        }

        .btn-gradient {
            background: linear-gradient(90deg, #50E3C2, #4A90E2);
            color: #fff;
            border-radius: 30px;
            transition: all 0.5s;
        }

        .btn-gradient:hover {
            transition: all 0.5s;
            background: linear-gradient(90deg, #4A90E2, #50E3C2);
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: relative;
            left: 250px;
            top: 46px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
        }

        .toggle-password:hover {
            color: #4A90E2;
        }
    </style>
</head>

<body>
    <div class="card p-4">
        <h3 class="text-center heading mb-4">Login</h3>
        <form method="POST" action="{{ route('user.login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email"
                    value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 password-wrapper">
                <label class="form-label">Password</label>
                <i class="fa fa-eye-slash toggle-password"></i>

                <input type="password" name="password" class="form-control" placeholder="Enter password">

                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror

            </div>

            <button type="submit" class="btn btn-gradient w-100">Login</button>
            <p class="text-center mt-3">Don't have an account ? <a href="{{ route('user.register') }}">Register</a></p>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if (session('login_first'))
            Swal.fire({
                icon: 'warning',
                title: 'Login Required',
                text: "{{ session('login_first') }}",
                confirmButtonColor: '#4A90E2'
            });
        @endif
    </script>
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
</body>

</html>
