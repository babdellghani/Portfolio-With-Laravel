@section('title', __('Verify Email'))

<x-guest-layout>
    <h4 class="text-muted text-center font-size-18"><b>Verify Email</b></h4>

    <div class="p-3">
        <form class="form-horizontal mt-3" method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div class="alert alert-info alert-dismissible fade show" role="alert">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the
                link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="form-group pb-2 text-center row mt-3">
                <div class="col-12">
                    <button class="btn btn-info w-100 waves-effect waves-light" type="submit">
                        {{ __('Resend Verification Email') }}
                    </button>
                </div>
            </div>
        </form>

        <form class="form-horizontal mt-3" method="POST" action="{{ route('logout') }}">
            @csrf

            <div class="form-group pb-2 text-center row mt-3">
                <div class="col-12">
                    <button class="btn btn-info w-100 waves-effect waves-light" type="submit">
                        {{ __('Log Out') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>
