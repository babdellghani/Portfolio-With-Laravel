<header>
    <div id="sticky-header" class="menu__area transparent-header">
        <div class="container custom-container">
            <div class="row">
                <div class="col-12">
                    <div class="mobile__nav__toggler"><i class="fas fa-bars"></i></div>
                    <div class="menu__wrap">
                        <nav class="menu__nav">
                            <div class="logo">
                                <a href="{{ route('home') }}" class="logo__black">
                                    <img src="{{ $websiteInfo && $websiteInfo->logo_black ? ($websiteInfo->logo_black && str_starts_with($websiteInfo->logo_black, 'defaults_images/') ? asset($websiteInfo->logo_black) : asset('storage/' . $websiteInfo->logo_black)) : asset('frontend/assets/img/logo/logo_black.png') }}"
                                        alt="{{ $websiteInfo ? $websiteInfo->site_name : 'Logo' }}">
                                </a>
                                <a href="{{ route('home') }}" class="logo__white">
                                    <img src="{{ $websiteInfo && $websiteInfo->logo_white ? ($websiteInfo->logo_white && str_starts_with($websiteInfo->logo_white, 'defaults_images/') ? asset($websiteInfo->logo_white) : asset('storage/' . $websiteInfo->logo_white)) : asset('frontend/assets/img/logo/logo_white.png') }}"
                                        alt="{{ $websiteInfo ? $websiteInfo->site_name : 'Logo' }}">
                                </a>
                            </div>
                            <div class="navbar__wrap main__menu d-none d-xl-flex">
                                <ul class="navigation">
                                    <li class="{{ request()->routeIs('home') ? 'active' : '' }}"><a
                                            href="{{ route('home') }}">Home</a></li>
                                    <li class="{{ request()->routeIs('about') ? 'active' : '' }}"><a
                                            href="{{ route('about') }}">About</a></li>
                                    <li class="{{ request()->routeIs('services') ? 'active' : '' }}"><a
                                            href="{{ route('services') }}">Services</a></li>
                                    <li class="{{ request()->routeIs('portfolio') ? 'active' : '' }}"><a
                                            href="{{ route('portfolio') }}">Portfolio</a></li>
                                    <li class="{{ request()->routeIs('blog.index') ? 'active' : '' }}"><a
                                            href="{{ route('blog.index') }}">Blog</a></li>
                                    <li><a href="{{ route('contact-us') }}">contact me</a></li>
                                    @guest
                                        <li class="auth-item">
                                            <a href="{{ route('login') }}" class="auth-link login-link">
                                                <i class="fas fa-sign-in-alt auth-icon"></i>
                                                <span class="auth-text ms-2">Login</span>
                                            </a>
                                        </li>
                                        <li class="auth-item">
                                            <a href="{{ route('register') }}" class="auth-link register-link">
                                                <i class="fas fa-user-plus auth-icon"></i>
                                                <span class="auth-text ms-2">Register</span>
                                            </a>
                                        </li>
                                    @else
                                        <li class="auth-item authenticated">
                                            <a href="{{ route('dashboard') }}" class="auth-link dashboard-link">
                                                <i class="fas fa-tachometer-alt auth-icon"></i>
                                                <span class="auth-text ms-2">Dashboard</span>
                                                <span class="auth-badge ms-2">{{ Auth::user()->name }}</span>
                                            </a>
                                        </li>
                                    @endguest
                                </ul>
                            </div>
                            <div class="header__btn d-none d-md-block">
                                <a href="{{ route('contact-us') }}" class="btn btn-primary contact-btn">
                                    <i class="fas fa-envelope btn-icon"></i>
                                    <span class="ms-2">Contact me</span>
                                </a>
                            </div>
                        </nav>
                    </div>
                    <!-- Mobile Menu  -->
                    <div class="mobile__menu">
                        <nav class="menu__box">
                            <div class="close__btn"><i class="fal fa-times"></i></div>
                            <div class="nav-logo">
                                <a href="{{ route('home') }}" class="logo__black">
                                    <img src="{{ $websiteInfo && $websiteInfo->logo_black ? ($websiteInfo->logo_black && str_starts_with($websiteInfo->logo_black, 'defaults_images/') ? asset($websiteInfo->logo_black) : asset('storage/' . $websiteInfo->logo_black)) : asset('frontend/assets/img/logo/logo_black.png') }}"
                                        alt="{{ $websiteInfo ? $websiteInfo->site_name : 'Logo' }}">
                                </a>
                                <a href="{{ route('home') }}" class="logo__white">
                                    <img src="{{ $websiteInfo && $websiteInfo->logo_white ? ($websiteInfo->logo_white && str_starts_with($websiteInfo->logo_white, 'defaults_images/') ? asset($websiteInfo->logo_white) : asset('storage/' . $websiteInfo->logo_white)) : asset('frontend/assets/img/logo/logo_white.png') }}"
                                        alt="{{ $websiteInfo ? $websiteInfo->site_name : 'Logo' }}">
                                </a>
                            </div>
                            <div class="menu__outer">
                                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                            </div>
                            <div class="social-links">
                                <ul class="clearfix">
                                    @if ($websiteInfo && $websiteInfo->facebook_url)
                                        <li><a href="{{ $websiteInfo->facebook_url }}" target="_blank"><i
                                                    class="fab fa-facebook-f"></i></a></li>
                                    @endif
                                    @if ($websiteInfo && $websiteInfo->twitter_url)
                                        <li><a href="{{ $websiteInfo->twitter_url }}" target="_blank"><i
                                                    class="fab fa-twitter"></i></a></li>
                                    @endif
                                    @if ($websiteInfo && $websiteInfo->behance_url)
                                        <li><a href="{{ $websiteInfo->behance_url }}" target="_blank"><i
                                                    class="fab fa-behance"></i></a></li>
                                    @endif
                                    @if ($websiteInfo && $websiteInfo->linkedin_url)
                                        <li><a href="{{ $websiteInfo->linkedin_url }}" target="_blank"><i
                                                    class="fab fa-linkedin-in"></i></a></li>
                                    @endif
                                    @if ($websiteInfo && $websiteInfo->instagram_url)
                                        <li><a href="{{ $websiteInfo->instagram_url }}" target="_blank"><i
                                                    class="fab fa-instagram"></i></a></li>
                                    @endif
                                    @if ($websiteInfo && $websiteInfo->youtube_url)
                                        <li><a href="{{ $websiteInfo->youtube_url }}" target="_blank"><i
                                                    class="fab fa-youtube"></i></a></li>
                                    @endif
                                    @if ($websiteInfo && $websiteInfo->pinterest_url)
                                        <li><a href="{{ $websiteInfo->pinterest_url }}" target="_blank"><i
                                                    class="fab fa-pinterest"></i></a></li>
                                    @endif
                                    @if (
                                        !$websiteInfo ||
                                            (!$websiteInfo->facebook_url &&
                                                !$websiteInfo->twitter_url &&
                                                !$websiteInfo->behance_url &&
                                                !$websiteInfo->linkedin_url &&
                                                !$websiteInfo->instagram_url &&
                                                !$websiteInfo->youtube_url &&
                                                !$websiteInfo->pinterest_url))
                                        <!-- Fallback static links -->
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                        <li><a href="#"><i class="fab fa-pinterest"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <div class="menu__backdrop"></div>
                    <!-- End Mobile Menu -->
                </div>
            </div>
        </div>
    </div>
</header>
