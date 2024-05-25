<section>
    <header>
        <h2 class="txt_2">
            {{ __('Создание причины ') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Укажите в поле ниже название причины.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('admin.navigation.create.reason') }}" class="mt-6 space-y-6">
        @csrf
        @method('POST')

        <div>
            <x-input-label for="name" :value="__('Название причины')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>



        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Создать') }}</x-primary-button>
        </div>
    </form>
    
</section>
