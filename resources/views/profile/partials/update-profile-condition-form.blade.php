<section>
    <header>
        <h2 class="txt_2">
            {{ __('Краткая информация ') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Расскажите кратко о себе.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="condition" :value="__('Состояние')" />
            <x-text-input id="condition" name="condition" type="text" class="mt-1 block w-full" :value="old('condition', $user->condition)" autofocus autocomplete="condition" />
            <x-input-error class="mt-2" :messages="$errors->get('condition')" />
        </div>



        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Сохранить') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Сохранено.') }}</p>
            @endif
        </div>
    </form>
</section>
