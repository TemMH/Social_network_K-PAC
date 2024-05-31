<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="reports_field_setting">

        <div class="statements_settings">

            <div class="statements_settings_left">

                <button onclick="location.href='{{ route('reports') }}';"
                    class="long_button {{ Route::is('reports') ? 'selected' : '' }}">Жалобы</button>
                <button onclick="location.href='{{ route('admin.navigation.statements') }}';"
                    class="long_button {{ Route::is('admin.navigation.statements') ? 'selected' : '' }}">Фотоматериалы</button>
                <button onclick="location.href='{{ route('admin.navigation.videos') }}';"
                    class="long_button {{ Route::is('admin.navigation.videos') ? 'selected' : '' }}">Видеоматериалы</button>
                <button onclick="location.href='{{ route('admin.navigation.users') }}';"
                    class="long_button {{ Route::is('admin.navigation.users') ? 'selected' : '' }}">Пользователи</button>
                <button onclick="location.href='{{ route('admin.navigation.create') }}';"
                    class="long_button {{ Route::is('admin.navigation.create') ? 'selected' : '' }}">Добавить</button>

            </div>
        </div>






    </div>

    <div class="reports_field_frame_test">




        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="static_form">
                    <div class="max-w-xl">
                        @include('admin.partials.create-category-form')
                    </div>
                </div>


                <div class="static_form">
                    <div class="max-w-xl">
                        @include('admin.partials.create-reason-form')
                    </div>
                </div>

            </div>
        </div>


    </div>

</x-app-layout>