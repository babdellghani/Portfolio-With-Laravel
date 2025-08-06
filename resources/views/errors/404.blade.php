<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Page Not Found | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Page not found" name="description" />
    <meta content="Portfolio Admin" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">
    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Page Not Found!</h5>
                                        <p>The page you're looking for doesn't exist.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="p-2">
                                <div class="text-center">
                                    <div class="avatar-md mx-auto">
                                        <div class="avatar-title rounded-circle bg-light">
                                            <i class="ri-file-search-line h1 mb-0 text-primary"></i>
                                        </div>
                                    </div>

                                    <div class="p-2 mt-4">
                                        <h4>Page Not Found!</h4>
                                        <p class="mb-0">
                                            The page you're looking for doesn't exist or has been moved.
                                        </p>
                                        <div class="mt-4">
                                            @auth
                                                <a class="btn btn-primary w-100 waves-effect waves-light"
                                                    href="{{ route('dashboard') }}">
                                                    <i class="ri-user-settings-line"></i> Go to Dashboard
                                                </a>
                                            @else
                                                <a class="btn btn-primary w-100 waves-effect waves-light"
                                                    href="{{ route('login') }}">
                                                    <i class="ri-login-box-line"></i> Login
                                                </a>
                                            @endauth
                                            <a class="btn btn-light w-100 waves-effect waves-light mt-2"
                                                href="{{ route('home') }}">
                                                <i class="ri-home-line"></i> Go to Home
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <div>
                            <p>©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> {{ config('app.name') }}. Crafted with <i
                                    class="mdi mdi-heart text-danger"></i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
</body>

</html>
