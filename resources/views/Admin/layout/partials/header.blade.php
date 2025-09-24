<header class="pc-header">
    <div class="header-wrapper">
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                        <img src="assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar"></a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center pt-3 pb-0 justify-content-between">
                            <h5 class="m-0">Profile</h5>
                        </div>
                        <div class="dropdown-body">
                            <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
                                <div class="d-flex mb-1">
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">🖖</h6>
                                        <span>
                                            <p class="__cf_email__ mb-0">Administrator</p>
                                        </span>
                                    </div>
                                </div>
                                <hr class="border-secondary border-opacity-50">
                            </div>
                            <p class="text-span mb-0">Manage</p>
                            <a href="{{ route('admin.profile') }}" class="dropdown-item">
                                <span>
                                    <svg class="pc-icon text-muted me-2">
                                        <use xlink:href="#custom-setting-outline"></use>
                                    </svg>
                                    <span>Profile</span>
                                </span>
                            </a>

                            <hr class="border-secondary border-opacity-50">
                            <div class="d-grid mb-0">
                                <a class="btn btn-danger" href="{{ route('admin.logout') }}">logout</a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>