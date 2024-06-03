<section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <header>
        <h2 class="fs-4 fw-medium text-dark">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-muted small">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="mb-3">
            <x-input-label for="name" :value="__('Name')" class="form-label" />
            <x-text-input id="name" name="name" type="text" class="form-control" :value="old('name', $user->name)" required
                autofocus autocomplete="name" />
            <x-input-error class="text-danger small mt-1" :messages="$errors->get('name')" />
        </div>

        <div class="mb-3">
            <x-input-label for="username" :value="__('Username')" class="form-label" />
            <x-text-input id="username" name="username" type="text" class="form-control" :value="old('username', $user->username)" required
                autofocus autocomplete="username" />
            <x-input-error class="text-danger small mt-1" :messages="$errors->get('username')" />
        </div>

        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" class="form-label" />
            <x-text-input id="email" name="email" type="email" class="form-control" :value="old('email', $user->email)" required
                autocomplete="username" />
            <x-input-error class="text-danger small mt-1" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="small text-muted mt-2">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="btn btn-link p-0 small text-decoration-none text-muted hover-text-primary">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 fw-medium small text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="mb-3">
            <x-input-label for="avatar" :value="__('Avatar')" class="form-label" />

            <div class="d-flex align-items-center gap-3">
                <div>
                    <div class="mt-4 mt-md-0">
                        @if ($user->avatar)
                            <img id="showImage" class="rounded-circle avatar-md" alt="200x200"
                                src="{{ '/storage/' . $user->avatar }}" data-holder-rendered="true">
                        @else
                            <img id="showImage" class="rounded-circle avatar-md" alt="200x200"
                                src="{{ asset('backend/assets/images/users/avatar-1.jpg') }}"
                                data-holder-rendered="true">
                        @endif
                    </div>
                </div>
                <div class="input-group">
                    <input type="file" id="image" name="avatar" class="form-control" id="customFile">
                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('avatar')" />
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <x-primary-button class="btn btn-primary">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="small text-muted">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function() {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
</section>
