<nav class="navbar navbar-expand-lg navbar-new fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="#"><i class="fa-solid fa-ticket-alt"></i> Event Booking</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#events">Events</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                <li class="nav-item">
                    <a href="{{ route('profile') }}" class="user_fafa" style="text-decoration: none; color:black;">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="login_name">
                            {{ Auth::check() ? Auth::user()->username : 'Guest' }}
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    @auth
                        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-signup ms-3">Logout</button>
                        </form>
                    @else
                        <a class="btn btn-signup ms-3" href="{{ route('user.login') }}">Login</a>
                    @endauth

                </li>
                <!-- Add this script at the bottom of your Blade (before </body>) -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    document.getElementById('logout-button')?.addEventListener('click', function(e) {
                        e.preventDefault(); // prevent default link behavior
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You will be logged out from your account.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, logout!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('logout-form').submit();
                            }
                        });
                    });
                </script>

            </ul>
        </div>
    </div>
</nav>
