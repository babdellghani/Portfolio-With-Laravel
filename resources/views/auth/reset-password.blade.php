@section('title', 'Reset Password')

<x-auth-layout>

    <h4 class="text-muted text-center font-size-18"><b>Reset Password</b></h4>

    <div class="p-3">
        <form class="form-horizontal mt-3" method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">


            <div class="alert alert-info alert-dismissible fade show" role="alert">
                Reset your password.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="form-group mb-3">
                <div class="col-xs-12">
                    <input class="form-control" name="email" type="email" required="" placeholder="Email">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="col-xs-12">
                    <input class="form-control" name="password" type="password" required="" placeholder="New Password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="col-xs-12">
                    <input class="form-control" name="password_confirmation" type="password" required="" placeholder="Confirm New Password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <div class="form-group pb-2 text-center row mt-3">
                <div class="col-12">
                    <button class="btn btn-info w-100 waves-effect waves-light" type="submit">
                        Reset Password
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-auth-layout>
