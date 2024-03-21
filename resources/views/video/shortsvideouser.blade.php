<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="shortvideo_rama_scroll">

        @foreach ($videos as $video)
            <div class="shortvideo_rama">
                <div class="main_shortvideo_content">

                    <div class="main_shortvideo_desc_left">
                        <div class="main_shortvideo_left">
                            <div class="main_shortvideo_func">
                                <div class="author">
                                    <img class="avatar" src="{{ asset('storage/' . $video->user->avatar) }}"
                                        alt="Avatar">

                                    <p class="txt_2"> <a
                                            href="{{ route('profileuser.profile', ['id' => $video->user_id, 'previous' => 'video']) }}">
                                            {{ $video->user->name }}

                                        </a></p>

                                    <div class="novost_down_func1">
                                        <button class="novost_down_func_video" onclick="">Подписаться</button>
                                    </div>
                                </div>

                                <div class="main_statementuser_func">

                                    <div class="novost_down_func_obsh">

                                        <div class="novost_down_func1">

                                            @if (!$video->likes()->where('user_id', auth()->id())->exists())
                                                <form method="POST"
                                                    action="{{ route('video.like', ['id' => $video->id]) }}">
                                                    @csrf
                                                    <button class="novost_down_func_video" type="submit">𓆩♡𓆪</button>
                                                </form>
                                            @else
                                                <form method="POST"
                                                    action="{{ route('video.unlike', ['id' => $video->id]) }}">
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
                                        
                                        $friendIds = $friendsList->pluck('sender_id')->merge($friendsList->pluck('recipient_id'))->unique();
                                        
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


                                        <div class="novost_down_func1">
                                            <button class="novost_down_func_video" onclick="">Пожаловаться</button>
                                        </div>

                                    </div>
                                    <div class="main_statementuser_watch">



                                    </div>

                                </div>
                            </div>

                            <div class="main_statementuser_info">

                                <p class="txt_1">{{ $video->title }}</p>


                            </div>

                        </div>




                    </div>

                    <div class="main_shortvideo_desc_right">

                        {{-- РАЗДЕЛИТЬ КОММЕНТЫ С ИНПУТОМ (КОМЕНТЫ В overflow) --}}
                        <div class="shortvideo_comments">
                            @foreach ($video->comments as $comment)
                                <div class="statementuser_comment_show_shortvideo">

                                    <div class="main_novost_top">
                                        <a
                                            href="{{ route('profileuser.profile', ['id' => $comment->user_id, 'previous' => 'video']) }}">
                                            <div class="main_novost_img">

                                                <img class="avatar"
                                                    src="{{ asset('storage/' . $comment->user->avatar) }}"
                                                    alt="Avatar">

                                            </div>
                                        </a>


                                        <div class="main_novost_title">
                                            <div>
                                                <a
                                                    href="{{ route('profileuser.profile', ['id' => $comment->user_id, 'previous' => 'video']) }}">
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

                        <div class="new_comment">


                            <form method="POST" action="{{ route('video.comment', ['id' => $video->id]) }}">
                                <div class="shortvideo_form_comment">

                                    @csrf




                                    <textarea class="form_field_comment_shortvideo" name="comment"></textarea>



                                    <div class="submit_comment">
                                        <button class="txt_2">
                                            Отправить
                                        </button>


                                    </div>

                                </div>
                            </form>

                        </div>



                    </div>


                    <div id="mediaContent">
                        <div class="main_shortvideo_content current-video">

                            <video width="320" height="240" controls autoplay>
                                <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                                Ваш браузер не поддерживает видео тег.
                            </video>
                        </div>

                    </div>


                </div>
            </div>
        @endforeach


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var videos = document.querySelectorAll('.main_shortvideo_content');
                var currentIndex = 0;

                function showNextVideo() {
                    if (currentIndex < videos.length - 1) {
                        videos[currentIndex].classList.remove('visible');
                        currentIndex++;
                        videos[currentIndex].classList.add('visible');
                        videos[currentIndex].scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }

                function showPreviousVideo() {
                    if (currentIndex > 0) {
                        videos[currentIndex].classList.remove('visible');
                        currentIndex--;
                        videos[currentIndex].classList.add('visible');
                        videos[currentIndex].scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }

                document.addEventListener('wheel', function(event) {
                    if (event.deltaY > 0) {
                        showNextVideo();
                    } else {
                        showPreviousVideo();
                    }
                });
            });
        </script>


    </div>
</x-app-layout>
