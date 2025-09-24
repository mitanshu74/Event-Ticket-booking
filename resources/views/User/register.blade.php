<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Eventify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            transition: all 0.5s;
            background: linear-gradient(90deg, #4A90E2, #50E3C2);
        }
    </style>
</head>

<body>
    <div class="card p-4">
        <h3 class="text-center heading mb-4">Register</h3>
        <form id="registerForm">
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" placeholder="Enter full name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="Enter email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn btn-gradient w-100">Register</button>
            <p class="text-center mt-3">Already have an account? <a href="{{ route('user.login') }}">Login</a></p>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Registration Successful!');
            this.reset();
        });
    </script>
</body>

</html>