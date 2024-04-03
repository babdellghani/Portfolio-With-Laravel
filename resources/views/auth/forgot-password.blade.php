@section('title', __('Forgot Your Password?'))

<x-auth-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h4 class="text-muted text-center font-size-18"><b>Forgot Password?</b></h4>

    <div class="p-3">
        <form class="form-horizontal mt-3" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                Forgot your password? No problem. Just let us know your email address and we will email
                you a password reset link that will allow you to choose a new one.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="form-group mb-3">
                <div class="col-xs-12">
                    <input class="form-control" name="email" type="email" required="" placeholder="Email">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>

            <div class="form-group pb-2 text-center row mt-3">
                <div class="col-12">
                    <button class="btn btn-info w-100 waves-effect waves-light" type="submit">Send
                        Email Password Reset Link</button>
                </div>
            </div>
        </form>
    </div>

</x-auth-layout>
