<x-app-layout>
    <x-slot name="header">

    </x-slot>





    <div class="reports_field_setting">

        <div class="statements_settings">

            <div class="statements_settings_left">

                <button onclick="location.href='{{ route('reports') }}';"
                    class="statements_type_btn {{ Route::is('reports') ? 'selected' : '' }}">Жалобы</button>

                    @if (auth()->user()->role == 'Admin')

                    <button onclick="location.href='{{ route('admin.navigation.statements') }}';"
                    class="statements_type_btn {{ Route::is('admin.navigation.statements', 'admin.navigation.statements.unblocked', 'admin.navigation.statements.blocked') ? 'selected' : '' }}">Фотоматериалы</button>
                <button onclick="location.href='{{ route('admin.navigation.videos') }}';"
                    class="statements_type_btn {{ Route::is('admin.navigation.videos', 'admin.navigation.videos.unblocked', 'admin.navigation.videos.blocked') ? 'selected' : '' }}">Видеоматериалы</button>
                <button onclick="location.href='{{ route('admin.navigation.users') }}';"
                    class="statements_type_btn {{ Route::is('admin.navigation.users', 'admin.navigation.users.unblocked', 'admin.navigation.users.blocked') ? 'selected' : '' }}">Пользователи</button>
                <button onclick="location.href='{{ route('admin.navigation.create') }}';"
                    class="statements_type_btn {{ Route::is('admin.navigation.create') ? 'selected' : '' }}">Добавить</button>

                    @endif

            </div>


            <div class="reports_settings_middle">

                <input type="text" id="searchInputdAdmin" name="search" class="message_history_input_container"
                    placeholder="Введите название...">

            </div>





            <div class="statements_settings_right">

                {{-- USERS --}}
                @if (Route::is('admin.navigation.users', 'admin.navigation.users.unblocked', 'admin.navigation.users.blocked'))
                    <button onclick="location.href='{{ route('admin.navigation.users') }}';"
                        class="statements_type_btn {{ Route::is('admin.navigation.users') ? 'selected' : '' }}">Все</button>

                    <button onclick="location.href='{{ route('admin.navigation.users.unblocked') }}';"
                        class="statements_type_btn {{ Route::is('admin.navigation.users.unblocked') ? 'selected' : '' }}">Разблокированные</button>

                    <button onclick="location.href='{{ route('admin.navigation.users.blocked') }}';"
                        class="statements_type_btn {{ Route::is('admin.navigation.users.blocked') ? 'selected' : '' }}">Заблокированные</button>

                    <form id="categoryForm" method="GET"
                        action="{{ url()->current() }}">
                        <div class="dropdown">
                            <div class="dropbtn">Роли</div>
                            <div class="dropdown-content">

                                <button onclick="location.href='{{ route('admin.navigation.users') }}';"
                                    class="statements_type_btn">Все</button>
                                <button name="role" value="Manager" class="statements_type_btn">Менеджеры</button>
                                <button name="role" value="User" class="statements_type_btn">Пользователи</button>

                            </div>
                        </div>
                    </form>
                @endif

                {{-- STATEMENTS --}}

                @if (Route::is('admin.navigation.statements', 'admin.navigation.statements.unblocked', 'admin.navigation.statements.blocked'))
                    <button onclick="location.href='{{ route('admin.navigation.statements') }}';"
                        class="statements_type_btn {{ Route::is('admin.navigation.statements') ? 'selected' : '' }}">Все</button>

                    <button onclick="location.href='{{ route('admin.navigation.statements.unblocked') }}';"
                        class="statements_type_btn {{ Route::is('admin.navigation.statements.unblocked') ? 'selected' : '' }}">Разблокированные</button>

                    <button onclick="location.href='{{ route('admin.navigation.statements.blocked') }}';"
                        class="statements_type_btn {{ Route::is('admin.navigation.statements.blocked') ? 'selected' : '' }}">Заблокированные</button>
                @endif


                {{-- VIDEOS --}}

                @if (Route::is('admin.navigation.videos', 'admin.navigation.videos.unblocked', 'admin.navigation.videos.blocked'))
                    <button onclick="location.href='{{ route('admin.navigation.videos') }}';"
                        class="statements_type_btn {{ Route::is('admin.navigation.videos') ? 'selected' : '' }}">Все</button>

                    <button onclick="location.href='{{ route('admin.navigation.videos.unblocked') }}';"
                        class="statements_type_btn {{ Route::is('admin.navigation.videos.unblocked') ? 'selected' : '' }}">Разблокированные</button>

                    <button onclick="location.href='{{ route('admin.navigation.videos.blocked') }}';"
                        class="statements_type_btn {{ Route::is('admin.navigation.videos.blocked') ? 'selected' : '' }}">Заблокированные</button>
                @endif

            </div>







        </div>






    </div>


<div class="friendfeed_field">
    <div class="reports_field_frame_test">



        {{-- Видеоматериалы --}}

        @if (Route::is('admin.navigation.videos'))
            @include('admin.components.videos')

        @endif

        @if (Route::is('admin.navigation.videos.blocked'))
            @include('admin.components.videos')

        @endif

        @if (Route::is('admin.navigation.videos.unblocked'))
            @include('admin.components.videos')

        @endif

        {{-- Фотоматериалы --}}

        @if (Route::is('admin.navigation.statements'))
            @include('admin.components.statements')

        @endif

        @if (Route::is('admin.navigation.statements.blocked'))
            @include('admin.components.statements')

        @endif

        @if (Route::is('admin.navigation.statements.unblocked'))
            @include('admin.components.statements')

        @endif



        {{-- Пользователи --}}

        @if (Route::is('admin.navigation.users'))
            @include('admin.components.users')


        @endif


        @if (Route::is('admin.navigation.users.blocked'))
            @include('admin.components.users')


        @endif

        @if (Route::is('admin.navigation.users.unblocked'))
            @include('admin.components.users')

        @endif


    </div>

</div>




</x-app-layout>
