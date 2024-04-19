<x-app-layout>
    <x-slot name="header">

    </x-slot>




    <div class="main">

        <div class="main_osnova">
            <form method="POST" action="{{ route('createvideo') }}" enctype="multipart/form-data">
                @csrf
                <div class="main_newnovost">

                    <div>
                        <x-input-label class="txt_2" for="title" :value="__('Название видео')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                            :value="old('title')" required autofocus autocomplete="title" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>


                    <div>



                        <x-input-label class="txt_2" for="description" :value="__('Описание видео')" />


                        <textarea class="main_videotextarea" id="description" type="text" name="description" :value="old('description')"
                            required autofocus autocomplete="description"></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <input type="hidden" name="id" :value="old('category')">
                    <div class="category">
                        <label for="category" class="txt_2">Выберите категорию</label>
                        <select class="custom-select" name="category" id="category">
                            <option value=" "> </option>
                            <option value="Спорт">Спорт</option>
                            <option value="Игры">Игры</option>
                            <option value="Экономика">Экономика</option>
                            <option value="Транспорт">Транспорт</option>
                        </select>
                    </div>

                    <div>
                        <label for="thumbnail" class="txt_2">{{ __('Загрузите превью видео') }}</label>
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*" required />
                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                    </div>
                    
                    <div>
                        <label for="video" class="txt_2">{{ __('Загрузите видео (MP4)') }}</label>
                        <input type="file" id="video" name="video" accept="video/mp4" required />
                        <x-input-error :messages="$errors->get('video')" class="mt-2" />
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
