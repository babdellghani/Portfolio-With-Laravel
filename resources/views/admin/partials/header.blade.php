<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ $websiteInfo && $websiteInfo->favicon ? ($websiteInfo->favicon && str_starts_with($websiteInfo->favicon, 'defaults_images/') ? asset($websiteInfo->favicon) : asset('storage/' . $websiteInfo->favicon)) : asset('defaults_images/favicon.ico') }}"
                            alt="logo-sm" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ $websiteInfo && $websiteInfo->logo_black ? ($websiteInfo->logo_black && str_starts_with($websiteInfo->logo_black, 'defaults_images/') ? asset($websiteInfo->logo_black) : asset('storage/' . $websiteInfo->logo_black)) : asset('frontend/assets/img/logo/logo_black.png') }}"
                            alt="{{ $websiteInfo ? $websiteInfo->site_name : 'Logo' }}" height="20">
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ $websiteInfo && $websiteInfo->favicon ? ($websiteInfo->favicon && str_starts_with($websiteInfo->favicon, 'defaults_images/') ? asset($websiteInfo->favicon) : asset('storage/' . $websiteInfo->favicon)) : asset('defaults_images/favicon.ico') }}"
                            alt="logo-sm-light" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ $websiteInfo && $websiteInfo->logo_white ? ($websiteInfo->logo_white && str_starts_with($websiteInfo->logo_white, 'defaults_images/') ? asset($websiteInfo->logo_white) : asset('storage/' . $websiteInfo->logo_white)) : asset('frontend/assets/img/logo/logo_white.png') }}"
                            alt="{{ $websiteInfo ? $websiteInfo->site_name : 'Logo' }}" height="20">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="ri-search-line"></span>
                </div>
            </form>


        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ri-search-line"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="mb-3 m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="ri-search-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-notification-3-line"></i>
                    @php
                        $unreadContactCount = \App\Models\Contact::getUnreadCount();
                    @endphp
                    @if ($unreadContactCount > 0)
                        <span class="noti-dot"></span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0">Notifications</h6>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('contact') }}" class="small">View All</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;" id="notificationsList">
                        @if ($unreadContactCount > 0)
                            @php
                                $recentContacts = \App\Models\Contact::getRecentUnread(5);
                            @endphp
                            @foreach ($recentContacts as $contact)
                                <a href="{{ route('contact.show', $contact) }}" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                <i class="ri-mail-line"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mb-1">{{ $contact->name }}</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">{{ Str::limit($contact->message, 50) }}</p>
                                                <p class="mb-0">
                                                    <i class="mdi mdi-clock-outline"></i>
                                                    {{ $contact->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <div class="avatar-md mx-auto mb-3">
                                    <div class="avatar-title bg-light rounded-circle">
                                        <i class="ri-notification-off-line text-muted" style="font-size: 1.5rem;"></i>
                                    </div>
                                </div>
                                <p class="text-muted">No new notifications</p>
                            </div>
                        @endif
                    </div>
                    <div class="p-2 border-top">
                        <div class="d-grid">
                            <a class="btn btn-sm btn-link font-size-14 text-center" href="{{ route('contact') }}">
                                <i class="mdi mdi-arrow-right-circle me-1"></i> View All Messages
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block user-dropdown">
                <button type="button"
                    class="btn header-item waves-effect d-flex align-items-center justify-content-center"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    @if (Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Header Avatar"
                            class="rounded-circle header-profile-user">
                    @else
                        <div
                            class="rounded-circle header-profile-user bg-primary d-flex align-items-center justify-content-center">
                            <i class="ri-user-line text-white"></i>
                        </div>
                    @endif
                    <span class="d-none d-xl-inline-block ms-1">
                        {{ Auth::user()->name }}
                        <small class="d-block text-muted">
                            <span
                                class="badge badge-soft-{{ Auth::user()->isAdmin() ? 'primary' : 'secondary' }} badge-sm">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </small>
                    </span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- User Info -->
                    <div class="dropdown-item-text">
                        <div class="d-flex align-items-center">
                            @if (Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="User Avatar"
                                    class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2"
                                    style="width: 32px; height: 32px;">
                                    <i class="ri-user-line text-white" style="font-size: 14px;"></i>
                                </div>
                            @endif
                            <div>
                                <div class="fw-bold">{{ Auth::user()->name }}</div>
                                <small class="text-muted">{{ Auth::user()->email }}</small>
                                <div>
                                    <span
                                        class="badge badge-soft-{{ Auth::user()->isAdmin() ? 'primary' : 'secondary' }} badge-sm">
                                        {{ ucfirst(Auth::user()->role) }}
                                    </span>
                                    <span
                                        class="badge badge-soft-{{ Auth::user()->getStatusBadgeClass() === 'badge-soft-success' ? 'success' : 'danger' }} badge-sm">
                                        {{ ucfirst(Auth::user()->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>

                    <!-- Profile -->
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="ri-user-line align-middle me-1"></i> Profile Settings
                    </a>

                    @if (Auth::user()->isAdmin())
                        <!-- Admin Only Items -->
                        <a class="dropdown-item" href="{{ route('dashboard') }}">
                            <i class="ri-dashboard-line align-middle me-1"></i> Dashboard
                        </a>
                        <a class="dropdown-item" href="{{ route('users.index') }}">
                            <i class="ri-group-line align-middle me-1"></i> User Management
                        </a>
                        <a class="dropdown-item" href="{{ route('contact') }}">
                            <i class="ri-mail-line align-middle me-1"></i> Messages
                            @php
                                $unreadCount = \App\Models\Contact::getUnreadCount();
                            @endphp
                            @if ($unreadCount > 0)
                                <span class="badge badge-soft-danger badge-sm ms-1">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    @endif

                    <!-- Website Link -->
                    <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                        <i class="ri-external-link-line align-middle me-1"></i> View Website
                    </a>

                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item text-danger" type="submit">
                            <i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="ri-settings-2-line"></i>
                </button>
            </div>

        </div>
    </div>
</header>
