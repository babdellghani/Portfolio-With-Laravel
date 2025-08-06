<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!-- User details -->
        <div class="user-profile text-center mt-3">
            <div class="d-flex align-items-center justify-content-center text-center">
                @if (Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt=""
                        class="avatar-md rounded-circle">
                @else
                    <div class="avatar-md rounded-circle bg-primary d-flex align-items-center justify-content-center">
                        <i class="ri-user-line text-white" style="font-size: 2rem;"></i>
                    </div>
                @endif
            </div>
            <div class="mt-3">
                <h4 class="font-size-16 mb-1">{{ Auth::user()->name }}</h4>
                <span class="text-muted">
                    {{ Auth::user()->username }}</span>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end">3</span>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if (auth()->user()->isAdmin())

                    <li class="menu-title">Content Management</li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-home-line"></i>
                            <span>Home</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('home.slide') }}">Home Slide</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-information-line"></i>
                            <span>About</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('admin.about') }}">Abouts</a></li>
                            <li><a href="{{ route('award') }}">Awards</a></li>
                            <li><a href="{{ route('education') }}">Educations</a></li>
                            <li><a href="{{ route('skill') }}">Skills</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{ route('service') }}" class="waves-effect">
                            <i class="ri-service-line"></i>
                            <span>Services</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.portfolio') }}" class="waves-effect">
                            <i class="ri-briefcase-line"></i>
                            <span>Portfolio</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('testimonial') }}" class="waves-effect">
                            <i class="ri-chat-quote-line"></i>
                            <span>Testimonials</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('partner') }}" class="waves-effect">
                            <i class="ri-team-line"></i>
                            <span>Partners</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('technology') }}" class="waves-effect">
                            <i class="ri-code-s-slash-line"></i>
                            <span>Technologies</span>
                        </a>
                    </li>

                    <li class="menu-title">System Management</li>

                    <li>
                        <a href="{{ route('website-info') }}" class="waves-effect">
                            <i class="ri-settings-4-line"></i>
                            <span>Website Info</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('contact') }}" class="waves-effect">
                            <i class="ri-mail-line"></i>
                            <span>Messages</span>
                            @php
                                $unreadCount = \App\Models\Contact::getUnreadCount();
                            @endphp
                            @if ($unreadCount > 0)
                                <span class="badge rounded-pill bg-danger float-end">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('users.index') }}" class="waves-effect">
                            <i class="ri-group-line"></i>
                            <span>User Management</span>
                            @php
                                $totalUsers = \App\Models\User::count();
                            @endphp
                            <span class="badge rounded-pill bg-info float-end">{{ $totalUsers }}</span>
                        </a>
                    </li>
                @endif

                <li class="menu-title">Account</li>

                <li>
                    <a href="{{ route('profile.edit') }}" class="waves-effect">
                        <i class="ri-user-settings-line"></i>
                        <span>Profile Settings</span>
                    </a>
                </li>

                @if (!auth()->user()->isAdmin())
                    <li>
                        <a href="{{ route('user.messages') }}" class="waves-effect">
                            <i class="ri-mail-line"></i>
                            <span>My Messages</span>
                            @php
                                $userMessagesCount = \App\Models\Contact::where('user_id', auth()->id())->count();
                                $userRepliesCount = \App\Models\Contact::where('user_id', auth()->id())
                                    ->where('is_replied', true)
                                    ->count();
                            @endphp
                            @if ($userMessagesCount > 0)
                                <span class="badge rounded-pill bg-primary float-end">{{ $userMessagesCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}" class="waves-effect">
                            <i class="ri-home-4-line"></i>
                            <span>View Website</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
