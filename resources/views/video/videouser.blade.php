<x-app-layout>
    <x-slot name="header">

    </x-slot>



    <div class="statement_field_open">
        <div class="modal_block_open">

            <div class="modal-content">
                <form id="sendcomplaint" action="{{ route('video.complaint', ['id' => $video->id]) }}"
                    method="post">
                    @csrf

                    <p>Причина жалобы</p>
                    <div class='radio-group'>
                        <label class='radio-label'>
                            <input type='radio' id="reasonInput" name="reason" value="Спам" required>
                            <span class='inner-label'>Спам</span>
                        </label>
                        <label class='radio-label'>
                            <input  type='radio' id="reasonInput" name="reason" value="Жестокое или отталкивающее содержание" required>
                            <span class='inner-label'>Жестокое или отталкивающее содержание</span>
                        </label>
                        <label class='radio-label'>
                            <input  type='radio' id="reasonInput" name="reason" value="Дискриминационные высказывания и оскорбления" required>
                            <span class='inner-label'>Дискриминационные высказывания и оскорбления</span>
                        </label>
                        <label class='radio-label'>
                            <input type='radio' id="reasonInput" name="reason" value="Вредные или опасные действия" required>
                            <span class='inner-label'>Вредные или опасные действия</span>
                        </label>
                        <label class='radio-label'>
                            <input type='radio' id="reasonInput" name="reason" value="Мошенничество" required>
                            <span class='inner-label'>Мошенничество</span>
                        </label>
                    </div>

                    <button type="submit" style="float:right" class="statements_categories_btn">Отправить</button>
                </form>
            </div>

        </div>

        <div class="modal_block_close">
            <button class="statement_block_btn_close">

                <svg width="90%" height="90%" viewBox="-0.5 0 25 25" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M3 21.32L21 3.32001" stroke="#777777" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M3 3.32001L21 21.32" stroke="#777777" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                </svg>

            </button>
        </div>

    </div>

<script>
    const statementFieldOpen = document.querySelector(".statement_field_open");
    const closeButton = document.querySelector(".statement_block_btn_close");


    function closeModal() {
        statementFieldOpen.classList.remove("opened");
    }

    function openModal() {

        statementFieldOpen.classList.add("opened");
    }

    closeButton.addEventListener("click", closeModal);

    statementFieldOpen.addEventListener("click", function(event) {
        if (event.target === statementFieldOpen) {
            closeModal();
        }
    });

    document.addEventListener("keydown", function(event) {
        if (event.key === "Escape" && statementFieldOpen.classList.contains("opened")) {
            closeModal();
        }
    });

    function confirmSendComplaint() {
        openModal();
    }
