<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="" class="b-brand text-primary d-flex">
                <img src="assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar"> </a>
        </div>
        <div class="navbar-content overflow-auto">
            <div class="card pc-user-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="mb-0"></h6>
                            <small>Administrator</small>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="pc-navbar">
                <li class="pc-item pc-caption mx-0 px-4">
                    <label>Admin Panel</label>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-layer"></use>
                            </svg> </span>Event
                        <span class="pc-arrow">
                            <i data-feather="chevron-right"></i>
                        </span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link" href="{{ route('admin.addSubAdmin') }}">Manage Event</a>
                        </li>
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-shopping-bag"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Sub Admin</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link" href="{{ Route('admin.manageSubAdmin') }}">Manage Sub Admin
                            </a>
                        </li>
                        <!-- <li class="pc-item">
                            <a class="pc-link" href="add_product.html">Add Product
                            </a>
                        </li> -->
                        <!-- <li class="pc-item">
                <a class="pc-link" href="https://ableproadmin.com/admins/helpdesk-customer.html">Popular Product
                </a>
              </li> -->
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
