<x-app-layout>
    <x-slot name="header">

    </x-slot>



  @include('general.partials.complaint-modal-reason', ['video' => $video])






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
                                    @include('general.elements.video-control.svg-play-pause')

                                </button>

                                <div class="duration-container">
                                    <div class="current-time">0:00</div>
                                    /
                                    <div class="total-time"></div>
                                </div>


                                <div class="volume-container">


                        @include('general.elements.video-control.svg-volume')
                        
                                </div>

                                <button class="speed-btn wide-btn" data-video-id="{{ $video->id }}">
                                    1x
                                </button>

                                <button class="full-screen-btn">

                        @include('general.elements.video-control.svg-fullscreen')

                        @include('general.elements.video-control.svg-fullscreen-close')

                                </button>


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

                    <div style="display: flex; justify-content:space-between;" class="main_statementuser_info">

                        <p class="txt_1">{{ $video->title }} </p>

                        <div style="width: 5%;" class="statement_block_top_info_right">

                    
                            <div class="statement_block_top_info_right_info">
                                                            <div>
                                        <svg class="like-icon" width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#777777">
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
        <g id="SVGRepo_iconCarrier">
            <path d="M12 19.7501C11.8012 19.7499 11.6105 19.6708 11.47 19.5301L4.70001 12.7401C3.78387 11.8054 3.27072 10.5488 3.27072 9.24006C3.27072 7.9313 3.78387 6.6747 4.70001 5.74006C5.6283 4.81186 6.88727 4.29042 8.20001 4.29042C9.51274 4.29042 10.7717 4.81186 11.7 5.74006L12 6.00006L12.28 5.72006C12.739 5.25606 13.2857 4.88801 13.8883 4.63736C14.4909 4.3867 15.1374 4.25845 15.79 4.26006C16.442 4.25714 17.088 4.38382 17.6906 4.63274C18.2931 4.88167 18.8402 5.24786 19.3 5.71006C20.2161 6.6447 20.7293 7.9013 20.7293 9.21006C20.7293 10.5188 20.2161 11.7754 19.3 12.7101L12.53 19.5001C12.463 19.5752 12.3815 19.636 12.2904 19.679C12.1994 19.7219 12.1006 19.7461 12 19.7501ZM8.21001 5.75006C7.75584 5.74675 7.30551 5.83342 6.885 6.00505C6.4645 6.17669 6.08215 6.42989 5.76001 6.75006C5.11088 7.40221 4.74646 8.28491 4.74646 9.20506C4.74646 10.1252 5.11088 11.0079 5.76001 11.6601L12 17.9401L18.23 11.6801C18.5526 11.3578 18.8086 10.9751 18.9832 10.5538C19.1578 10.1326 19.2477 9.68107 19.2477 9.22506C19.2477 8.76905 19.1578 8.31752 18.9832 7.89627C18.8086 7.47503 18.5526 7.09233 18.23 6.77006C17.9104 6.44929 17.5299 6.1956 17.1109 6.02387C16.6919 5.85215 16.2428 5.76586 15.79 5.77006C15.3358 5.76675 14.8855 5.85342 14.465 6.02505C14.0445 6.19669 13.6621 6.44989 13.34 6.77006L12.53 7.58006C12.3869 7.71581 12.1972 7.79149 12 7.79149C11.8028 7.79149 11.6131 7.71581 11.47 7.58006L10.66 6.77006C10.3395 6.44628 9.95791 6.18939 9.53733 6.01429C9.11675 5.83919 8.66558 5.74937 8.21001 5.75006Z" fill="#777777"></path>
        </g>
        </svg>                            </div>
                                    <div>{{ $video->likes_count }}</div>
                                                    </div>
        
        
                            
                            <div class="statement_block_top_info_right_info">
                                <div>
                                    <svg width="100%" height="100%" viewBox="-0.96 -0.96 33.92 33.92" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#777777" stroke="#777777">
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
        <g id="SVGRepo_iconCarrier">
            <title>comment-2</title>
            <desc>Created with Sketch Beta.</desc>
            <defs> </defs>
            <g id="Page-1" stroke-width="0.8" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-152.000000, -255.000000)" fill="#777777">
                    <path d="M168,281 C166.832,281 165.704,280.864 164.62,280.633 L159.912,283.463 L159.975,278.824 C156.366,276.654 154,273.066 154,269 C154,262.373 160.268,257 168,257 C175.732,257 182,262.373 182,269 C182,275.628 175.732,281 168,281 L168,281 Z M168,255 C159.164,255 152,261.269 152,269 C152,273.419 154.345,277.354 158,279.919 L158,287 L165.009,282.747 C165.979,282.907 166.977,283 168,283 C176.836,283 184,276.732 184,269 C184,261.269 176.836,255 168,255 L168,255 Z M175,266 L161,266 C160.448,266 160,266.448 160,267 C160,267.553 160.448,268 161,268 L175,268 C175.552,268 176,267.553 176,267 C176,266.448 175.552,266 175,266 L175,266 Z M173,272 L163,272 C162.448,272 162,272.447 162,273 C162,273.553 162.448,274 163,274 L173,274 C173.552,274 174,273.553 174,273 C174,272.447 173.552,272 173,272 L173,272 Z" id="comment-2" sketch:type="MSShapeGroup"> </path>
                </g>
            </g>
        </g>
        </svg>                        </div>
                                <span>{{ $video->comments_count }}</span>
                            </div>
        
        
                            
                            <div class="statement_block_top_info_right_info">
                                <div>
                                    <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
        <g id="SVGRepo_iconCarrier">
            <path d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#777777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#777777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </g>
        </svg>                        </div>
                                <span>
                                    {{ $video->views_count }}
                                </span>
                            </div>
        
                        </div>
                    </div>



                    <div class="main_video_func">
                        <div class="author">

                            @if ($video->user->avatar !== null)
                                <a href="{{ route('profile.profileuser', ['id' => $video->user_id]) }}">
                                    <img class="avatar_mini" src="{{ asset('storage/' . $video->user->avatar) }}"
                                        alt="Avatar">
                                </a>
                            @else
                                <a href="{{ route('profile.profileuser', ['id' => $video->user_id]) }}">
                                    <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                </a>
                            @endif


                            <p class="txt_2"> <a
                                    href="{{ route('profile.profileuser', ['id' => $video->user_id, 'previous' => 'video']) }}">
                                    {{ $video->user->name }}

                                </a>
                            
                            
                            </p>
                            
                        </div>





                        <div class="full_video_block_buttons">
                            
                            @if (!$video->likes()->where('user_id', auth()->id())->exists())

                            {{-- like --}}

                                <div class="mini_button">
                                    <button type="submit" class="like-button" data-id="{{ $video->id }}">

                                        @include('general.elements.svg-like')

                                    </button>
                                </div>

                            @else

                                {{-- REMOVE LIKE --}}

                                <div class="mini_button">
                                    <button type="submit" class="unlike-button" data-id="{{ $video->id }}">

                                        @include('general.elements.svg-unlike')
                                        

                                    </button>
                                </div>

                            @endif



                  

                            <script>
                                $(document).ready(function() {
                                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                    $('.like-button, .unlike-button').click(function(e) {
                                        e.preventDefault();
                                        var videoId = $(this).data('id');
                                        var $button = $(this);

                                        var isLiked = $button.hasClass('unlike-button');

                                        var requestType = isLiked ? 'DELETE' : 'POST';

                                        var url = isLiked ? '/video/' + videoId + '/unlike' : '/video/' + videoId + '/like';

                                        $.ajax({
                                            type: requestType,
                                            url: url,
                                            headers: {
                                                'X-CSRF-TOKEN': csrfToken
                                            },
                                            success: function(response) {
                                                console.log(response);

                                                $button.toggleClass('like-button unlike-button');

                                                var svgIcon = isLiked ?
                                                    '<svg class="like-icon" width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#777777"> <g id="SVGRepo_bgCarrier" stroke-width="0"></g> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g> <g id="SVGRepo_iconCarrier"> <path d="M12 19.7501C11.8012 19.7499 11.6105 19.6708 11.47 19.5301L4.70001 12.7401C3.78387 11.8054 3.27072 10.5488 3.27072 9.24006C3.27072 7.9313 3.78387 6.6747 4.70001 5.74006C5.6283 4.81186 6.88727 4.29042 8.20001 4.29042C9.51274 4.29042 10.7717 4.81186 11.7 5.74006L12 6.00006L12.28 5.72006C12.739 5.25606 13.2857 4.88801 13.8883 4.63736C14.4909 4.3867 15.1374 4.25845 15.79 4.26006C16.442 4.25714 17.088 4.38382 17.6906 4.63274C18.2931 4.88167 18.8402 5.24786 19.3 5.71006C20.2161 6.6447 20.7293 7.9013 20.7293 9.21006C20.7293 10.5188 20.2161 11.7754 19.3 12.7101L12.53 19.5001C12.463 19.5752 12.3815 19.636 12.2904 19.679C12.1994 19.7219 12.1006 19.7461 12 19.7501ZM8.21001 5.75006C7.75584 5.74675 7.30551 5.83342 6.885 6.00505C6.4645 6.17669 6.08215 6.42989 5.76001 6.75006C5.11088 7.40221 4.74646 8.28491 4.74646 9.20506C4.74646 10.1252 5.11088 11.0079 5.76001 11.6601L12 17.9401L18.23 11.6801C18.5526 11.3578 18.8086 10.9751 18.9832 10.5538C19.1578 10.1326 19.2477 9.68107 19.2477 9.22506C19.2477 8.76905 19.1578 8.31752 18.9832 7.89627C18.8086 7.47503 18.5526 7.09233 18.23 6.77006C17.9104 6.44929 17.5299 6.1956 17.1109 6.02387C16.6919 5.85215 16.2428 5.76586 15.79 5.77006C15.3358 5.76675 14.8855 5.85342 14.465 6.02505C14.0445 6.19669 13.6621 6.44989 13.34 6.77006L12.53 7.58006C12.3869 7.71581 12.1972 7.79149 12 7.79149C11.8028 7.79149 11.6131 7.71581 11.47 7.58006L10.66 6.77006C10.3395 6.44628 9.95791 6.18939 9.53733 6.01429C9.11675 5.83919 8.66558 5.74937 8.21001 5.75006Z" fill="#777777"></path> </g> </svg>' :
                                                    '<svg class="unlike-icon" width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <g id="SVGRepo_bgCarrier" stroke-width="0"></g> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g> <g id="SVGRepo_iconCarrier"> <path d="M19.3 5.71002C18.841 5.24601 18.2943 4.87797 17.6917 4.62731C17.0891 4.37666 16.4426 4.2484 15.79 4.25002C15.1373 4.2484 14.4909 4.37666 13.8883 4.62731C13.2857 4.87797 12.739 5.24601 12.28 5.71002L12 6.00002L11.72 5.72001C10.7917 4.79182 9.53273 4.27037 8.22 4.27037C6.90726 4.27037 5.64829 4.79182 4.72 5.72001C3.80386 6.65466 3.29071 7.91125 3.29071 9.22002C3.29071 10.5288 3.80386 11.7854 4.72 12.72L11.49 19.51C11.6306 19.6505 11.8212 19.7294 12.02 19.7294C12.2187 19.7294 12.4094 19.6505 12.55 19.51L19.32 12.72C20.2365 11.7823 20.7479 10.5221 20.7442 9.21092C20.7405 7.89973 20.2218 6.64248 19.3 5.71002Z" fill="#777777"></path> </g> </svg>';
                                                $button.html(svgIcon);

                                            },
                                            error: function(xhr, status, error) {
                                                console.error(xhr.responseText);
                                            }
                                        });
                                    });
                                });
                            </script>

