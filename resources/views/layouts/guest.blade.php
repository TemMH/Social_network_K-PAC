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

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">

        </h2>
    </x-slot>









    <body>

        <div class="form-reg">

            <div class="form-reg-lev">


                <div class="form_reg_lev_text">
                    <p class="txt_1">Добро пожаловать на наш сайт, где самые яркие и актуальные новости собраны в одном месте. У нас
                        вы
                        найдете всё: от последних технологических новинок до самых актуальных спортивных событий.
                        Присоединяйтесь к нам и будьте в курсе самых интересных событий!</p>
                </div>


            </div>

            <div class="form-reg-prav">
                {{ $slot }}
            </div>

        </div>
    </body>
</x-app-layout>

</html>
