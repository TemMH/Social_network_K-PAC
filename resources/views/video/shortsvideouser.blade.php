<x-app-layout>
    <x-slot name="header">
    </x-slot>


    

    <div class="shortvideo_rama_scroll">

        @forelse ($videos as $video)



        
            <div class="shortvideo_rama" data-video-id="{{ $video->id }}">

                <div class="main_shortvideo_content1">

                    <div class="main_shortvideo_desc_left">

                        <div class="main_shortvideo_func">



                            <div class="d-flex">
                                @if ($video->user->avatar !== null)
                                    <img class="avatar_mini" src="{{ asset('storage/' . $video->user->avatar) }}"
                                        alt="Avatar">
                                @else
                                    <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                @endif

                                <p class="txt_2"> <a
                                        href="{{ route('profile.profileuser', ['id' => $video->user_id, 'previous' => 'video']) }}">
                                        {{ $video->user->name }}

                                    </a></p>
                            </div>

                            

                            {{-- REQUEST FRIEND --}}

                            @if ($video->user->id !== auth()->id() && !auth()->user()->areFriends($video->user->id) && !auth()->user()->arePending($video->user->id) && !auth()->user()->areSubscriber($video->user->id))
                                <form method="POST" class="mini_button"
                                    action="{{ route('send-friend-request', $video->user) }}">
                                    @csrf


                                    <button type="submit">

                                        @include('general.elements.profile.svg-request-friend')


                                    </button>

                                </form>
                            @endif

                            {{-- like --}}

                            @if (!$video->likes()->where('user_id', auth()->id())->exists())
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



                            @livewire('repost-component', ['videoId' => $video->id])



                            {{-- COMPLAINT --}}


                            @php
    $hasComplaint = auth()->check() && \App\Models\Complaint::hasComplaintVideo($video->id, auth()->id());
@endphp

@if ($hasComplaint)
    <button class="mini_button" disabled>
        @include('general.elements.svg-complained')
    </button>
@else
    <button class="mini_button" onclick="confirmSendComplaint({{ $video->id }})">
        @include('general.elements.svg-complaint')
    </button>
@endif



                        </div>

                        <div class="main_statementuser_info">

                            <p class="txt_1">{{ $video->title }}</p>
                            {{-- ОПИСАНИЕ РОЛИКА ШРИФТ МЕНЬШЕ + ДОБАВИТЬ ТЁМНЫЙ ФОН --}}
                        </div>

                    </div>


                    <div class="main_shortvideo_right">

                        <button class="shortvideo_toggleComments">Показать комментарии</button>


                        <div class="main_shortvideo_desc_right">
                            <div id="comments-section-{{ $video->id }}" class="shortvideo_comments">
                                @foreach ($video->comments as $comment)

                                    <div class="statementuser_comment_show_shortvideo">

                                        <div class="main_novost_top">
                                            <a href="{{ route('profile.profileuser', ['id' => $comment->user_id]) }}">
                                                <div class="main_novost_img">

                                                    @if ($comment->user->avatar !== null)
                                                        <img src="{{ asset('storage/' . $comment->user->avatar) }}"
                                                            alt="Avatar" class="avatar_mini">
                                                    @else
                                                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png"
                                                            alt="Avatar">
                                                    @endif
                                                </div>
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
                                                <button class="novost_down_func" type="submit">Удалить
                                                    комментарий</button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <form method="POST" class="shortvideo_form_comment" id="comment-form-{{ $video->id }}" data-video-id="{{ $video->id }}" action="{{ route('video.comment', ['id' => $video->id]) }}">
                                @csrf
                                <textarea class="form_field_comment_shortvideo" name="comment" id="comment-input-{{ $video->id }}"></textarea>
                                <div class="submit_comment">
                                    <button type="submit" class="txt_2 submit-comment-btn" data-video-id="{{ $video->id }}">Отправить</button>
                                </div>
                            </form>
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

                                        <button class="theater-btn">

                                            @include('general.elements.video-control.svg-theater')
                                            
                                        </button>

                                    </div>
                                </div>

                                <video loop width="320" height="240" autoplay style="object-fit:contain; border-radius:12px;">
                                    <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                                    Ваш браузер не поддерживает видео тег.
                                </video>


                            </div>
                        </div>
                    </div>


                </div>
            </div>
            @include('general.partials.complaint-modal-for-shortvideo-reason')

        @empty

            <div style="justify-content: center; margin: 0 auto; height: 100%;" class="friendfeed_field_frame">

