<x-app-layout>
    <x-slot name="header">

    </x-slot>

<div class="statement_field_open">

    <div class="statement_block_open">

        <div class="statement_block_top_open">

            <div class="statement_block_top_avatar_open">

                <img class="avatar_mini" src="/uploads/ProfilePhoto.png"alt="Avatar">
    
            </div>

            <div class="statement_block_top_info_open">

                <div class="statement_block_top_info_name_open">USERNAME</div>
    
                <div class="statement_block_top_info_createdat_open">STATEMENTDATE</div>
    
            </div>

        </div>
        <div class="statement_block_middle_open">

            <img src="http://127.0.0.1:8000/storage/thumbnails/thumbnail_1711267644.png" alt="">

        </div>
        <div class="statement_block_down_open">

            <div class="statement_block_down_title_open">STATEMENTTITLE</div>
            <div class="statement_block_down_description_open">STATEMENTDESCRIPTION</div>

        </div>


    </div>

</div>




    <div class="statements_field">

        <div class="statements_settings">
            
            <form class="statements_settings_left" id="categoryForm" method="GET" action="{{ url()->current() }}">
                @csrf
                <button value="Игры" class="statements_categories_btn">Тренд</button>
                <button value="Экономика" class="statements_categories_btn">Недавние</button>
                <button value="Транспорт" class="statements_categories_btn">Популярные</button>
            </form>

            <form class="statements_settings_right" id="categoryForm" method="GET" action="{{ url()->current() }}">
                @csrf

                <button value="" class="statements_categories_btn">Все категории</button>
                <button value="Спорт" class="statements_categories_btn">Спорт</button>
                <button value="Игры" class="statements_categories_btn">Игры</button>
                <button value="Экономика" class="statements_categories_btn">Экономика</button>
                <button value="Транспорт" class="statements_categories_btn">Транспорт</button>

            </form>

        </div>

        <div class="statements_scroll_lock">

            @forelse ($statements as $statement)
                @if ($statement->status == 'true')
                    <div class="statement_block">

                        <div class="statement_block_top">

                            <div class="statement_block_top_avatar">

                                @if ($statement->user->avatar !== null)
                                    <a href="{{ route('profileuser.profile', ['id' => $statement->user_id]) }}">
                                        <img class="avatar" src="{{ asset('storage/' . $statement->user->avatar) }}"
                                            alt="Avatar">
                                    </a>
                                @else
                                    <a href="{{ route('profileuser.profile', ['id' => $statement->user_id]) }}">
                                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                    </a>
                                @endif

                            </div>

                            <div class="statement_block_top_info">

                                <div class="statement_block_top_info_name">{{ $statement->title }}</div>

                                <div class="statement_block_top_info_createdat">{{ $statement->created_at }}</div>

                            </div>

                        </div>

                        <div class="statement_block_middle">

                            <img src="{{ asset('storage/' . $statement->photo_path) }}" alt="Photo">

                        </div>

                        <div class="statement_block_down">

                            <div class="statement_block_down_title">{{ $statement->title }}</div>
                            <div class="statement_block_down_description">{{ $statement->description }}</div>

                        </div>

                    </div>
                @endif

            @empty
                <p class= "txt_1">Новостей нет</p>

            @endforelse

        </div>

    </div>



</x-app-layout>


{{-- LIKE

<div class="novost_down_func1">
    @if (!$statement->likes()->where('user_id', auth()->id())->exists())
        <form method="POST"
            action="{{ route('statement.like', ['id' => $statement->id]) }}">
            @csrf
            <button type="submit"
                class="novost_down_func_news"><span>{{ $statement->likes_count }}</span>ㅤ𓆩♡𓆪</button>
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


</div> --}}

{{-- РЕПОСТ
<div class="main_novost_down">

    <?php
    $friendsList = \App\Models\Friendship::where(function ($query) {
        $query->where('sender_id', auth()->id())->where('status', 'accepted');
    })
        ->orWhere(function ($query) {
            $query->where('recipient_id', auth()->id())->where('status', 'accepted');
        })
        ->get();
    
    $friendIds = $friendsList->pluck('sender_id')->merge($friendsList->pluck('recipient_id'))->unique();
    
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
</div> 

--}}
