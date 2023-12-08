<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        </h2>
    </x-slot>

    <div class="main">
        <a href="{{ route('allzayavkauser') }}">
            <div class="main_new_novo">
                <p class="txt_2">Перейти к новостям</p>
            </div>
        </a>

        <div class="main_osnova">
            <div class="main_novost">
                <div class="main_novost_top">
                    <div class="main_novost_zagolovok">
                    </div>
                </div>
                <div class="main_novost_middle">
                    @auth
                        <p class="txt_2">Добро пожаловать! Вы авторизированы и готовы к погружению в мир увлекательных новостей. Переходите по ссылкам выше и наслаждайтесь свежими и захватывающими материалами, которые мы подготовили для вас.</p>
                    @else
                        <p class="txt_2">Добро пожаловать на наш сайт, где самые яркие и актуальные новости собраны в одном месте. У нас вы найдете всё: от последних технологических новинок до самых актуальных спортивных событий. Присоединяйтесь к нам и будьте в курсе самых интересных событий!</p>
                    @endauth
                </div>
                <div class="main_novost_down">
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
