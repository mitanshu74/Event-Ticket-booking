<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Otp Verify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin/js/semantic.min.html') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background-color: #f9fafb;
            display: grid;
            height: 100vh;
            place-items: center;
        }

        .containers {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px,
                rgba(0, 0, 0, 0.1) 0px 0px 1px 0px;
            max-width: 450px;
            background-color: white;
            padding: 2.3em;
            width: 100%;
            border-radius: 7px;
            position: relative;
        }

        hr {
            margin: 1rem 0;
            border: 0;
            opacity: 1;
            width: 50%;
            margin: 0 auto;
        }

        .otp {
            position: relative;
            font-size: 16px;
            left: 285px;
        }

        .form-control:focus {
            border: 2px solid rgb(13, 110, 253) !important;
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
    <div class="containers">
        <div class="heading text-center">
            <h1 class="heading-text">Sign In</h1>
            <hr class="border-top border-4 mb-3 border-primary rounded" />
        </div>
        <div class="sign_in">
            <form method="POST" action="">
                @csrf
                <div class="mb-4">
                    <input type="hidden" class="form-control" name="email" value="{{ $email }}" />
                </div>
                <div class="mb-4">
                    <label class="form-label"> Enter Otp</label>
                    <input type="password" name="otp" id="otp" class="form-control" placeholder="Enter  otp"
                        required />
                </div>
                <div class="sign_in d-grid my-4">
                    <button type="submit" class="btn btn-gradient w-100" name="verify-otp"
                        style="font-size: 16px">verify
                        OTP</button>
                </div>
            </form>
            <form method="POST" action="{{ route('resend-otp') }}">
                @csrf
                <div class="mb-4">
                    <input type="hidden" class="form-control" name="email" value="{{ $email }}" />
                </div>

                <div class="sign_in d-grid my-4">
                    <button type="submit" class="btn btn-gradient w-100" name="verify-otp"
                        style="font-size: 16px">resend
                        OTP</button>
                </div>
            </form>
            @if ($errors->has('otp'))
                <div class="text-danger">{{ $errors->first('otp') }}</div>
            @endif
        </div>

    </div>
    @if (session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'success',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    @if (session('first_register'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'success',
                text: "{{ session('first_register') }}",
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    @if (session('logout_user'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'success',
                text: "{{ session('logout_user') }}",
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
</body>

</html>
