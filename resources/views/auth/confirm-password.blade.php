@section('title', __('Confirm Password'))

<x-guest-layout>
    <h4 class="text-muted text-center font-size-18"><b>Confirm Password</b></h4>

    <div class="p-3">
        <form class="form-horizontal mt-3" method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                This is a secure area of the application. Please confirm your password before continuing.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="form-group mb-3">
                <div class="col-xs-12">
                    <input class="form-control" name="password" type="password" required="" placeholder="Password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>

            <div class="form-group pb-2 text-center row mt-3">
                <div class="col-12">
                    <button class="btn btn-info w-100 waves-effect waves-light" type="submit">
                        {{ __('Confirm Password') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>