@livewire('repost-component', ['videoId' => $video->id])



@php
    $hasComplaint = auth()->check() && \App\Models\Complaint::hasComplaintVideo($video->id, auth()->id());
@endphp

@if ($hasComplaint)
    <button class="mini_button" disabled>
        @include('general.elements.svg-complained')
    </button>
@else
    <button class="mini_button" onclick="confirmSendComplaint()">
        @include('general.elements.svg-complaint')
    </button>
@endif






                        </div>



                    </div>



       


                    <p class="txt_2">Описание</p>
                    <p class="txt_2">{{ $video->description }}</p>

                </div>

                <form id="commentForm" data-route="{{ route('video.comment', ['id' => $video->id]) }}" class="full_video_comments_form_lock">
                    @csrf



                    <div class="full_video_img">
                        @if (Auth::user()->avatar !== null)
                            <img class="avatar_mini" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar">
                        @else
                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png" width="50px" height="50px">
                        @endif
                    </div>

                    <input id="commentInput" class="form_field_full_video" name="comment" placeholder="Введите комментарий..." required>

                    <button id="submitComment" class="mini_button" style="padding: 0%">
                        @include('general.elements.svg-send')
                    </button>


                </form>


                <div id="commentsContainer" class="full_video_comments">

                    @foreach ($video->comments as $comment)
                        <div class="statementuser_comment_show">

                            <div class="main_novost_top">
                                <a
                                    href="{{ route('profile.profileuser', ['id' => $comment->user_id]) }}">
                         

                                            @if ($comment->user->avatar !== null)
                                            <img src="{{ asset('storage/' . $comment->user->avatar) }}"
                                                alt="Avatar" class="avatar_mini">
                                        @else
                                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png"
                                                alt="Avatar">
                                        @endif

                               
                                </a>


                                <div class="main_novost_title">
                                    <div>
                                        <a
                                            href="{{ route('profile.profileuser', ['id' => $comment->user_id]) }}">
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



                            @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Manager')
                                <form method="POST"
                                    action="{{ route('admin.video.comment.delete', ['videoId' => $video->id, 'commentId' => $comment->id]) }}">
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

                                            <p>{{ $trendvideo->views_count }} просмотровㅤ</p>

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


    @vite('resources/js/control-panel/for-videouser.js')

    <script>
        $(document).ready(function() {
            $('#commentForm').submit(function(event) {
                event.preventDefault();
    
                let commentContent = $('input[name="comment"]').val();
                let token = $('input[name="_token"]').val();
    
                $.ajax({
                    url: "{{ route('video.comment', ['id' => $video->id]) }}",
                    method: 'POST',
                    data: {
                        _token: token,
                        comment: commentContent
                    },
                    success: function(response) {
    
                        let deleteForm = '';
                        if (response.user_role === 'Admin' || response.user_role === 'Manager') {
                            deleteForm = `
                                <form method="POST" action="/video/${response.video_id}/comment/${response.comment_id}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="novost_down_func" type="submit">Удалить комментарий</button>
                                </form>
                            `;
                        }
                        $('.full_video_comments').append(`
                            <div class="statementuser_comment_show">
                                <div class="main_novost_top">
                                    <a href="/profileuser/${response.user_id}">
                                        <div class="main_novost_img">
                                            <img class="avatar_mini" src="${response.user_avatar}" alt="Avatar">
                                        </div>
                                    </a>
                                    <div class="main_novost_title">
                                        <div>
                                            <a href="/profileuser/${response.user_id}">
                                                <p class="txt_2">${response.user_name}</p>
                                            </a>
                                        </div>
                                        <div>
                                            <p class="txt_2">${response.created_at}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="main_comment_show">
                                    <p class="txt_2">${response.comment}</p>
                                </div>
                                ${deleteForm}
                            </div>
                        `);
    
                        $('input[name="comment"]').val('');
    
                        var commentsContainer = $('.full_statement_content_comments');
                        commentsContainer.scrollTop(commentsContainer.prop("scrollHeight"));
                    },
                    error: function(response) {
                        alert('Ошибка при отправке комментария.');
                    }
                });
            });
        });
    </script>
    

</x-app-layout>
