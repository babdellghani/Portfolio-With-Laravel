<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>@yield('title') | {{ config('app.name', 'Ab. Dev.') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon"
        href="{{ $websiteInfo && $websiteInfo->favicon ? ($websiteInfo->favicon && str_starts_with($websiteInfo->favicon, 'defaults_images/') ? asset($websiteInfo->favicon) : asset('storage/' . $websiteInfo->favicon)) : asset('defaults_images/favicon.ico') }}">

    <!-- jquery.vectormap css -->
    <link href="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Toastr Css -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
    <!-- App Css-->
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <!-- Custom Css -->
    @stack('style')
    @yield('style')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body data-topbar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- ========== Header ========== -->
        @include('admin.partials.header')
        <!-- End Header -->

        <!-- ========== Left Sidebar Start ========== -->
        @include('admin.partials.left_sidebar')
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <!-- Email Verification Notice -->
                @auth
                    @if (!auth()->user()->hasVerifiedEmail())
                        <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
                            <i class="ri-mail-line me-2"></i>
                            <strong>Email Verification Required!</strong>
                            Please verify your email address to access all features.
                            <a href="{{ route('verification.notice') }}" class="btn btn-sm btn-outline-warning ms-2">
                                Verify Email
                            </a>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                @endauth

                @yield('content')
            </div>
            <!-- End Page-content -->

            <!-- Footer -->
            @include('admin.partials.footer')

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- ========== Right Sidebar ========== -->
    {{-- @include('admin.partials.right_sidebar') --}}
    <!-- END Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>


    <!-- apexcharts -->
    <script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- jquery.vectormap map -->
    <script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}">
    </script>
    <script
        src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
        </script>

    <!-- Required datatable js -->
    <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>

    @if(request()->routeIs('dashboard'))
        <script src="{{ asset('backend/assets/js/pages/dashboard.init.js') }}"></script>
    @endif

    <!-- App js -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <!-- Toastr Js -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error(" {{ $error }} ");
            @endforeach
        @endif

        // Show status messages (like verification status)
        @if (session('status'))
            toastr.info("{{ session('status') }}");
        @endif

        // Show general error messages
        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        // Show general success messages
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    </script>

    @stack('scripts')
    @yield('scripts')

</body>

</html>