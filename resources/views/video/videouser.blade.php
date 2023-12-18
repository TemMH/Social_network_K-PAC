<x-app-layout>
    <x-slot name="header">

    </x-slot>




    <div class="main_spec_zayavkauser">


        <div class="main_osnova_zayavka">

            <div class="main_zayavkauser">


                <div class="main_zayavkauser_info">

                    <p class="txt_1">{{ $video->title }}</p>

                    <div class="main_zayavkauser_line">

                    </div>
                </div>



                <div class="main_zayavkauser_osnova">

                    <div class="main_zayavkauser_desc">




                        <div id="mediaContent">
                            <img src="{{ asset('storage/' . $video->thumbnail_path) }}" alt="Thumbnail" class="videoThumbnail" data-video="{{ asset('storage/' . $video->video_path) }}" style="cursor: pointer; width: 320px; height: 240px;">

                        </div>
                            <p class="txt_2">
                                {{ $video->description }}
                            </p>
                            @if ($video->category !== null)
                                <p class="txt_2">Категория: {{ $video->category }}</p>
                            @endif


                    
                    <script>
document.querySelectorAll('.videoThumbnail').forEach(thumbnail => {
thumbnail.addEventListener('click', function() {
const videoPath = this.getAttribute('data-video');
const mediaContent = this.parentElement;
mediaContent.innerHTML = `
    <video width="320" height="240" controls autoplay>
        <source src="${videoPath}" type="video/mp4">
        Ваш браузер не поддерживает видео тег.
    </video>
`;
});
});

                    </script>




                    </div>


                </div>
                <div class="main_zzz">
                    <div class="main_zayavkauser_line">

                    </div>

                    <p class="txt_2">{{ $video->description }}</p>

                    <div class="main_zayavkauser_func">

                        <div class="novost_down_func_obsh">

                            <div class="novost_down_func1">

                                @if (!$video->likes()->where('user_id', auth()->id())->exists())
                                    <form method="POST" action="{{ route('video.like', ['id' => $video->id]) }}">
                                        @csrf
                                        <button class="novost_down_func_video" type="submit">𓆩♡𓆪</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('video.unlike', ['id' => $video->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="novost_down_func_video" type="submit">❤</button>
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
                                <button class="novost_down_func_video"
                                    onclick="toggleFriendsList({{ $video->id }})">📢</button>
                                <div id="friendsList{{ $video->id }}" style="display: none;">
                                    <div class="friendsList_repost">
                                        @foreach ($friends as $friend)
                                            @if ($friend->id !== auth()->id())
                                                <a
                                                    href="{{ route('sendPostToFriend', ['postId' => $video->id, 'friendId' => $friend->id]) }}">
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
                        <div class="main_zayavkauser_watch">

                            <p>Автор:</p>
                            <a href="{{ route('profileuser.profile', ['id' => $video->user_id, 'previous' => 'video']) }}">
                                {{ $video->user->name }}

                            </a>

                        </div>

                    </div>
                </div>


            </div>

        </div>



        <form method="POST" action="{{ route('video.comment', ['id' => $video->id]) }}">
            <div class="zayavkauser_comment">

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



        @foreach ($video->comments as $comment)
            <div class="zayavkauser_comment_show">

                <div class="main_novost_top">
                    <a href="{{ route('profileuser.profile', ['id' => $comment->user_id, 'previous' => 'video']) }}">
                        <div class="main_novost_img">

                            <img class="avatar" src="{{ asset('storage/' . $comment->user->avatar) }}" alt="Avatar">

                        </div>
                    </a>


                    <div class="main_novost_zagolovok">
                        <div>
                            <a href="{{ route('profileuser.profile', ['id' => $comment->user_id, 'previous' => 'video']) }}">
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
                        action="{{ route('video.comment.delete', ['videoId' => $video->id, 'commentId' => $comment->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="novost_down_func" type="submit">Удалить комментарий</button>
                    </form>
                @endif



            </div>
        @endforeach
    </div>



</x-app-layout>
