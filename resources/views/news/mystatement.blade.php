<x-app-layout>
    <x-slot name="header">

    </x-slot>




    <div class="main">


        @if (auth()->user()->permission == 'enabled')
            <a href="{{ route('newstatement') }}">
                <div class="main_new_novo">
                    <p class="txt_2">Предложите свою новость</p>
                </div>
            </a>
        @endif

        <div class="main_osnova">

            <div class="maim_novosti">
                @forelse ($statements as $statement)

                    <div class="main_novost_news">

                        <div class="main_novost_top">
                            <div class="main_novost_img">
                                <a href="{{ route('profileuser.profile', ['id' => $statement->user_id, 'previous' => 'news']) }}">
                                    <img class="avatar" src="{{ asset('storage/' . $statement->user->avatar) }}"
                                        alt="Avatar">
                                </a>
                            </div>

                            <div class="main_novost_title">
                                <div>
                                    @if ($statement->status == 'true')
                                        <a href="{{ route('statementuser', ['id' => $statement->id]) }}">
                                            <p class="txt_2">{{ $statement->title }}</p>
                                        </a>
                                    @endif
                                    
                                    @if ($statement->status !== 'true')

                                        <p class="txt_2">{{ $statement->title }}</p>
                                        
                                    @endif


                                </div>

                                <div class="flex">
                                    <a href="{{ route('profileuser.profile', ['id' => $statement->user_id, 'previous' => 'news']) }}">
                                        <p class="txt_2">
                                            {{ $statement->name }}
                                        </p>
                                    </a>

                                    <p class="txt_2">ㅤ{{ $statement->created_at }}</p>


                                </div>
                            </div>

                        </div>
                        <div class="main_novost_middle">

                            @if ($statement->status == 'true')
                            <a href="{{ route('statementuser', ['id' => $statement->id]) }}">
                                <p class="txt_2">{{ $statement->description }}</p>

                            </a>
                            @endif


                            @if ($statement->status !== 'true')
                                <p class="txt_2">{{ $statement->description }}</p>
                            @endif



                            @if ($statement->category !== null)
                                <p class="txt_2">Категория: {{ $statement->category }}</p>
                            @endif

                        </div>


                        {{-- <form method="POST" action="{{ route('statement.updatetest', ['id' => $statement->id]) }}">
                            @csrf
                            @method('PUT')
                            <input class="custom-search-input" type="text" name="title" value="{{ $statement->title }}">
                            <input class="custom-search-input" type="text" name="description" value="{{ $statement->description }}">
                            <input class="custom-search-input" type="text" name="category" value="{{ $statement->category }}">
                            <button type="submit">Сохранить изменения</button>
                        </form> --}}

                        <div class="main_novost_down">
                            <div class="novost_down_func_news">{{ $statement->status }}</div>





                            @if ($statement->status == 'true')
                                <div class="novost_down_func1">

                                    @if (!$statement->likes()->where('user_id', auth()->id())->exists())
                                        <form method="POST"
                                            action="{{ route('statement.like', ['id' => $statement->id]) }}">
                                            @csrf
                                            <button type="submit" class="novost_down_func_news">
                                                <span>{{ $statement->likes_count }}</span>ㅤ𓆩♡𓆪</button>
                                        </form>
                                    @else
                                        <form method="POST"
                                            action="{{ route('statement.unlike', ['id' => $statement->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="novost_down_func_news">
                                                <span>{{ $statement->likes_count }}</span>ㅤ❤</button>
                                        </form>
                                    @endif



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
                                    <button onclick="toggleFriendsList({{ $statement->id }})"
                                        class="novost_down_func_news">📢</button>

                                </div>
                                <div id="friendsList{{ $statement->id }}" style="display: none;">
                                    <div class="friendsList_repost">
                                        @foreach ($friends as $friend)
                                            @if ($friend->id !== auth()->id())
                                                <a class="txt_2"
                                                    href="{{ route('sendPostToFriend', ['postId' => $statement->id, 'friendId' => $friend->id]) }}">
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
                            @endif



                        </div>
                    </div>





                @empty
                    <p class="txt_1">Новостей нет</p>

                @endforelse
            </div>

            <div class="main_filter_news">
                <div class="main_filter1">
                    <form method="GET" action="{{ url()->current() }}">
                        @csrf


                        <div class="category">
                            <label for="category">Выберите категорию</label>
                            <select class="custom-select-news" name="category" id="category">
                                <option value="">Все категории</option>
                                <option value="Спорт">Спорт</option>
                                <option value="Игры">Игры</option>
                                <option value="Экономика">Экономика</option>
                                <option value="Транспорт">Транспорт</option>
                            </select>
                        </div>


                        <div class="sortirovka">
                            <label for="sortirovka">Выберите сортировку</label>
                            <select class="custom-select-news" name="sortirovka" id="sortirovka">
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