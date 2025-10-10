<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'Home')</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui" />
    <meta http-equiv="X-UA-Compatible" />
    <!-- [Font] Family -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/fonts/inter/inter.css') }}" id="main-font-link" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/fonts/tabler-icons.min.css') }}" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/fonts/feather.css') }}" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/fonts/fontawesome.css') }}" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/fonts/material.css') }}" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/style.css') }}" id="main-style-link" />
    <!-- <link rel="stylesheet" href="./View/admin_panel/assets/css/style-preset.css" /> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Admin/Bootstrap/css/bootstrap.min.css') }}" />
    {{-- old font-awesome link --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- new font-awesome link --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> --}}

    {{-- datatable links --}}
    {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    {{-- lightbox --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">

    <style>
        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            overflow: hidden;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .table thead th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .user-avtar {
            border-radius: 50%;
            width: 60px;
        }

        /* loader show on cansel end pa */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        #loading-overlay .spinner {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #007bff;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head><!-- [Head] end --><!-- [Body] Start -->

<body>

    @include('Admin.layout.partials.header')
    @include('Admin.layout.partials.sidebar')

    <div class="pc-container">
        @yield('content')
    </div>

    <!-- [ Main Content ] end -->
    @include('Admin.layout.partials.footer')

    <script>
        // Get all the dropdown toggle elements
        const dropdownToggles = document.querySelectorAll('.pc-link');
        this.addEventListener('click', function(event) {
            this.classList.toggle('show'); // Toggle the 'show' class to show/hide the submenu
        });
    </script>
    <script src="{{ asset('Admin/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('Admin/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('Admin/assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('Admin/assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('Admin/assets/js/plugins/feather.min.js') }}"></script>
    {{-- light box --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

    @stack('script')
    {{-- <script>
        layout_rtl_change("false");
    </script> --}}
</body>

</html>
