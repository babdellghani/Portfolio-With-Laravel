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

            @auth
                @if (Auth::user()->isAdmin())
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-notification-3-line"></i>
                            @php
                                $unreadContactCount = \App\Models\Contact::getUnreadCount();
                                $unreadNotificationsCount = Auth::user()->unreadNotifications()->count();
                                $totalUnread = $unreadContactCount + $unreadNotificationsCount;
                            @endphp
                            @if ($totalUnread > 0)
                                <span class="noti-dot"></span>
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0">Notifications ({{ $totalUnread }})</h6>
                                    </div>
                                    <div class="col-auto">
                                        <button onclick="markAllNotificationsAsRead()"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="ri-check-double-line me-1"></i>Mark All Read
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 300px;" id="notificationsList">
                                <div data-simplebar style="max-height: 300px;" id="notificationsList">
                                    {{-- All Notifications --}}
                                    @php
                                        $recentNotifications = Auth::user()->unreadNotifications()->take(5)->get();
                                    @endphp
                                    @foreach ($recentNotifications as $notification)
                                        @if (isset($notification->data['type']) && $notification->data['type'] === 'user_registration')
                                            <a href="{{ route('users.index') }}" class="text-reset notification-item"
                                                onclick="markNotificationAsRead('{{ $notification->id }}')">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-success rounded-circle font-size-16">
                                                            <i class="ri-user-add-line"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h6 class="mb-1">New User Registration</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">
                                                                {{ $notification->data['message'] ?? 'New user registered' }}
                                                            </p>
                                                            <p class="mb-0">
                                                                <i class="mdi mdi-clock-outline"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @elseif (isset($notification->data['type']) && $notification->data['type'] === 'blog_created')
                                            <a href="{{ route('admin.blogs.index') }}" class="text-reset notification-item"
                                                onclick="markNotificationAsRead('{{ $notification->id }}')">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-info rounded-circle font-size-16">
                                                            <i class="ri-article-line"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h6 class="mb-1">New Blog Post</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">
                                                                {{ $notification->data['message'] ?? 'New blog post created' }}
                                                            </p>
                                                            <p class="mb-0">
                                                                <i class="mdi mdi-clock-outline"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @elseif (isset($notification->data['type']) && $notification->data['type'] === 'blog_updated')
                                            <a href="{{ route('admin.blogs.index') }}"
                                                class="text-reset notification-item"
                                                onclick="markNotificationAsRead('{{ $notification->id }}')">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-warning rounded-circle font-size-16">
                                                            <i class="ri-edit-line"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h6 class="mb-1">Blog Post Updated</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">
                                                                {{ $notification->data['message'] ?? 'Blog post updated' }}
                                                            </p>
                                                            <p class="mb-0">
                                                                <i class="mdi mdi-clock-outline"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @elseif (isset($notification->data['type']) && $notification->data['type'] === 'comment_created')
                                            <a href="{{ route('admin.comments.index') }}"
                                                class="text-reset notification-item"
                                                onclick="markNotificationAsRead('{{ $notification->id }}')">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span
                                                            class="avatar-title bg-secondary rounded-circle font-size-16">
                                                            <i class="ri-chat-3-line"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h6 class="mb-1">New Comment</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">
                                                                {{ $notification->data['message'] ?? 'New comment posted' }}
                                                            </p>
                                                            <p class="mb-0">
                                                                <i class="mdi mdi-clock-outline"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @elseif (isset($notification->data['type']) && $notification->data['type'] === 'comment_updated')
                                            <a href="{{ route('admin.comments.index') }}"
                                                class="text-reset notification-item"
                                                onclick="markNotificationAsRead('{{ $notification->id }}')">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-dark rounded-circle font-size-16">
                                                            <i class="ri-chat-edit-line"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h6 class="mb-1">Comment Updated</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">
                                                                {{ $notification->data['message'] ?? 'Comment updated' }}
                                                            </p>
                                                            <p class="mb-0">
                                                                <i class="mdi mdi-clock-outline"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @elseif (isset($notification->data['type']) && $notification->data['type'] === 'category_created')
                                            <a href="{{ route('admin.categories.index') }}"
                                                class="text-reset notification-item"
                                                onclick="markNotificationAsRead('{{ $notification->id }}')">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-purple rounded-circle font-size-16">
                                                            <i class="ri-folder-add-line"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h6 class="mb-1">New Category</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">
                                                                {{ $notification->data['message'] ?? 'New category created' }}
                                                            </p>
                                                            <p class="mb-0">
                                                                <i class="mdi mdi-clock-outline"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @elseif (isset($notification->data['type']) && $notification->data['type'] === 'category_updated')
                                            <a href="{{ route('admin.categories.index') }}"
                                                class="text-reset notification-item"
                                                onclick="markNotificationAsRead('{{ $notification->id }}')">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-orange rounded-circle font-size-16">
                                                            <i class="ri-folder-edit-line"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h6 class="mb-1">Category Updated</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">
                                                                {{ $notification->data['message'] ?? 'Category updated' }}
                                                            </p>
                                                            <p class="mb-0">
                                                                <i class="mdi mdi-clock-outline"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @elseif (isset($notification->data['type']) && $notification->data['type'] === 'tag_created')
                                            <a href="{{ route('admin.tags.index') }}"
                                                class="text-reset notification-item"
                                                onclick="markNotificationAsRead('{{ $notification->id }}')">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-cyan rounded-circle font-size-16">
                                                            <i class="ri-price-tag-3-line"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h6 class="mb-1">New Tag</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">
                                                                {{ $notification->data['message'] ?? 'New tag created' }}
                                                            </p>
                                                            <p class="mb-0">
                                                                <i class="mdi mdi-clock-outline"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @elseif (isset($notification->data['type']) && $notification->data['type'] === 'tag_updated')
                                            <a href="{{ route('admin.tags.index') }}"
                                                class="text-reset notification-item"
                                                onclick="markNotificationAsRead('{{ $notification->id }}')">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-teal rounded-circle font-size-16">
                                                            <i class="ri-price-tag-edit-line"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h6 class="mb-1">Tag Updated</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">
                                                                {{ $notification->data['message'] ?? 'Tag updated' }}</p>
                                                            <p class="mb-0">
                                                                <i class="mdi mdi-clock-outline"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @elseif (isset($notification->data['type']) && $notification->data['type'] === 'comment_reply')
                                            <a href="{{ route('blog.show', $notification->data['blog_slug'] ?? '#') }}"
                                                class="text-reset notification-item"
                                                onclick="markNotificationAsRead('{{ $notification->id }}')">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-purple rounded-circle font-size-16">
                                                            <i class="ri-reply-line"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h6 class="mb-1">Comment Reply</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">
                                                                {{ $notification->data['message'] ?? 'Someone replied to your comment' }}
                                                            </p>
                                                            <p class="mb-0">
                                                                <i class="mdi mdi-clock-outline"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @else
                                            {{-- Handle legacy notifications without type --}}
                                            <a href="{{ route('users.index') }}" class="text-reset notification-item"
                                                onclick="markNotificationAsRead('{{ $notification->id }}')">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-info rounded-circle font-size-16">
                                                            <i class="ri-notification-line"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h6 class="mb-1">Notification</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">
                                                                {{ $notification->data['message'] ?? 'You have a new notification' }}
                                                            </p>
                                                            <p class="mb-0">
                                                                <i class="mdi mdi-clock-outline"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach

                                    {{-- Contact Message Notifications --}}
                                    @if ($unreadContactCount > 0)
                                        @php
                                            $recentContacts = \App\Models\Contact::getRecentUnread(3);
                                        @endphp
                                        @foreach ($recentContacts as $contact)
                                            <a href="{{ route('contact.show', $contact) }}"
                                                class="text-reset notification-item">
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
                                    @endif

                                    @if ($totalUnread === 0)
                                        <div class="text-center py-4">
                                            <div class="avatar-md mx-auto mb-3">
                                                <div class="avatar-title bg-light rounded-circle">
                                                    <i class="ri-notification-off-line text-muted"
                                                        style="font-size: 1.5rem;"></i>
                                                </div>
                                            </div>
                                            <p class="text-muted">No new notifications</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-2 border-top">
                                    <div class="d-grid">
                                        <a class="btn btn-sm btn-link font-size-14 text-center"
                                            href="{{ route('contact') }}">
                                            <i class="mdi mdi-arrow-right-circle me-1"></i> View All Messages
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Regular User Notifications --}}
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon waves-effect"
                                id="page-header-user-notifications-dropdown" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ri-notification-3-line"></i>
                                @php
                                    $userUnreadNotifications = Auth::user()->unreadNotifications()->count();
                                @endphp
                                @if ($userUnreadNotifications > 0)
                                    <span class="noti-dot"></span>
                                @endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-user-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0">Notifications ({{ $userUnreadNotifications }})</h6>
                                        </div>
                                        <div class="col-auto">
                                            <button onclick="markUserNotificationsAsRead()"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="ri-check-double-line me-1"></i>Mark All Read
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 300px;" id="userNotificationsList">
                                    @php
                                        $userNotifications = Auth::user()->unreadNotifications()->take(5)->get();
                                    @endphp
                                    @foreach ($userNotifications as $notification)
                                        @if (isset($notification->data['type']) && $notification->data['type'] === 'admin_reply')
                                            <a href="{{ route('user.messages.show', $notification->data['contact_id'] ?? '') }}"
                                                class="text-reset notification-item"
                                                onclick="markUserNotificationAsRead('{{ $notification->id }}')">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-success rounded-circle font-size-16">
                                                            <i class="ri-reply-line"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h6 class="mb-1">Admin Reply</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">
                                                                {{ $notification->data['message'] ?? 'Admin replied to your message' }}
                                                            </p>
                                                            <p class="mb-0">
                                                                <i class="mdi mdi-clock-outline"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @elseif (isset($notification->data['type']) && $notification->data['type'] === 'comment_reply')
                                            <a href="{{ route('blog.show', $notification->data['blog_slug'] ?? '#') }}"
                                                class="text-reset notification-item"
                                                onclick="markNotificationAsRead('{{ $notification->id }}')">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-purple rounded-circle font-size-16">
                                                            <i class="ri-reply-line"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h6 class="mb-1">Comment Reply</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">
                                                                {{ $notification->data['message'] ?? 'Someone replied to your comment' }}
                                                            </p>
                                                            <p class="mb-0">
                                                                <i class="mdi mdi-clock-outline"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @else
                                            {{-- Handle other notification types for regular users --}}
                                            <a href="{{ route('user.messages') }}" class="text-reset notification-item"
                                                onclick="markUserNotificationAsRead('{{ $notification->id }}')">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-info rounded-circle font-size-16">
                                                            <i class="ri-notification-line"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h6 class="mb-1">Notification</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">
                                                                {{ $notification->data['message'] ?? 'You have a new notification' }}
                                                            </p>
                                                            <p class="mb-0">
                                                                <i class="mdi mdi-clock-outline"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach

                                    @if ($userUnreadNotifications === 0)
                                        <div class="text-center py-4">
                                            <div class="avatar-md mx-auto mb-3">
                                                <div class="avatar-title bg-light rounded-circle">
                                                    <i class="ri-notification-off-line text-muted"
                                                        style="font-size: 1.5rem;"></i>
                                                </div>
                                            </div>
                                            <p class="text-muted">No new notifications</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-2 border-top">
                                    <div class="d-grid">
                                        <a class="btn btn-sm btn-link font-size-14 text-center"
                                            href="{{ route('user.messages') }}">
                                            <i class="mdi mdi-arrow-right-circle me-1"></i> View All Messages
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                @endif
            @endauth

            <style>
                .bg-purple {
                    background-color: #6f42c1 !important;
                }

                .bg-orange {
                    background-color: #fd7e14 !important;
                }

                .bg-cyan {
                    background-color: #20c997 !important;
                }

                .bg-teal {
                    background-color: #198754 !important;
                }

                .notification-item {
                    display: block;
                    padding: 0.75rem 1rem;
                    border-bottom: 1px solid #f0f0f0;
                    transition: all 0.3s ease;
                }

                .notification-item:hover {
                    background-color: #f8f9fa;
                    text-decoration: none;
                }

                .notification-item:last-child {
                    border-bottom: none;
                }
            </style>

            <script>
                function markNotificationAsRead(notificationId) {
                    fetch(`/admin/notifications/${notificationId}/read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    });
                }

                function markAllNotificationsAsRead() {
                    fetch('/admin/notifications/mark-all-read', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                // Reload the page to update notification counts
                                window.location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }

                function markUserNotificationAsRead(notificationId) {
                    fetch(`/admin/notifications/${notificationId}/read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    });
                }

                function markUserNotificationsAsRead() {
                    fetch('/admin/notifications/mark-all-read', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                // Reload the page to update notification counts
                                window.location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            </script>

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
                        <a class="dropdown-item" href="{{ route('users.index') }}">
                            <i class="ri-user-add-line align-middle me-1"></i> User Registrations
                            @php
                                $userNotificationsCount = Auth::user()->unreadNotifications()->count();
                            @endphp
                            @if ($userNotificationsCount > 0)
                                <span
                                    class="badge badge-soft-success badge-sm ms-1">{{ $userNotificationsCount }}</span>
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
