<x-app-layout>
    <x-slot name="header">

    </x-slot>




    <div class="main">





        @if (auth()->user()->permission == 'enabled')
            <a href="{{ route('newvideo') }}">
                <div class="main_new_novo">
                    <p class="txt_2">Добавить видео</p>
                </div>
            </a>
        @endif
        <div class="main_osnova">
            <div class="main_novosti">

                @forelse ($videos as $video)
                    @if ($video->status == 'true')
                    
                        <div class="main_novost">

                            @csrf
                            <div class="main_novost_top">
                                <div class="main_novost_img">

                                    @if ($video->user_id !== NULL)
                                    
                                        <a href="{{ route('profileuser.profile', ['id' => $video->user_id]) }}">
                                           
                                            <img class="avatar" src=" {{$video->user !== null ? asset($video->user->avatar) : asset('storage/')}}"
                                                alt="Avatar">
                                        </a>

                                    @endif


                                </div>


                                <div class="main_novost_zagolovok">
                                    <div>

                                            <p class="txt_2">{{ $video->title }}</p>

                                    </div>

                                    <div class="flex">
                                        <a href="{{ route('profileuser.profile', ['id' => $video->user_id]) }}">
                                           <p class="txt_2">
                                                {{ $video->user->name }}
                                            </p>
                          
                                        </a>
                                        <p class="txt_2">ㅤ{{ $video->created_at }}</p>


                                    </div>
                                </div>

                            </div>



                            <div class="main_novost_middle">
                                   <p class="txt_2">
                                        {{ $video->description }}
                                    </p>
                                </a>

                                @if ($video->category !== null)
                                    <p class="txt_2">Категория: {{ $video->category }}</p>
                                @endif
                            </div>



                            <div class="main_novost_down">
                                <div class="main_novost_down">
                                    <div class="novost_down_func1">
                                        @if (!$video->likes()->where('user_id', auth()->id())->exists())
                                            <form method="POST"
                                                action="{{ route('video.like', ['id' => $video->id]) }}">
                                                @csrf
                                                <button type="submit"
                                                    class="novost_down_func"><span>{{ $video->likes_count }}</span>ㅤ𓆩♡𓆪</button>
                                            </form>
                                        @else
                                            <form method="POST"
                                                action="{{ route('video.unlike', ['id' => $video->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="novost_down_func">
                                                    <span>{{ $video->likes_count }}</span>ㅤ❤</button>
                                            </form>
                                        @endif


                                    </div>

                                    @if (auth()->user()->role == 'Admin')
                                        <div class="novost_down_func">


                                            <form method="POST"
                                                action="{{ route('video.delete', ['id' => $video->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">Удалить новость</button>
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
                                        <button onclick="toggleFriendsList({{ $video->id }})"
                                            class="novost_down_func">📢</button>

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

                        </div>
                    @endif

                @empty
                    <p class= "txt_1">Новостей нет</p>

                @endforelse
            </div>

            <div class="main_filter">
                <div class="main_filter1">
                    <form method="GET" action="{{ url()->current() }}">
                        @csrf

                        <div class="category">
                            
                            <label for="category">Выберите категорию</label>
                            <select class="custom-select" name="category" id="category">
                                <option value="">Все категории</option>
                                <option value="Спорт">Спорт</option>
                                <option value="Игры">Игры</option>
                                <option value="Экономика">Экономика</option>
                                <option value="Транспорт">Транспорт</option>
                            </select>
                        </div>

                        <div class="sortirovka">
                            <label for="sortirovka">Выберите сортировку</label>
                            <select class="custom-select" name="sortirovka" id="sortirovka">
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
            </div>




        </div>

    </div>



</x-app-layout>
