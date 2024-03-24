<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="shortvideo_rama_scroll">

        @foreach ($videos as $video)
            <div class="shortvideo_rama" data-video-id="{{ $video->id }}">
                <div class="main_shortvideo_content">

                    <div class="main_shortvideo_desc_left">
                        <div class="main_shortvideo_left">
                            <div class="main_shortvideo_func">
                                <div class="author">



                                    @if ($video->user->avatar !== null)
                                        <img class="avatar" src="{{ asset('storage/' . $video->user->avatar) }}"
                                            alt="Avatar">
                                    @else
                                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                    @endif

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
                                {{-- ОПИСАНИЕ РОЛИКА ШРИФТ МЕНЬШЕ + ДОБАВИТЬ ТЁМНЫЙ ФОН --}}
                            </div>
                        </div>
                    </div>


                    <div class="main_shortvideo_right">

                        <button class="shortvideo_toggleComments">Показать комментарии</button>
                        <div class="main_shortvideo_desc_right">


                            <div class="shortvideo_comments">
                                @foreach ($video->comments as $comment)
                                    <div class="statementuser_comment_show_shortvideo">

                                        <div class="main_novost_top">
                                            <a
                                                href="{{ route('profileuser.profile', ['id' => $comment->user_id, 'previous' => 'video']) }}">
                                                <div class="main_novost_img">

                                                    @if ($comment->user->avatar !== null)
                                                        <img src="{{ asset('storage/' . $friend->avatar) }}"
                                                            alt="Avatar">
                                                    @else
                                                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png"
                                                            alt="Avatar">
                                                    @endif




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
                                                <button class="novost_down_func" type="submit">Удалить
                                                    комментарий</button>
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
                    </div>

                    <div id="mediaContent">
                        <div class="main_shortvideo_content current-video">

                            <div class="video-container paused" data-volume-level="high">

                                <div class="video-controls-container">
                                    <div class="timeline-container">
                                        <div class="timeline">
                                            <div class="thumb-indicator"></div>
                                        </div>
                                    </div>
                                    <div class="controls">
                                        <button class="play-pause-btn">
                                            <svg class="play-icon" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M8,5.14V19.14L19,12.14L8,5.14Z" />
                                            </svg>
                                            <svg class="pause-icon" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M14,19H18V5H14M6,19H10V5H6V19Z" />
                                            </svg>
                                        </button>

                                        <div class="duration-container">
                                            <div class="current-time">0:00</div>
                                            /
                                            <div class="total-time"></div>
                                        </div>


                                        <div class="volume-container">
                                            <input class="volume-slider" type="range" min="0" max="1"
                                                step="any" value="1">

                                            <button class="mute-btn">

                                                <svg class="volume-high-icon" viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M14,3.23V5.29C16.89,6.15 19,8.83 19,12C19,15.17 16.89,17.84 14,18.7V20.77C18,19.86 21,16.28 21,12C21,7.72 18,4.14 14,3.23M16.5,12C16.5,10.23 15.5,8.71 14,7.97V16C15.5,15.29 16.5,13.76 16.5,12M3,9V15H7L12,20V4L7,9H3Z" />
                                                </svg>
                                                <svg class="volume-low-icon" viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M5,9V15H9L14,20V4L9,9M18.5,12C18.5,10.23 17.5,8.71 16,7.97V16C17.5,15.29 18.5,13.76 18.5,12Z" />
                                                </svg>
                                                <svg class="volume-muted-icon" viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M12,4L9.91,6.09L12,8.18M4.27,3L3,4.27L7.73,9H3V15H7L12,20V13.27L16.25,17.53C15.58,18.04 14.83,18.46 14,18.7V20.77C15.38,20.45 16.63,19.82 17.68,18.96L19.73,21L21,19.73L12,10.73M19,12C19,12.94 18.8,13.82 18.46,14.64L19.97,16.15C20.62,14.91 21,13.5 21,12C21,7.72 18,4.14 14,3.23V5.29C16.89,6.15 19,8.83 19,12M16.5,12C16.5,10.23 15.5,8.71 14,7.97V10.18L16.45,12.63C16.5,12.43 16.5,12.21 16.5,12Z" />
                                                </svg>
                                            </button>

                                        </div>
                                        <button class="speed-btn wide-btn" data-video-id="{{ $video->id }}">
                                            1x
                                        </button>

                                        <button class="theater-btn">
                                            <svg class="tall" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M19 6H5c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 10H5V8h14v8z" />
                                            </svg>
                                            <svg class="wide" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M19 7H5c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zm0 8H5V9h14v6z" />
                                            </svg>
                                        </button>

                                        {{-- <button class="full-screen-btn">
                                            <svg class="open" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z" />
                                            </svg>
                                            <svg class="close" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z" />
                                            </svg>
                                        </button> --}}
                                    </div>
                                </div>

                                <video loop width="320" height="240" autoplay style="object-fit:contain">
                                    <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                                    Ваш браузер не поддерживает видео тег.
                                </video>


                            </div>
                        </div>
                    </div>


                </div>
            </div>
        @endforeach

    </div>
    <script>
        document.querySelectorAll('.shortvideo_toggleComments').forEach(function(button) {
            button.addEventListener('click', function() {
                var comments = this.nextElementSibling;
                var isActive = comments.classList.contains('active');


                if (isActive) {
                    comments.classList.remove('active');
                    this.textContent = 'Показать комментарии';
                } else {
                    comments.classList.add('active');
                    this.textContent = 'Скрыть комментарии';
                }
            });
        });
    </script>

    <script>
        function toggleTheaterAndFullScreen() {
            const shortVideoRamaScroll = document.querySelector(".shortvideo_rama_scroll");
            shortVideoRamaScroll.classList.toggle("theater");
            toggleFullScreen();
        }

        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        document.addEventListener("keydown", function(event) {
            if (event.keyCode === 70) { // Клавиша F
                toggleTheaterAndFullScreen();
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const videos = document.querySelectorAll("video");
            const theaterBtns = document.querySelectorAll(".theater-btn");
            const shortVideoRamaScroll = document.querySelector(".shortvideo_rama_scroll");

            function toggleFullScreen() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    }
                }
            }

            let speedChanged = false;



            document.addEventListener("keydown", function(event) {
                if (event.keyCode === 32) {
                    event.preventDefault();
                    const activeVideo = document.querySelector(".shortvideo_rama.active video");
                    if (activeVideo) {
                        if (activeVideo.paused) {
                            activeVideo.play();
                        } else {
                            activeVideo.pause();
                        }
                    }
                }
            });

            document.addEventListener("fullscreenchange", function() {
                if (!document.fullscreenElement) {
                    shortVideoRamaScroll.classList.remove("theater");
                }
            });

            const savedVolume = localStorage.getItem("savedVolume");
            const initialVolume = savedVolume !== null ? parseFloat(savedVolume) : 1;

            videos.forEach(function(video) {
                const playPauseBtn = video.parentElement.querySelector(".play-pause-btn");
                const volumeBtn = video.parentElement.querySelector(".mute-btn");
                const volumeSlider = video.parentElement.querySelector(".volume-slider");
                const currentTimeDisplay = video.parentElement.querySelector(".current-time");
                const totalTimeDisplay = video.parentElement.querySelector(".total-time");
                const timeline = video.parentElement.querySelector(".timeline");
                const speedBtn = video.parentElement.querySelector(".speed-btn");
                const thumbIndicator = video.parentElement.querySelector(".thumb-indicator");

                document.addEventListener("keydown", function(event) {
                    if (event.target.tagName.toLowerCase() !== 'input' && event.target.tagName
                        .toLowerCase() !== 'textarea') {
                        const activeVideo = document.querySelector(".shortvideo_rama.active video");

                        switch (event.keyCode) {

                            case 37: // Стрелка влево
                                if (activeVideo && activeVideo.currentTime >= 1) {
                                    activeVideo.currentTime -= 1;
                                }
                                break;
                            case 39: // Стрелка вправо
                                const rightActiveVideo = document.querySelector(
                                    ".shortvideo_rama.active video");
                                if (rightActiveVideo) {
                                    if (!speedChanged) {
                                        changePlaybackSpeed(rightActiveVideo, rightActiveVideo
                                            .parentElement.querySelector(".speed-btn"));
                                        speedChanged =
                                            true;
                                    }
                                }
                                break;
                            case 77: // Клавиша M
                                video.muted = !video.muted;
                                break;
                        }
                    }
                });



                theaterBtns.forEach(function(theaterBtn) {
                    theaterBtn.addEventListener("click", toggleTheaterAndFullScreen);
                });

                document.addEventListener("keyup", function(event) {
                    if (event.keyCode ===
                        39) {
                        speedChanged = false;
                    }
                });
                video.volume = initialVolume;
                volumeSlider.value = initialVolume;

                playPauseBtn.addEventListener("click", function() {
                    if (video.paused) {
                        video.play();
                    } else {
                        video.pause();
                    }
                });



                volumeBtn.addEventListener("click", function() {
                    if (video.muted) {
                        video.muted = false;
                        volumeSlider.value = initialVolume;
                    } else {
                        video.muted = true;
                        volumeSlider.value = 0;
                    }
                });

                volumeSlider.addEventListener("input", function() {
                    video.volume = volumeSlider.value;
                    localStorage.setItem("savedVolume", volumeSlider.value);
                });

                video.addEventListener("timeupdate", function() {
                    currentTimeDisplay.textContent = formatTime(video.currentTime);
                    totalTimeDisplay.textContent = formatTime(video.duration);

                    const progress = video.currentTime / video.duration * 100;
                    thumbIndicator.style.left = `${progress}%`;
                });

                function formatTime(time) {
                    const minutes = Math.floor(time / 60);
                    const seconds = Math.floor(time % 60);
                    return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                }

                speedBtn.addEventListener("click", function() {
                    changePlaybackSpeed(video, speedBtn);
                });
            });
        });


        function changePlaybackSpeed(video, speedBtn) {
            let newPlaybackRate = video.playbackRate + 0.25;
            if (newPlaybackRate > 2) newPlaybackRate = 0.25;
            video.playbackRate = newPlaybackRate;
            speedBtn.textContent = `${newPlaybackRate}x`;
        }


        document.addEventListener("DOMContentLoaded", function() {
            const videos = document.querySelectorAll("video");

            function updateAddressBar(videoId) {
                window.history.replaceState(null, null, `?videoId=${videoId}`);
            }

            const options = {
                root: null,
                rootMargin: '0px',
                threshold: 0.5
            };

            function handleIntersection(entries, observer) {
                entries.forEach(entry => {
                    const video = entry.target;
                    const shortVideoRama = video.closest('.shortvideo_rama');
                    if (shortVideoRama) {
                        if (entry.isIntersecting) {
                            video.play();
                            shortVideoRama.classList.add('active');
                            const videoId = shortVideoRama.dataset.videoId;
                            updateAddressBar(videoId);
                        } else {
                            video.pause();
                            shortVideoRama.classList.remove('active');
                        }
                    }
                });
            }

            const observer = new IntersectionObserver(handleIntersection, options);

            videos.forEach(video => {
                observer.observe(video);
            });
        });
    </script>


</x-app-layout>
