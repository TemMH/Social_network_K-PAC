<x-app-layout>
    <x-slot name="header">

    </x-slot>




    <div class="main_spec_statementuser">


        <div class="main_osnova_statement">

            <div class="main_statementuser">


                <div class="main_statementuser_info">

                    <p class="txt_1">{{ $statement->title }}</p>

                    <div class="main_statementuser_line">

                    </div>
                </div>



                <div class="main_statementuser_osnova">

                    <div class="main_statementuser_desc">
                        <p class="txt_2">{{ $statement->description }}</p>
                    </div>


                </div>
                <div class="main_zzz">
                    <div class="main_statementuser_line">

                    </div>

                    <div class="main_statementuser_func">

                        <div class="novost_down_func_obsh">

                            <div class="novost_down_func1">

                                @if (!$statement->likes()->where('user_id', auth()->id())->exists())
                                    <form method="POST" action="{{ route('statement.like', ['id' => $statement->id]) }}">
                                        @csrf
                                        <button class="novost_down_func" type="submit">𓆩♡𓆪</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('statement.unlike', ['id' => $statement->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="novost_down_func" type="submit">❤</button>
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
                                <button class="novost_down_func"
                                    onclick="toggleFriendsList({{ $statement->id }})">📢</button>
                                <div id="friendsList{{ $statement->id }}" style="display: none;">
                                    <div class="friendsList_repost">
                                        @foreach ($friends as $friend)
                                            @if ($friend->id !== auth()->id())
                                                <a
                                                    href="{{ route('sendPostToFriend', ['postId' => $statement->id, 'friendId' => $friend->id]) }}">
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
                        <div class="main_statementuser_watch">

                            <p>Автор:</p>
                            <a href="{{ route('profileuser.profile', ['id' => $statement->user_id, 'previous' => 'news']) }}">
                                {{ $statement->name }}

                            </a>

                        </div>

                    </div>
                </div>


            </div>

        </div>



        <form method="POST" action="{{ route('statement.comment', ['id' => $statement->id]) }}">
            <div class="statementuser_comment">

                @csrf

                <div class="main_novost_img">

                    <img class="avatar" src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar">

                </div>



                <textarea class="form_field_comment" name="comment"></textarea>



                <div class="submit_comment">
                    <button class="txt_2">
                        Отправить
                    </button>


                </div>

            </div>
        </form>



        @foreach ($statement->comments as $comment)
            <div class="statementuser_comment_show">

                <div class="main_novost_top">
                    <a href="{{ route('profileuser.profile', ['id' => $comment->user_id, 'previous' => 'news']) }}">
                        <div class="main_novost_img">

                            <img class="avatar" src="{{ asset('storage/' . $comment->user->avatar) }}" alt="Avatar">

                        </div>
                    </a>


                    <div class="main_novost_title">
                        <div>
                            <a href="{{ route('profileuser.profile', ['id' => $comment->user_id, 'previous' => 'news']) }}">
                                <p class="txt_2">{{ $comment->user->name }}</p>
                            </a>
                        </div>
                        <div>
                            <p class="txt_2">{{ $comment->created_at }}</p>
                        </div>
                    </div>

                </div>

                <div class="main_comment_show">
                    <p class="txt_2">{{ $comment->content }}</p>
                </div>



                @if (auth()->user()->role == 'Admin')
                    <form method="POST"
                        action="{{ route('statement.comment.delete', ['statementId' => $statement->id, 'commentId' => $comment->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="novost_down_func" type="submit">Удалить комментарий</button>
                    </form>
                @endif



            </div>
        @endforeach
    </div>



</x-app-layout>
