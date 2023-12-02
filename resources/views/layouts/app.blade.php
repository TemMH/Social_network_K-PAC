<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="backgroundall">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))


            <header class="header-down">

                <div class="px"></div>


                <div class="head-flex">

                    <!-- Logo -->
                    <div class="logotype">
                        <div class="logo-left">



                                <a href="{{ route('allzayavkauser') }}">
                                    <img src="/uploads/logoimg_store_left.png"  alt="Описание фото">
                                </a>





                        </div>
                        
                        <div class="logo">
                            <a href="{{ route('allzayavkauser') }}">
                                <img src="/uploads/menunews.png" class="logo" alt="Описание фото">
                            </a>
                        </div>

                        <div class="logo-right">






                            

                            @if(request()->is('myzayavka'))
                            <!-- Код элемента, который нужно скрыть -->
                        @endif





                                <a href="{{ route('allzayavkauser') }}">
                                    <img src="/uploads/logoimg_videohosting_right.png"  alt="Описание фото">
                                </a>


                        </div>

                    </div>


                    @auth
                        @if (auth()->user()->role == 'Admin')
                            <div class="adminpanel">

                                <a href="{{ route('allzayavka') }}">
                                    <p class="txt_1">Предложка</p>
                                </a>

                            </div>
                        @endif

                        @if (auth()->user()->role == 'Admin')
                            <div class="adminpanel">
                                <a href="{{ route('allUsers') }}">
                                    <p class="txt_1">Все пользователи</p>
                                </a>
                            </div>
                        @endif



                        @if (auth()->user()->role !== 'Admin')
                            <div class="search-container">
                                <input type="text" id="searchInput" class="custom-search-input"
                                    placeholder="Поиск по заголовку новости">
                                <div id="searchResults"></div>
                            </div>
                        @endif




                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                $('#searchInput').on('input', function() {
                                    let searchTerm = $(this).val().trim();

                                    if (searchTerm.length >= 1) {
                                        $.ajax({
                                            type: 'GET',
                                            url: '/zayavka/autocomplete',
                                            data: {
                                                search: searchTerm
                                            },
                                            success: function(response) {
                                                console.log(
                                                    response);
                                                let resultsDiv = $('#searchResults');
                                                resultsDiv.empty();

                                                $.each(response.zayavkas, function(index, zayavka) {
                                                    resultsDiv.append(
                                                        '<a href="/zayavkauser/' + zayavka.id + '">' +
                                                        zayavka.zagolovok +
                                                        '</a>'
                                                    );
                                                });
                                            }

                                        });
                                    } else {
                                        $('#searchResults').empty();
                                    }
                                });
                            });
                        </script>





                        <div class="adminpanel">

                            <a href="{{ route('myzayavka') }}">
                                <p class="txt_1">Мои статьи</p>
                            </a>

                        </div>
                        <div class="adminpanel">

                            <a href="{{ route('allzayavkauser') }}">
                                <p class="txt_1">Все статьи</p>
                            </a>

                        </div>

                    @endauth





                    {{-- <div class="Weather">

                        @php
                            
                            $apiKey = '8523a49e9e99f6888cc6d56ee02f0214';

                            
                            $city = 'Иркутске';

                           
                            $url = 'https://api.openweathermap.org/data/2.5/weather?q=Irkutsk,ru&APPID=8523a49e9e99f6888cc6d56ee02f0214';

                            
                            $response = file_get_contents($url);

                           
                            $weatherData = json_decode($response, true);


                            $temperatureKelvin = $weatherData['main']['temp'];

                            $temperatureCelsius = $temperatureKelvin - 273.15;
                        @endphp

                        <p class="txt_2">{{ $temperatureCelsius }} &#8451; В {{ $city }}</p>
                    </div>

                    <div class="money">
                        <div class="test1">
                            @php
                             
                                $url = 'https://api.exchangerate-api.com/v4/latest/USD';

                              
                                $response = file_get_contents($url);

                         
                                $exchangeRates = json_decode($response, true);

                             
                                $rubRate = $exchangeRates['rates']['RUB'];

                            @endphp


                            <p class="txt_2">$ {{ $rubRate }}</p>

                        </div>
                        <div class="test2">
                            <p class="txt_2">ㅤ|ㅤ</p>
                        </div>
                        <div class="test3">
                            @php
                           
                                $url = 'https://api.exchangerate-api.com/v4/latest/EUR';

                   
                                $response = file_get_contents($url);

                                $exchangeRates = json_decode($response, true);

            
                                $rubRate = $exchangeRates['rates']['RUB'];

                            @endphp


                            <p class="txt_2">€ {{ $rubRate }}</p>
                        </div>

                    </div> --}}

                    <div class="test">

                    </div>

                    @if (Auth::check())
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                        <div>
                                            <p class="txt_2">
                                                {{ Auth::user()->name }}
                                                {{-- test --}}
                                            </p>
                                        </div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profileuser')">
                                        <p class="txt_2">
                                            {{ __('Профиль') }}
                                        </p>
                                    </x-dropdown-link>


                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                            <p class="txt_2">
                                                {{ __('Выйти') }}
                                            </p>
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif
                    @if (Auth::check())
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="open = ! open"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif
                    @if (Auth::check())
                        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
                            <div class="pt-2 pb-3 space-y-1">
                                <x-responsive-nav-link :href="route('allzayavkauser')" :active="request()->routeIs('allzayavkauser')">
                                    {{ __('allzayavkauser') }}
                                </x-responsive-nav-link>
                            </div>

                            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                                <div class="px-4">
                                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">

                                        {{ Auth::user()->name }}



                                    </div>

                                    <div class="font-medium text-sm text-gray-500">

                                        {{ Auth::user()->email }}



                                    </div>


                                </div>

                                <div class="mt-3 space-y-1">
                                    <x-responsive-nav-link :href="route('profile.edit')">
                                        {{ __('Profile') }}
                                    </x-responsive-nav-link>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-responsive-nav-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-responsive-nav-link>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>


                <div class="px"></div>

            </header>
            <div class="triygol">

                <img class="image" src="/uploads/triyglev.png" />
                <img class="image" src="/uploads/triygprav.png" />


            </div>


        @endif


        <main>
            {{ $slot }}
        </main>




    </div>




</body>

</html>
