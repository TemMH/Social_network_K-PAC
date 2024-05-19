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

                    <p style="margin:20px 0;" class="txt_2">Ваша авторизация прошла успешно, и теперь вы готовы к погружению в увлекательные материалы. Переходите по разделам слева и наслаждайтесь свежими и захватывающими материалами, которые мы специально подготовили для вас. Приятного времяпровождения!</p>
              
                   <button class="statements_type_btn" >Перейти к видеоматериалам</button>
                    @else
                        <p style="margin:20px 0;"  class="txt_2">Добро пожаловать на наш сайт, где самые яркие и актуальные материалы собраны в одном месте. У нас вы найдете всё: от последних технологических новинок до самых актуальных спортивных событий. Присоединяйтесь к нам и будьте в курсе самых интересных событий!</p>
                        <a href="{{ ('/login') }}" class="statements_type_btn" >Авторизоваться</a>
                        @endauth
              
         
       
    </div>

        </div></div>

</x-app-layout>
