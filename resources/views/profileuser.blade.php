<x-app-layout>
    <x-slot name="header">

    </x-slot>



    @foreach ($users as $user)
        <div class="profileuser_field">

            <div class="profileuser_block">

                <div class="profileuser_block_header">

                    <div class="profileuser_block_header_cover"></div>

                    <div class="profileuser_block_header_info">

                        <div class="profileuser_block_header_info_avatar">

                            <div class="profileuser_block_header_info_avatar_frame">

                            </div>

                        </div>

                        <div class="profile_block_header">
                            <div class="profileuser_block_info_info_left">

                                <div class="profileuser_block_header_info_left_name">
                                    <p>USERNAME</p>
                                </div>

                                <div class="profileuser_block_header_info_left_condition">
                                    <p>CONDITION</p>
                                </div>

                            </div>


                            <div class="profileuser_block_header_info_right">

                                <div class="profileuser_block_header_info_right_messenger">
                                    <button>Открыть диалог</button>
                                </div>

                                <div class="profileuser_block_header_info_right_freindrequest">
                                    <button>Запрос в друзья</button>
                                </div>

                                <div class="profileuser_block_header_info_right_report">
                                    <button>ПОЖАЛОВАТЬСЯ</button>
                                </div>

                            </div>


                        </div>


                    </div>

                </div>

                <div class="profileuser_block_contents">

                    {{-- 
                        
                        if videoscounts>statementscounts
                        foreach
                        менять местами

                        --}}
                        <div class="profileuser_block_contents_wrap">

                            <div class="profileuser_block_contents_first_wrap_title">
                                <p>Фотоматериалы</p>
                            </div>

                            <div class="profileuser_block_contents_first_wrap_line">
                            </div>

                            <div class="profileuser_block_contents_wrap_btn">
                                <p>Показать все</p>
                            </div>

                        </div>
                        
                    <div class="profileuser_block_contents_first">


                        <div class="profileuser_block_contents_first_contents">
                        </div>

                    </div>

                    <div class="profileuser_block_contents_wrap">

                        <div class="profileuser_block_contents_second_wrap_title">
                            <p>Видеоматериалы</p>
                        </div>

                        <div class="profileuser_block_contents_second_wrap_line"></div>

                        <div class="profileuser_block_contents_wrap_btn">
                            <p>Показать все</p>
                        </div>

                    </div>
                    <div class="profileuser_block_contents_second">



                        <div class="profileuser_block_contents_second_contents">



                        </div>

                    </div>
                </div>

            </div>


        </div>
    @endforeach


</x-app-layout>



{{-- удаление друга + диалог + изменить аватарку
                    
                    <div class="profile_info_right">

                    <div class="profile_info_right_friend">

                        @if ($user->id == auth()->id())
                        <form method="POST" action="{{ route('avatar.update') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input id="avatarInput" class="txt_2" type="file" name="avatar" accept="image/*">
                            </div>
                            <button class="txt_2" type="submit">Изменить аватар</button>
        
                        </form>
                    @endif


                        @if ($user->id != auth()->id() &&
    auth()->user()->areFriends($user->id))
                        <div class="profile_info_left_message">
                            <a href="{{ route('messenger.show', ['userId' => $user->id]) }}" class="message"><p class="txt_2">Открыть диалог</p></a>
                        </div>
                    @endif

                    </div>

                    <div class="profile_info_right_wishlist">

                        @if ($user->id != auth()->id() &&
    auth()->user()->areFriends($user->id))
                        <div class="profile_info_left_message">
                            <form id="removeFriendForm" method="POST"
                                action="{{ route('friend.remove', ['friend' => $user->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmRemoveFriend()"><p class="txt_2">Удалить из друзей</p></button>
                            </form>
                        </div>
                    @endif

                    <script>
                        function confirmRemoveFriend() {
                            if (confirm('Вы уверены, что хотите удалить этого друга?')) {
                                document.getElementById('removeFriendForm').submit();
                            }
                        }
                    </script>

                    </div>

                </div> --}}



{{-- <div class="profile_novosti_verh">

    @if ($user->id == auth()->id())
        <a href="/profile">
            <div class="profile_settings">
                <p class="txt_2">Настройки</p>
            </div>
        </a>
    @endif
    @if ($user->id == auth()->id())
        <div class="profile_condition">
            <form method="POST" action="{{ route('update-condition') }}">
                @csrf
                <input type="text" name="condition" value="{{ $user->condition }}"
                    placeholder="Кратко о себе...">
                <button class="txt_2" type="submit">Обновить условие</button>
            </form>
        </div>
    @endif
    @if ($user->id !== auth()->id())
        <p class="txt_1">{{ $user->condition }}</p>
    @endif

</div> --}}


{{-- запрос в др
                
                
                <div class="profile_novosti_next">





                @if ($user->id !== auth()->id())
                    <form method="POST" action="{{ route('send-friend-request', $user) }}">
                        @csrf
                        <button type="submit" class="btn-friend">Отправить запрос дружбы</button>
                    </form>
                @endif


            </div> --}}
