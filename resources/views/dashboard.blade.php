<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        </h2>
    </x-slot>

    <div class="friendfeed_field">
        <div style="justify-content: center; margin: 0 auto; height: 100%;" class="friendfeed_field_frame">

            <div style="text-align: center; max-width: 800px; margin: 0 auto; padding:1%;" class="friendfeed_content">





                @auth


                    <p class="txt_1">Приветствуем вас, {{ auth()->user()->name }}!</p>


                    @if (auth()->user()->isBlocked())
                        <p style="margin:20px 0;" class="txt_2">Ваша учётная запись заблокирована по причине       '{{ auth()->user()->bans->first()->reason->name }}'</p>      
                        
                        <p>Дата блокировки {{ auth()->user()->bans->first()->created_at }}</p>

                        <form class="adminpanel" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="long_button">Выйти</button>
                        </form>


                    @else
                        <p style="margin:20px 0;" class="txt_2">Ваша авторизация прошла успешно, и теперь вы готовы к
                            погружению в увлекательные материалы. Переходите по разделам слева и наслаждайтесь свежими и
                            захватывающими материалами, которые мы специально подготовили для вас. Приятного
                            времяпровождения!</p>

                        <a href="{{ route('main.all.video.user') }}" class="long_button">Перейти к видеоматериалам</a>
                        @endif


                    @else
                        <p style="margin:20px 0;" class="txt_2">Добро пожаловать на наш сайт, где самые яркие и актуальные
                            материалы собраны в одном месте. У нас вы найдете всё: от последних технологических новинок до
                            самых актуальных спортивных событий. Присоединяйтесь к нам и будьте в курсе самых интересных
                            событий!</p>
                        <a href="{{ '/login' }}" class="long_button">Авторизоваться</a>
       
                @endauth



            </div>

        </div>
    </div>

</x-app-layout>
