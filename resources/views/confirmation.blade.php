<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        </h2>
    </x-slot>

    <div class="main">

        @if (auth()->user()->permission === 'new')
            <form method="POST" action="{{ route('confirm.permission') }}">
                @csrf
                <button type="submit" class="main_new_novo">Подтвердить</button>
            </form>



            <div class="main_osnova">
                <div class="main_novost">
                    <div class="main_novost_top">
                        <div class="main_novost_title">
                        </div>
                    </div>
                    <div class="main_novost_middle">

                        @auth
                            <p>Подтвердите, для возможности предлагать ваши новости</p>
                        @else
                            <p>Вы не авторизированы</p>
                        @endauth
                    </div>
                    <div class="main_novost_down">
                    </div>
                </div>
            </div>
        @endif
        @if (auth()->user()->permission === 'disabled')
            <div class="main_osnova">
                <div class="main_novost">
                    <div class="main_novost_top">
                        <div class="main_novost_title">
                        </div>
                    </div>
                    <div class="main_novost_middle">

                        @auth
                            <p>Вас лишили прав выкладывать новости администраторами.</p>
                        @else
                            <p>Вы не авторизированы</p>
                        @endauth
                    </div>
                    <div class="main_novost_down">
                    </div>
                </div>
            </div>
        @endif
        @if (auth()->user()->permission === 'enabled')
        <div class="main_osnova">
            <div class="main_novost">
                <div class="main_novost_top">
                    <div class="main_novost_title">
                    </div>
                </div>
                <div class="main_novost_middle">

                    @auth
                        <p>Вы можете выкладывать новости</p>
                    @else
                        <p>Вы не авторизированы</p>
                    @endauth
                </div>
                <div class="main_novost_down">
                </div>
            </div>
        </div>
    @endif
    </div>
</x-app-layout>
