<x-app-layout>
    <x-slot name="header">

    </x-slot>



    @foreach ($users as $user)
        <div class="profile_main">


            <div class="profile_avatar">
                <img class="avatar" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar">

            </div>






            <div class="profile_info">

                <div class="profile_info_left">

                    <div class="profile_info_left_login">
                        <p class="txt_1">{{ $user->name }}</p>
                    </div>

                    <div class="profile_info_left_date">
                        <p class="txt_2">{{ $user->created_at }}</p>
                    </div>












                </div>
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


                        @if (
                        $user->id != auth()->id() &&
                            auth()->user()->areFriends($user->id))
                        <div class="profile_info_left_message">
                            <a href="{{ route('dialog.show', ['userId' => $user->id]) }}" class="message"><p class="txt_2">Открыть диалог</p></a>
                        </div>
                    @endif

                    </div>

                    <div class="profile_info_right_wishlist">

                        @if (
                        $user->id != auth()->id() &&
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

                </div>



            </div>

            <div class="profile_novosti_verh">

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
                                placeholder="Введите новое условие">
                            <button class="txt_2" type="submit">Обновить условие</button>
                        </form>
                    </div>
                @endif
                @if ($user->id !== auth()->id())
                    <p class="txt_1">{{ $user->condition }}</p>
                @endif



                <div class="profile_last_news">

                    <p class="txt_2">Последние добавленные новости</p>

                </div>



            </div>



            <div class="profile_novosti_osnova">

                @foreach ($zayavkas as $zayavka)
                    @if ($zayavka->status == 'true')
                        <div class="profile_novost_back">
                            <a href="{{ route('zayavkauser', ['id' => $zayavka->id]) }}">

                                <div class="profile_novost_up">
                                    <p class="txt_2">{{ $zayavka->zagolovok }}</p>

                                </div>
                                <div class="profile_novost_middle">
                                    <p class="txt_2">{{ $zayavka->description }}</p>
                                </div>





                            </a>
                            <div class="profile_novost_back_dovn">
                                <div class="profile_novost_back_dovn_dop">
                                    <p class="txt_2">{{ $zayavka->created_at }}</p>
                                </div>
                                <div class="profile_novost_back_dovn_dop">
                                    <div class="novost_down_func1">
                                        @if (!$zayavka->likes()->where('user_id', auth()->id())->exists())
                                            <form method="POST"
                                                action="{{ route('zayavka.like', ['id' => $zayavka->id]) }}">
                                                @csrf
                                                <button class="novost_down_func" type="submit">𓆩♡𓆪</button>
                                            </form>
                                        @else
                                            <form method="POST"
                                                action="{{ route('zayavka.unlike', ['id' => $zayavka->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="novost_down_func" type="submit">❤</button>
                                            </form>
                                        @endif

                                        <span>{{ $zayavka->likes_count }}</span>
                                    </div>



                                    <?php
                                    $friendsList = \App\Models\Friendship::where(function ($query) {
                                        $query->where('sender_id', auth()->id())->where('status', 'accepted');
                                    })
                                        ->orWhere(function ($query) {
                                            $query->where('recipient_id', auth()->id())->where('status', 'accepted');
                                        })
                                        ->get();
                                    
                                    $friendIds = $friendsList
                                        ->pluck('sender_id')
                                        ->merge($friendsList->pluck('recipient_id'))
                                        ->unique();
                                    
                                    $friends = \App\Models\User::whereIn('id', $friendIds)->get();
                                    ?>

                                    <div class="novost_down_func1">
                                        <button class="novost_down_func" onclick="toggleFriendsList({{ $zayavka->id }})">📢</button>
                                        <div id="friendsList{{ $zayavka->id }}" style="display: none;">
                                            <div class="friendsList_repost">
                                                @foreach ($friends as $friend)
                                                    @if ($friend->id !== auth()->id())
                                                        <a
                                                            href="{{ route('sendPostToFriend', ['postId' => $zayavka->id, 'friendId' => $friend->id]) }}">
                                                            {{ $friend->name }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        function toggleFriendsList(postId) {
                                            const friendsList = document.getElementById(`friendsList${postId}`);
                                            friendsList.style.display = friendsList.style.display === 'none' ? 'block' : 'none';
                                        }
                                    </script>
                                </div>

                            </div>


                        </div>
                    @endif
                @endforeach






            </div>


            <div class="profile_novosti_next">





                @if ($user->id !== auth()->id())
                    <form method="POST" action="{{ route('send-friend-request', $user) }}">
                        @csrf
                        <button type="submit" class="btn-friend">Отправить запрос дружбы</button>
                    </form>
                @endif


            </div>

        </div>
    @endforeach


</x-app-layout>
