@section('title', __('Verify Email'))

<x-auth-layout>
    <h4 class="text-muted text-center font-size-18"><b>Verify Your Email</b></h4>

    <div class="p-3">
        <div class="text-center mb-4">
            <div class="avatar-md mx-auto">
                <div class="avatar-title rounded-circle bg-light">
                    <i class="ri-mail-check-line h1 mb-0 text-primary"></i>
                </div>
            </div>
        </div>

        <form class="form-horizontal mt-3" method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Email Verification!</strong><br>
                Thanks for signing up! We've sent a verification link to <strong>{{ auth()->user()->email }}</strong>.
                Please check your email and click the verification link to activate your account.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ri-check-line me-2"></i>
                    A new verification link has been sent to your email address!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="form-group pb-2 text-center row mt-3">
                <div class="col-12">
                    <a href="{{ route('dashboard') }}" class="btn btn-success w-100 waves-effect waves-light">
                        <i class="ri-dashboard-line me-1"></i> Go to Dashboard
                    </a>
                </div>
            </div>

            <div class="form-group pb-2 text-center row mt-3">
                <div class="col-12">
                    <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
                        <i class="ri-mail-send-line me-1"></i> Resend Verification Email
                    </button>
                </div>
            </div>
        </form>

        <div class="mt-3 text-center">
            <p class="text-muted">Didn't receive the email? Check your spam folder</p>
        </div>

        <form class="form-horizontal mt-3" method="POST" action="{{ route('logout') }}">
            @csrf

            <div class="form-group pb-2 text-center row mt-3">
                <div class="col-12">
                    <button class="btn btn-light w-100 waves-effect waves-light" type="submit">
                        <i class="ri-logout-box-line me-1"></i> Log Out
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-auth-layout>
