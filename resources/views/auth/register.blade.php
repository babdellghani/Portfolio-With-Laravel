@section('title', 'Register')
<x-auth-layout>

    <h4 class="text-muted text-center font-size-18">
        <b>Register</b>
    </h4>

    <div class="p-3">
        <form class="form-horizontal mt-3" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group mb-3 row">
                <div class="col-12">
                    <input class="form-control" name="name" type="name" required="" placeholder="Name">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>

            <div class="form-group mb-3 row">
                <div class="col-12">
                    <input class="form-control" name="email" type="email" required="" placeholder="Email">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>

            <div class="form-group mb-3 row">
                <div class="col-12">
                    <input class="form-control" name="username" type="text" required="" placeholder="Username">
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
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
                    <input class="form-control" name="password_confirmation" type="password" required=""
                        placeholder="Password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <div class="form-group text-center row mt-3 pt-1">
                <div class="col-12">
                    <button class="btn btn-info w-100 waves-effect waves-light" type="submit">Register</button>
                </div>
            </div>

            <div class="form-group mt-2 mb-0 row">
                <div class="col-12 mt-3 text-center">
                    <a href="{{ route('login') }}" class="text-muted">Already have account?</a>
                </div>
            </div>
        </form>
        <!-- end form -->
    </div>




</x-auth-layout>
