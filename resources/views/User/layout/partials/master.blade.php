<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Eventify - Ticket Booking')</title>

    <!-- Bootstrap -->
    {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    {{-- lightbox --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">

    {{-- <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"> --}}
    <style>
        /* -------- your styles (kept mostly as before) -------- */
        .navbar-new {
            background: linear-gradient(90deg, #4A90E2, #50E3C2) !important;
            padding: 1rem 0;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.4s ease;
        }

        .event_image {
            height: 400px;
            border-radius: 5px;
        }

        .navbar-new .navbar-brand {
            color: #fff;
        }

        .navbar-new .nav-link {
            color: #fff;
            margin: 0 0.7rem;
            font-weight: 500;
            transition: 0.3s;
        }

        .navbar-new .nav-link:hover {
            color: #F5A623;
        }

        .navbar-new .btn-signup {
            background: #F5A623;
            color: #fff;
            border-radius: 30px;
            padding: .35rem 1.2rem;
            font-weight: 700;
        }

        .navbar-new.scrolled {
            background: linear-gradient(90deg, #3C7CBF, #45C8A6);
            padding: .6rem 0;
        }

        /* carousel image captions */
        .carousel-caption {
            bottom: 30%;
            transform: translateY(0);
        }

        .carousel-caption h1 {
            text-shadow: 0 6px 20px rgba(0, 0, 0, 0.5);
        }

        .carousel-caption p {
            text-shadow: 0 4px 14px rgba(0, 0, 0, 0.45);
        }

        .event-card {
            border-radius: 15px;
            overflow: hidden;
            background: #fff;
            transition: 0.3s;
        }

        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .event-card h5 {
            color: #4A90E2;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .event-card .btn-gradient {
            background: #50E3C2;
            color: #fff;
            border-radius: 30px;
        }

        body,
        .bg-light {
            background: #F8F9FA;
        }

        .contact-section {
            background: #333;
            color: #fff;
        }

        .line {
            width: 60px;
            height: 4px;
            background: #F5A623;
            margin: 0 auto;
            border-radius: 10px;
        }

        .book {
            color: #0A306C;
        }


        /* ensure carousel image fills area */
        .carousel-item img {
            object-fit: cover;
            height: 75vh;
        }

        /* desktop */
        @media (max-width:768px) {
            .carousel-item img {
                height: 55vh;
            }
        }

        .btn-gradient {
            background: linear-gradient(90deg, #50E3C2, #4A90E2) !important;
            /* Blue-Green gradient */
            color: #fff;
            font-weight: bold;
            border-radius: 30px;
            padding: 0.5rem 1rem;
            transition: all 0.3s;
        }

        .btn-gradient:hover {
            /* Reverse gradient on hover */
            transform: scale(1.02);
            color: #fff;
        }

        .footer {
            background: #111;
            color: #bbb;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    @include('User.layout.partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('User.layout.partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- lightbox --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

    @stack('scripts')
</body>

</html>
