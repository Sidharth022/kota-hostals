<section class="d-flex flex-column gap-3">
    <header class="mb-3">
        <h5 class="font-outfit fw-extrabold text-danger mb-1">
            {{ __('Delete Account') }}
        </h5>
        <p class="text-secondary small mb-0">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <div>
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >
            <i class="fa-solid fa-trash-can"></i>
            <span>{{ __('Delete Account') }}</span>
        </x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-4 p-md-5 d-flex flex-column gap-3 text-start">
            @csrf
            @method('delete')

            <div>
                <h5 class="font-outfit fw-extrabold text-dark mb-2">
                    {{ __('Are you sure you want to delete your account?') }}
                </h5>
                <p class="text-secondary small mb-0">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>
            </div>

            <div>
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1"
                    placeholder="{{ __('Enter your password to confirm') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="d-flex align-items-center gap-2 justify-content-end mt-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button>
                    <i class="fa-solid fa-trash-can"></i>
                    <span>{{ __('Delete Account') }}</span>
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
