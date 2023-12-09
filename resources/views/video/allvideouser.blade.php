<x-app-layout>
    <x-slot name="header">

    </x-slot>




    <div class="main_allvideo_user">



        @if (auth()->user()->permission == 'enabled')
            <a href="{{ route('newvideo') }}">
                <div class="main_new_novo_video">
                    <p class="txt_2">Опубликовать видео</p>
                </div>
            </a>
        @endif
        <div class="main_osnova">
            <div class="main_novosti_allvideo">

                @php $count = 0; @endphp
                @for ($i = 0; $i < count($videos); $i += 4)
                    <div class="row_allvideo">
                        @for ($j = $i; $j < $i + 4 && $j < count($videos); $j++)
                            @php $video = $videos[$j]; @endphp
                            @if ($video->status == 'true') <div
                            class="main_novost_allvideo">
                            <a href="{{ route('videouser', ['id' => $video->id]) }}">
                            @csrf




                            <div class="main_novost_middle_all">
                            <div id="mediaContent">
                            <img src="{{ asset('storage/' . $video->thumbnail_path) }}"
                            alt="Thumbnail" class="videoThumbnail"
                            data-video="{{ asset('storage/' . $video->video_path) }}" style="cursor:
                            pointer; width: 280px; height: 160px;">

                            </div>

                            </div>



                            <div class="main_video_info">

                            <div class="main_video_info_1">

                            {{-- Аватар пользователя --}}

                            <div class="main_novost_img">

                            @if ($video->user_id !== null)

                                <a
                                href="{{ route('profileuser.profile', ['id' => $video->user_id]) }}">
                                <img class="avatar"
                                src="{{ asset('storage/' . $video->user->avatar) }}"
                                alt="Avatar">

                                </a> @endif


                    </div>

            </div>

            <div class="main_video_info_2">

                {{-- Название ролика --}}

                <div>
                    <a href="{{ route('videouser', ['id' => $video->id]) }}">
                        <p class="txt_2">{{ $video->title }}</p>
                    </a>
                </div>




                {{-- Имя пользователя --}}
                <a href="{{ route('profileuser.profile', ['id' => $video->user_id]) }}">
                    <p class="txt_2">
                        {{ $video->user->name }}
                    </p>

                </a>



                {{-- Время --}}
                <?php
                $createdAt = strtotime($video->created_at);

                $currentDate = strtotime(date('Y-m-d H:i:s'));

                $timeDiff = $currentDate - $createdAt;

                if ($timeDiff >= 86400) {
                $formattedTime = floor($timeDiff / 86400) . ' дней назад';
                } elseif ($timeDiff >= 3600) {
                $formattedTime = floor($timeDiff / 3600) . ' часов назад';
                } elseif ($timeDiff >= 60) {
                $formattedTime = floor($timeDiff / 60) . ' минут назад';
                } else {
                $formattedTime = 'только что';
                }

                echo '<p class="txt_2">ㅤ' . $formattedTime . '</p>';
                ?>

            </div>





        </div>



        <div class="main_novost_down">
            <div class="main_novost_down">

                @if (auth()->user()->role == 'Admin')
                    <div class="novost_down_func_video">


                        <form method="POST" action="{{ route('video.delete', ['id' => $video->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Удалить видео</button>
                        </form>

                    </div>
                @endif

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
                    <button onclick="toggleFriendsList({{ $video->id }})" class="novost_down_func_video">📢</button>

                </div>
                <div id="friendsList{{ $video->id }}" style="display: none;">
                    <div class="friendsList_repost">
                        @foreach ($friends as $friend)
                            @if ($friend->id !== auth()->id())
                                <a class="txt_2"
                                    href="{{ route('sendPostToFriend', ['postId' => $video->id, 'friendId' => $friend->id]) }}">
                                    {{ $friend->name }}
                                </a>
                            @endif
                        @endforeach
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


        </a>
    </div>


    @endif
    @endfor

    </div>
    @endfor
    </div>

    {{-- <div class="main_filter_video">
                <div class="main_filter1">
                    <form method="GET" action="{{ url()->current() }}">
                        @csrf

                        <div class="category">
                            
                            <label for="category">Выберите категорию</label>
                            <select class="custom-select-video" name="category" id="category">
                                <option value="">Все категории</option>
                                <option value="Спорт">Спорт</option>
                                <option value="Игры">Игры</option>
                                <option value="Экономика">Экономика</option>
                                <option value="Транспорт">Транспорт</option>
                            </select>
                        </div>

                        <div class="sortirovka">
                            <label for="sortirovka">Выберите сортировку</label>
                            <select class="custom-select-video" name="sortirovka" id="sortirovka">
                                <option value="recent">Сначала недавние</option>
                                <option value="old">Сначала старые</option>
                                <option value="popular">Сначала популярные</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <button type="submit" class="btn_1">Применить</button>
                        </div>
                    </form>
                </div>
            </div> --}}




    </div>

    </div>



</x-app-layout>
