<section class="mb-4">
    <header>
        <h2 class="fs-4 fw-medium text-dark">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 small text-muted">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button" class="btn btn-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
            @csrf
            @method('delete')

            <h2 class="fs-4 fw-medium text-dark">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 small text-muted">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-3">
                <x-input-label for="password" value="{{ __('Password') }}" class="visually-hidden" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control mt-1 w-75"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="text-danger small mt-1" />
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <button type="button" class="btn btn-secondary" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="btn btn-danger ms-3">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
