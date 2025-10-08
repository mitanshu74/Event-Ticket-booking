<nav class="navbar navbar-expand-lg navbar-new fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="#"><i class="fa-solid fa-ticket-alt"></i> Event Booking</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="{{ route('user.home') }}#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('user.home') }}#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('user.home') }}#events">Events</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('user.home') }}#contact">Contact</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle user_fafa" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; color:black;">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="login_name">
                            {{ Auth::guard('web')->check() ? Auth::guard('web')->user()->username : 'Guest' }}
                        </span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @if (Auth::guard('web')->check())
                            <li><a class="dropdown-item" href="{{ route('booked_ticket') }}"> <i
                                        class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    Orders</a></li>
                            <li><a class="dropdown-item" href="{{ route('view_profile') }}"><i class="fa fa-user"
                                        aria-hidden="true"></i>
                                    View Profile</a></li>
                            <li>
                                @auth
                                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn dropdown-item"><i class="fa fa-lock"
                                                aria-hidden="true"></i>
                                            Logout</button>
                                    </form>
                                @else
                                    <a class="btn btn-signup ms-3" href="{{ route('user.login') }}">Login</a>
                                @endauth
                            </li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('user.login') }}">Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.register') }}">Register</a></li>
                        @endif
                    </ul>
                </li>

                {{-- <li class="nav-item">
                    @auth
                        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-signup ms-3">Logout</button>
                        </form>
                    @else
                        <a class="btn btn-signup ms-3" href="{{ route('user.login') }}">Login</a>
                    @endauth

                </li> --}}
                <!-- Add this script at the bottom of your Blade (before </body>) -->

            </ul>
        </div>
    </div>
</nav>
@push('script')
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
@endpush
