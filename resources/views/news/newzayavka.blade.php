<x-app-layout>
    <x-slot name="header">

    </x-slot>




    <div class="main">

        <div class="main_osnova">
            <form method="POST" action="{{ route('test') }}">
                @csrf
                <div class="main_news">

                    <div>
                        <x-input-label class="txt_2" for="zagolovok" :value="__('Заголовок статьи')" />
                        <x-text-input id="zagolovok" class="block mt-1 w-full" type="text" name="zagolovok"
                            :value="old('zagolovok')" required autofocus autocomplete="zagolovok" />
                        <x-input-error :messages="$errors->get('zagolovok')" class="mt-2" />
                    </div>


                    <div>



                        <x-input-label class="txt_2" for="description" :value="__('Содержимое статьи')" />


                        <textarea class="main_newtextarea" id="description" type="text" name="description" :value="old('description')"
                            required autofocus autocomplete="description"></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <input type="hidden" name="id" :value="old('category')">
                    <div class="category">
                        <label for="category" class="txt_2">Выберите категорию</label>
                        <select class="custom-select-news" name="category" id="category">
                            <option value=" "> </option>
                            <option value="Спорт">Спорт</option>
                            <option value="Игры">Игры</option>
                            <option value="Экономика">Экономика</option>
                            <option value="Транспорт">Транспорт</option>
                        </select>
                    </div>
                    <div class="margin_20_20"></div>
                    <x-primary-button class="btn_1">
                        {{ __('Отправить') }}
                    </x-primary-button>


                </div>
            </form>

        </div>

    </div>



</x-app-layout>