<div style="text-align: center; max-width: 800px; margin: 0 auto; padding:1%;" class="friendfeed_content">

    <p style="margin:20px 0;"  class="txt_2">Вы посмотрели все короткие видео, заходите позже или перейдите на просмотренные</p>
            <button onclick="location.href='{{ route('all.shortsvideo.user.viewed') }}';" class="long_button">Просмотренные короткие видеоматерилы</button>

</div>
</div>


        @endforelse

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
    $(document).ready(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        

        $('.like-button, .unlike-button').click(function(e) {
    e.preventDefault();
    var $button = $(this);
    var videoId = $button.closest('.shortvideo_rama').data('video-id');

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

<script>
    $(document).ready(function() {
        $('.shortvideo_form_comment').submit(function(event) {
    event.preventDefault();

    let commentForm = $(this);
    let commentContent = commentForm.find('.form_field_comment_shortvideo').val();
    let token = commentForm.find('input[name="_token"]').val();
    let videoId = commentForm.data('video-id');


            console.log("Video ID:", videoId);


            $.ajax({
                url: "/video/" + videoId + "/comment",
                method: 'POST',
                data: {
                    _token: token,
                    comment: commentContent,
                    video_id: videoId
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
                    $('#comments-section-' + videoId).append(`
                        <div class="statementuser_comment_show_shortvideo">
                            <div class="main_novost_top">
                                <a href="{{ route('profile.profileuser', ['id' => auth()->id()]) }}">
                                    <div class="main_novost_img">
                                        <img class="avatar_mini" src="${response.user_avatar}" alt="Avatar">
                                    </div>
                                </a>
                                <div class="main_novost_title">
                                    <div>
                                        <a href="{{ route('profile.profileuser', ['id' => auth()->id()]) }}">
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

                    commentForm.find('.form_field_comment_shortvideo').val('');

                    var commentsContainer = commentForm.closest('.main_shortvideo_desc_right').find('.shortvideo_comments');
                    commentsContainer.scrollTop(commentsContainer.prop("scrollHeight"));
                },
                error: function(response) {
                    alert('Ошибка при отправке комментария.');
                }
            });
        });
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.statement_field_open').forEach(modal => {
        const closeButton = modal.querySelector(".statement_block_btn_close");

        if (modal && closeButton) {
            function closeModal() {
                modal.classList.remove("opened");
            }

            closeButton.addEventListener("click", closeModal);

            modal.addEventListener("click", function(event) {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener("keydown", function(event) {
                if (event.key === "Escape" && modal.classList.contains("opened")) {
                    closeModal();
                }
            });

            fetch('{{ route('reasons') }}')
                .then(response => response.json())
                .then(data => {
                    const reasonsContainer = modal.querySelector('.radio-group');
                    reasonsContainer.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(reason => {
                            if (reason.id !== 1) {
                                const label = document.createElement('label');
                                label.className = 'radio-label';
                                
                                const input = document.createElement('input');
                                input.type = 'radio';
                                input.name = 'reason';
                                input.value = reason.id;
                                input.required = true;
                                input.addEventListener('change', toggleSubmitButton);
                                
                                const span = document.createElement('span');
                                span.className = 'inner-label';
                                span.textContent = reason.name;
            
                                label.appendChild(input);
                                label.appendChild(span);
                                reasonsContainer.appendChild(label);
                            }
                        });
                    } else {
                        reasonsContainer.innerHTML = '<p>Причины не созданы</p>';
                    }
                })
                .catch(error => console.error('Ошибка получения причин:', error));
            
            function toggleSubmitButton() {
                const submitButton = modal.querySelector('.statements_categories_btn');
                const reasonSelected = modal.querySelector('input[name="reason"]:checked');
                if (reasonSelected) {
                    submitButton.style.display = 'block';
                } else {
                    submitButton.style.display = 'none';
                }
            }
        } else {
            console.error('Не удалось найти классы');
        }
    });
});

function confirmSendComplaint(videoId) {
    const modal = document.getElementById(`complaint-modal-${videoId}`);
    if (modal) {
        modal.classList.add("opened");
    } else {
        console.error(`Не удалось найти модальное окно для видео ${videoId}`);
    }
}

    </script>


@vite('resources/js/control-panel/for-shortvideouser.js')





    

</x-app-layout>
