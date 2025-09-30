<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SubAdmin Credentials</title>
</head>
subAdmin

<body>
    <h2>Hello {{ $subAdmin->name }},</h2>

    <p>Your SubAdmin account has been created. Here are your login credentials:</p>

    <p><b>Email:</b> {{ $subAdmin->email }}</p>
    <p><b>Password:</b> {{ $password }}</p>

    <p>Please change your password after logging in.</p>

    <p><a href="{{ url('/admin/login') }}"
            style="background:#3490dc;color:#fff;padding:10px 20px;text-decoration:none;border-radius:5px;">Login Now</a>
    </p>

    <p>Thanks</p>
</body>

</html>
