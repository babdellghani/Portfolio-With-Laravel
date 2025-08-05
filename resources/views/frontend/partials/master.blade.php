<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title') - {{ config('app.name', 'Ab. Dev.') }}</title>
    <meta name="description" content="Ab. Dev.">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon"
        href="{{ $websiteInfo && $websiteInfo->favicon ? ($websiteInfo->favicon && str_starts_with($websiteInfo->favicon, 'defaults_images/') ? asset($websiteInfo->favicon) : asset('storage/' . $websiteInfo->favicon)) : asset('defaults_images/favicon.ico') }}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}">
</head>

<body>

    <!-- preloader-start -->
    <div id="preloader">
        <div class="rasalina-spin-box"></div>
    </div>
    <!-- preloader-end -->

    <!-- Scroll-top -->
    <button class="scroll-top scroll-to-target" data-target="html">
        <i class="fas fa-angle-up"></i>
    </button>
    <!-- Scroll-top-end-->

    <!-- header-area -->
    @include('frontend.partials.header')
    <!-- header-area-end -->

    <!-- main-area -->
    <main>
        @yield('content')

        <!-- contact-area -->
        <section class="homeContact homeContact__style__two">
            <div class="container">
                <div class="homeContact__wrap">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="section__title">
                                <span class="sub-title">07 - Say hello</span>
                                <h2 class="title">Any questions? Feel free <br> to contact</h2>
                            </div>
                            <div class="homeContact__content">
                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                    suffered alteration in some form</p>
                                <h2 class="mail"><a
                                        href="mailto:{{ $websiteInfo && $websiteInfo->email ? $websiteInfo->email : 'Info@webmail.com' }}">{{ $websiteInfo && $websiteInfo->email ? $websiteInfo->email : 'Info@webmail.com' }}</a>
                                </h2>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="homeContact__form">
                                <form action="{{ route('contact.store') }}" method="POST" id="masterContactForm">
                                    @csrf
                                    <input type="text" name="name" placeholder="Enter name*"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror

                                    <input type="email" name="email" placeholder="Enter mail*"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror

                                    <input type="tel" name="phone" placeholder="Enter number*"
                                        value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror

                                    <textarea name="message" placeholder="Enter Message*" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror

                                    <button type="submit" id="masterSubmitBtn">
                                        <span class="btn-text">Send Message</span>
                                        <span class="btn-loading" style="display: none;">
                                            <i class="fas fa-spinner fa-spin"></i> Sending...
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact-area-end -->
    </main>
    <!-- main-area-end -->



    <!-- Footer-area -->
    @include('frontend.partials.footer')
    <!-- Footer-area-end -->




    <!-- JS here -->
    <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/element-in-view.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/ajax-form.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>

    <!-- Contact Form Handling & Success/Error Messages -->
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('{{ session('success') }}', 'success');
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('{{ session('error') }}', 'error');
            });
        </script>
    @endif

    @if (session('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('{{ session('message') }}', '{{ session('alert-type', 'info') }}');
            });
        </script>
    @endif

    <script>
        // Form submission handlers with loading states
        document.addEventListener('DOMContentLoaded', function() {
            // Master contact form
            const masterForm = document.getElementById('masterContactForm');
            if (masterForm) {
                masterForm.addEventListener('submit', function() {
                    const btn = document.getElementById('masterSubmitBtn');
                    btn.querySelector('.btn-text').style.display = 'none';
                    btn.querySelector('.btn-loading').style.display = 'inline';
                    btn.disabled = true;
                });
            }

            // Portfolio contact form
            const portfolioForm = document.getElementById('portfolioContactForm');
            if (portfolioForm) {
                portfolioForm.addEventListener('submit', function() {
                    const btn = document.getElementById('portfolioSubmitBtn');
                    btn.querySelector('.btn-text').style.display = 'none';
                    btn.querySelector('.btn-loading').style.display = 'inline';
                    btn.disabled = true;
                });
            }

            // Service contact form
            const serviceForm = document.getElementById('serviceContactForm');
            if (serviceForm) {
                serviceForm.addEventListener('submit', function() {
                    const btn = document.getElementById('serviceSubmitBtn');
                    btn.querySelector('.btn-text').style.display = 'none';
                    btn.querySelector('.btn-loading').style.display = 'inline';
                    btn.disabled = true;
                });
            }

            // Blog details contact form
            const blogDetailsForm = document.getElementById('blogDetailsContactForm');
            if (blogDetailsForm) {
                blogDetailsForm.addEventListener('submit', function() {
                    const btn = document.getElementById('blogDetailsSubmitBtn');
                    btn.querySelector('.btn-text').style.display = 'none';
                    btn.querySelector('.btn-loading').style.display = 'inline';
                    btn.disabled = true;
                });
            }

            // Blog contact form
            const blogForm = document.getElementById('blogContactForm');
            if (blogForm) {
                blogForm.addEventListener('submit', function() {
                    const btn = document.getElementById('blogSubmitBtn');
                    btn.querySelector('.btn-text').style.display = 'none';
                    btn.querySelector('.btn-loading').style.display = 'inline';
                    btn.disabled = true;
                });
            }

            // Contact page forms
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', function() {
                    const btn = document.getElementById('submitBtn');
                    if (btn) {
                        btn.querySelector('.btn-text').style.display = 'none';
                        btn.querySelector('.btn-loading').style.display = 'inline';
                        btn.disabled = true;
                    }
                });
            }

            const homeContactForm = document.getElementById('homeContactForm');
            if (homeContactForm) {
                homeContactForm.addEventListener('submit', function() {
                    const btn = document.getElementById('homeSubmitBtn');
                    btn.querySelector('.btn-text').style.display = 'none';
                    btn.querySelector('.btn-loading').style.display = 'inline';
                    btn.disabled = true;
                });
            }
        });

        // Notification function
        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className =
                `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} alert-dismissible position-fixed`;
            notification.style.cssText =
                'top: 20px; right: 20px; z-index: 9999; max-width: 400px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);';
            notification.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="me-2">
                        ${type === 'success' ? '<i class="fas fa-check-circle"></i>' : 
                          type === 'error' ? '<i class="fas fa-exclamation-circle"></i>' : 
                          '<i class="fas fa-info-circle"></i>'}
                    </div>
                    <div class="flex-grow-1">${message}</div>
                    <button type="button" class="btn-close ms-2" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            `;

            document.body.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }
    </script>
</body>

</html>