</script>






    <div class="main_video_content_field">

        <div class="main_video_content_scroll_lock" data-video-id="{{ $video->id }}">



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

                        <video width="320" height="240" autoplay style="object-fit:contain">
                            <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                            Ваш браузер не поддерживает видео тег.
                        </video>


                    </div>
                </div>
            </div>





        </div>


        <div class="full_video_content_scrolled">


            <div class="full_video_content_scrolled_info">


                <div class="full_video_content_scrolled_info_description">

                    <div class="main_statementuser_info">

                        <p class="txt_1">{{ $video->title }}</p>


                    </div>



                    <div class="main_video_func">
                        <div class="author">

                            @if ($video->user->avatar !== null)
                                <a href="{{ route('profile.profileuser', ['id' => $video->user_id]) }}">
                                    <img class="avatar_mini" src="{{ asset('storage/' . $video->user->avatar) }}"
                                        alt="Avatar" >
                                </a>
                            @else
                                <a href="{{ route('profile.profileuser', ['id' => $video->user_id]) }}">
                                    <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                </a>
                            @endif


                            <p class="txt_2"> <a
                                    href="{{ route('profile.profileuser', ['id' => $video->user_id, 'previous' => 'video']) }}">
                                    {{ $video->user->name }}

                                </a></p>
                        </div>





                        <div class="full_video_block_buttons">

                            @if (!$video->likes()->where('user_id', auth()->id())->exists())
                                <form method="POST" class="full_video_btn"
                                    action="{{ route('video.like', ['id' => $video->id]) }}">
                                    @csrf
                                    <button type="submit">

                                        <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" stroke="#777777">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M12 19.7501C11.8012 19.7499 11.6105 19.6708 11.47 19.5301L4.70001 12.7401C3.78387 11.8054 3.27072 10.5488 3.27072 9.24006C3.27072 7.9313 3.78387 6.6747 4.70001 5.74006C5.6283 4.81186 6.88727 4.29042 8.20001 4.29042C9.51274 4.29042 10.7717 4.81186 11.7 5.74006L12 6.00006L12.28 5.72006C12.739 5.25606 13.2857 4.88801 13.8883 4.63736C14.4909 4.3867 15.1374 4.25845 15.79 4.26006C16.442 4.25714 17.088 4.38382 17.6906 4.63274C18.2931 4.88167 18.8402 5.24786 19.3 5.71006C20.2161 6.6447 20.7293 7.9013 20.7293 9.21006C20.7293 10.5188 20.2161 11.7754 19.3 12.7101L12.53 19.5001C12.463 19.5752 12.3815 19.636 12.2904 19.679C12.1994 19.7219 12.1006 19.7461 12 19.7501ZM8.21001 5.75006C7.75584 5.74675 7.30551 5.83342 6.885 6.00505C6.4645 6.17669 6.08215 6.42989 5.76001 6.75006C5.11088 7.40221 4.74646 8.28491 4.74646 9.20506C4.74646 10.1252 5.11088 11.0079 5.76001 11.6601L12 17.9401L18.23 11.6801C18.5526 11.3578 18.8086 10.9751 18.9832 10.5538C19.1578 10.1326 19.2477 9.68107 19.2477 9.22506C19.2477 8.76905 19.1578 8.31752 18.9832 7.89627C18.8086 7.47503 18.5526 7.09233 18.23 6.77006C17.9104 6.44929 17.5299 6.1956 17.1109 6.02387C16.6919 5.85215 16.2428 5.76586 15.79 5.77006C15.3358 5.76675 14.8855 5.85342 14.465 6.02505C14.0445 6.19669 13.6621 6.44989 13.34 6.77006L12.53 7.58006C12.3869 7.71581 12.1972 7.79149 12 7.79149C11.8028 7.79149 11.6131 7.71581 11.47 7.58006L10.66 6.77006C10.3395 6.44628 9.95791 6.18939 9.53733 6.01429C9.11675 5.83919 8.66558 5.74937 8.21001 5.75006Z"
                                                    fill="#777777"></path>
                                            </g>
                                        </svg>

                                    </button>
                                </form>
                            @else
                                <form method="POST" class="full_video_btn"
                                    action="{{ route('video.unlike', ['id' => $video->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">

                                        <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M19.3 5.71002C18.841 5.24601 18.2943 4.87797 17.6917 4.62731C17.0891 4.37666 16.4426 4.2484 15.79 4.25002C15.1373 4.2484 14.4909 4.37666 13.8883 4.62731C13.2857 4.87797 12.739 5.24601 12.28 5.71002L12 6.00002L11.72 5.72001C10.7917 4.79182 9.53273 4.27037 8.22 4.27037C6.90726 4.27037 5.64829 4.79182 4.72 5.72001C3.80386 6.65466 3.29071 7.91125 3.29071 9.22002C3.29071 10.5288 3.80386 11.7854 4.72 12.72L11.49 19.51C11.6306 19.6505 11.8212 19.7294 12.02 19.7294C12.2187 19.7294 12.4094 19.6505 12.55 19.51L19.32 12.72C20.2365 11.7823 20.7479 10.5221 20.7442 9.21092C20.7405 7.89973 20.2218 6.64248 19.3 5.71002Z"
                                                    fill="#777777"></path>
                                            </g>
                                        </svg>

                                    </button>
                                </form>
                            @endif

                            <button class="full_video_btn" onclick="toggleFriendsList({{ $video->id }})">

                                <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" stroke="#777777"
                                    stroke-width="1.9200000000000004">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M12.0678 2.14611C12.3883 2.00663 12.7431 1.96564 13.0874 2.02906C13.4316 2.09244 13.7478 2.25698 13.9973 2.49935L22.459 10.7164C22.6312 10.8837 22.7672 11.0838 22.8599 11.3041C22.9525 11.5244 23 11.7609 23 11.9994C23 12.238 22.9525 12.4744 22.8599 12.6947C22.7672 12.9151 22.6309 13.1154 22.4587 13.2827L13.9972 21.4997C13.7476 21.742 13.4316 21.9064 13.0874 21.9698C12.7431 22.0332 12.3883 21.9922 12.0678 21.8528C11.7474 21.7134 11.4771 21.4826 11.2883 21.1916C11.0997 20.9008 11.0001 20.5617 11 20.2164L11 17.0208C8.70545 17.1206 7.26436 17.5717 6.17555 18.2297C4.90572 18.9971 4.01283 20.0973 2.77837 21.6278C2.5122 21.9578 2.06688 22.0841 1.66711 21.943C1.26733 21.8018 1 21.424 1 21C1 17.4414 1.5013 13.9586 3.15451 11.341C4.72577 8.85318 7.25861 7.26795 11 7.03095L11 3.78241C11.0001 3.43711 11.0997 3.09808 11.2883 2.80727C11.4771 2.51629 11.7474 2.2855 12.0678 2.14611Z"
                                            fill=""></path>
                                    </g>
                                </svg>
                            </button>


                                
                            <button class="full_video_btn" onclick="confirmSendComplaint()">



                                <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" stroke="#777777">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M5 21V3.90002C5 3.90002 5.875 3 8.5 3C11.125 3 12.875 4.8 15.5 4.8C18.125 4.8 19 3.9 19 3.9V14.7C19 14.7 18.125 15.6 15.5 15.6C12.875 15.6 11.125 13.8 8.5 13.8C5.875 13.8 5 14.7 5 14.7"
                                            stroke="#777777" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </g>
                                </svg>


                                {{-- репорт заполненный
                                    
                                    <svg fill="#777777" width="100%" height="100%" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><title>ionicons-v5-m</title><path d="M80,480a16,16,0,0,1-16-16V68.13A24,24,0,0,1,75.9,47.41C88,40.38,112.38,32,160,32c37.21,0,78.83,14.71,115.55,27.68C305.12,70.13,333.05,80,352,80a183.84,183.84,0,0,0,71-14.5,18,18,0,0,1,25,16.58V301.44a20,20,0,0,1-12,18.31c-8.71,3.81-40.51,16.25-84,16.25-24.14,0-54.38-7.14-86.39-14.71C229.63,312.79,192.43,304,160,304c-36.87,0-55.74,5.58-64,9.11V464A16,16,0,0,1,80,480Z"></path></g></svg> 
                                    
                                --}}



                            </button>
          
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


                            <script>
                                function toggleFriendsList(postId) {
                                    const friendsList = document.getElementById(`friendsList${postId}`);
                                    friendsList.style.display = friendsList.style.display === 'none' ? 'block' : 'none';
                                }
                            </script>

                        </div>



                    </div>

                    <p class="txt_2">6666666666 :Просмотров</p>

                    <p class="txt_2">{{ $video->description }}</p>

                </div>


                <form method="POST" action="{{ route('video.comment', ['id' => $video->id]) }}" class="full_video_comments_form_lock">
                    @csrf

          

                        <div class="full_video_img">

                            @if (Auth::user()->avatar !== null)
                                <img class="avatar_mini"
                                    src="{{ asset('storage/' . Auth::user()->avatar) }}"alt="Avatar">
                            @else
                                <img class="avatar_mini" src="/uploads/ProfilePhoto.png" width="50px"
                                    height="50px">
                            @endif

                        </div>

                        <input class="form_field_full_video" name="comment" placeholder="Введите комментарий...">

                        <button class="full_video_btn_send">
                            <svg width="100%" height="100%" viewBox="-2.4 -2.4 28.80 28.80" fill="none"
                                xmlns="http://www.w3.org/2000/svg" transform="rotate(0)">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                    stroke="#CCCCCC" stroke-width="0.048"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M10.3009 13.6949L20.102 3.89742M10.5795 14.1355L12.8019 18.5804C13.339 19.6545 13.6075 20.1916 13.9458 20.3356C14.2394 20.4606 14.575 20.4379 14.8492 20.2747C15.1651 20.0866 15.3591 19.5183 15.7472 18.3818L19.9463 6.08434C20.2845 5.09409 20.4535 4.59896 20.3378 4.27142C20.2371 3.98648 20.013 3.76234 19.7281 3.66167C19.4005 3.54595 18.9054 3.71502 17.9151 4.05315L5.61763 8.2523C4.48114 8.64037 3.91289 8.83441 3.72478 9.15032C3.56153 9.42447 3.53891 9.76007 3.66389 10.0536C3.80791 10.3919 4.34498 10.6605 5.41912 11.1975L9.86397 13.42C10.041 13.5085 10.1295 13.5527 10.2061 13.6118C10.2742 13.6643 10.3352 13.7253 10.3876 13.7933C10.4468 13.87 10.491 13.9585 10.5795 14.1355Z"
                                        stroke="#777777" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </button>

              
                </form>


                <div class="full_video_comments">

                    @foreach ($video->comments as $comment)
                        <div class="statementuser_comment_show">

                            <div class="main_novost_top">
                                <a
                                    href="{{ route('profile.profileuser', ['id' => $comment->user_id, 'previous' => 'video']) }}">
                                    <div class="main_novost_img">

                                        <img class="avatar" src="{{ asset('storage/' . $comment->user->avatar) }}"
                                            alt="Avatar">

                                    </div>
                                </a>


                                <div class="main_novost_title">
                                    <div>
                                        <a href="{{ route('profile.profileuser', ['id' => $comment->user_id, 'previous' => 'video']) }}">
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






            </div>

            <div class="full_video_content_scrolled_trendvideo">

                @foreach ($trendvideos as $trendvideo)
                    <div class="full_video_content_scrolled_trendvideo_block">
                        <a href="{{ route('videouser', ['id' => $trendvideo->id]) }}" style="display: flex;">



                            <div class="full_video_content_scrolled_trendvideo_block_left">

                                <img src="{{ asset('storage/' . $trendvideo->thumbnail_path) }}" alt="thumbnail">

                            </div>

                            <div class="full_video_content_scrolled_trendvideo_block_right">

                                <div class="full_video_content_scrolled_trendvideo_block_right_title">

                                    <p>{{ $trendvideo->title }}</p>

                                </div>

                                <div class="full_video_content_scrolled_trendvideo_block_right_info">

                                    <div class="full_video_content_scrolled_trendvideo_block_right_info_username">



                                        {{ $trendvideo->user->name }}



                                    </div>

                                    <div class="full_video_content_scrolled_trendvideo_block_right_info_stats">

                                        <div
                                            class="full_video_content_scrolled_trendvideo_block_right_info_stats_views">

                                            <p>535 VIEWS</p>

                                        </div>

                                        <div
                                            class="full_video_content_scrolled_trendvideo_block_right_info_stats_created">

                                            @if (!function_exists('pluralForm'))
                                                @php
                                                    function pluralForm($number, $one, $two, $five)
                                                    {
                                                        $number = abs($number) % 100;
                                                        $remainder = $number % 10;

                                                        if ($number > 10 && $number < 20) {
                                                            return $five;
                                                        }

                                                        if ($remainder > 1 && $remainder < 5) {
                                                            return $two;
                                                        }

                                                        if ($remainder == 1) {
                                                            return $one;
                                                        }

                                                        return $five;
                                                    }
                                                @endphp
                                            @endif

                                            @php
                                                $createdAt = strtotime($trendvideo->created_at);
                                                $currentDate = strtotime(date('Y-m-d H:i:s'));
                                                $timeDiff = $currentDate - $createdAt;

                                                if ($timeDiff >= 86400) {
                                                    $days = floor($timeDiff / 86400);
                                                    $formattedTime =
                                                        $days .
                                                        ' ' .
                                                        pluralForm($days, 'день', 'дня', 'дней') .
                                                        ' назад';
                                                } elseif ($timeDiff >= 3600) {
                                                    $hours = floor($timeDiff / 3600);
                                                    $formattedTime =
                                                        $hours .
                                                        ' ' .
                                                        pluralForm($hours, 'час', 'часа', 'часов') .
                                                        ' назад';
                                                } elseif ($timeDiff >= 60) {
                                                    $minutes = floor($timeDiff / 60);
                                                    $formattedTime =
                                                        $minutes .
                                                        ' ' .
                                                        pluralForm($minutes, 'минута', 'минуты', 'минут') .
                                                        ' назад';
                                                } else {
                                                    $formattedTime = 'только что';
                                                }
                                            @endphp

                                            <p>{{ $formattedTime }}</p>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>


    <script>
        function toggleTheaterAndFullScreen() {
            const shortVideoRamaScroll = document.querySelector(".main_video_content_field");
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
            const shortVideoRamaScroll = document.querySelector(".main_video_content_field");

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
                    const activeVideo = document.querySelector(
                        ".main_video_content_scroll_lock.active video");
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
                        const activeVideo = document.querySelector(
                            ".main_video_content_scroll_lock.active video");

                        switch (event.keyCode) {

                            case 37: // Стрелка влево
                                if (activeVideo && activeVideo.currentTime >= 1) {
                                    activeVideo.currentTime -= 1;
                                }
                                break;
                            case 39: // Стрелка вправо
                                const rightActiveVideo = document.querySelector(
                                    ".main_video_content_scroll_lock.active video");
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

            // function handleIntersection(entries, observer) {
            //     entries.forEach(entry => {
            //         const video = entry.target;
            //         const shortVideoRama = video.closest('.main_video_content_scroll_lock');
            //         if (shortVideoRama) {
            //             if (entry.isIntersecting) {
            //                 video.play();
            //                 shortVideoRama.classList.add('active');
            //                 const videoId = shortVideoRama.dataset.videoId;
            //                 updateAddressBar(videoId);
            //             } else {
            //                 video.pause();
            //                 shortVideoRama.classList.remove('active');
            //             }
            //         }
            //     });
            // }

            const observer = new IntersectionObserver(handleIntersection, options);

            videos.forEach(video => {
                observer.observe(video);
            });
        });
    </script>

</x-app-layout>
