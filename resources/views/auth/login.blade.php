@section('title', __('Log in'))

<x-auth-layout>

    <h4 class="text-muted text-center font-size-18"><b>Sign In</b></h4>

    <div class="p-3">
        <form class="form-horizontal mt-3" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group mb-3 row">
                <div class="col-12">
                    <input class="form-control" name="email" type="text" required="" placeholder="Email">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>

            <div class="form-group mb-3 row">
                <div class="col-12">
                    <input class="form-control" name="password" type="password" required="" placeholder="Password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>

            <div class="form-group mb-3 row">
                <div class="col-12">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" id="customCheck1">
                        <label class="form-label ms-1" for="customCheck1">Remember me</label>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3 text-center row mt-3 pt-1">
                <div class="col-12">
                    <button class="btn btn-info w-100 waves-effect waves-light" type="submit">Log
                        In</button>
                </div>
            </div>

            <div class="form-group mb-0 row mt-2">
                @if (Route::has('password.request'))
                    <div class="col-sm-7 mt-3">
                        <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock"></i> Forgot
                            your password?</a>
                    </div>
                @endif
                <div class="col-sm-5 mt-3">
                    <a href="{{ route('register') }}" class="text-muted"><i class="mdi mdi-account-circle"></i> Create
                        an account</a>
                </div>
            </div>
        </form>
    </div>

</x-auth-layout>
