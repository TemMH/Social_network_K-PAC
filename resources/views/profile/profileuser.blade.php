<x-app-layout>
    <x-slot name="header">

    </x-slot>

    @include('general.partials.complaint-modal-reason', ['user' => $user])


    @foreach ($users as $user)
        <div class="profileuser_field">

            <div class="profileuser_block">

                <div class="profileuser_block_header">

                    <div class="profileuser_block_header_cover"></div>

                    <div class="profileuser_block_header_info">

                        <div class="profileuser_block_header_info_avatar">

                            <div class="profileuser_block_header_info_avatar_frame">

                                @if ($user->avatar !== null)
                                    @if ($user->id == auth()->id())
                                        <form method="POST" action="{{ route('avatar.update') }}"
                                            class="profileuser_avatar_my" enctype="multipart/form-data">
                                            @csrf

                                            <label for="avatarInput" class="avatar-label">
                                                <input id="avatarInput" class="txt_2" type="file" name="avatar"
                                                    accept="image/*" style="display: none;">
                                                <img class="profileuser_avatar_my"
                                                    src="{{ asset('storage/' . $user->avatar) }}" id="avatarPreview">
                                            </label>

                                            <button class="txt_2" type="submit" id="submitBtn"
                                                style="display: none;">Изменить аватар</button>
                                            <button class="txt_2" type="button" id="cancelBtn"
                                                style="display: none;">Отменить</button>
                                        </form>
                                    @else
                                        <img class="profileuser_avatar" src="{{ asset('storage/' . $user->avatar) }}"
                                            id="avatarPreview">
                                    @endif
                                @else
                                    @if ($user->id == auth()->id())
                                        <form method="POST" action="{{ route('avatar.update') }}"
                                            class="profileuser_avatar_my" enctype="multipart/form-data">
                                            @csrf

                                            <label for="avatarInput" class="avatar-label">
                                                <input id="avatarInput" class="txt_2" type="file" name="avatar"
                                                    accept="image/*" style="display: none;">
                                                <img class="profileuser_avatar_my" src="/uploads/ProfilePhoto.png"
                                                    id="avatarPreview">
                                            </label>

                                            <button class="txt_2" type="submit" id="submitBtn"
                                                style="display: none;">Изменить аватар</button>
                                            <button class="txt_2" type="button" id="cancelBtn"
                                                style="display: none;">Отменить</button>
                                        </form>
                                    @else
                                        <img class="profileuser_avatar" src="/uploads/ProfilePhoto.png"
                                            id="avatarPreview">
                                    @endif
                                @endif

                            </div>

                        </div>

                        <div class="profile_block_header">
                            <div class="profileuser_block_info_info_left">

                                <div class="profileuser_block_header_info_left_name">
                                    <p>{{ $user->name }}</p>
                                </div>

                                <div class="profileuser_block_header_info_left_condition">
                                    <p>{{ $user->condition }}</p>
                                </div>

                            </div>


                            <div class="profileuser_block_header_info_right">

                                {{-- MESSENGER --}}

                                @if (
                                    $user->id != auth()->id() &&
                                        auth()->user()->areFriends($user->id))
                                    <button class="mini_button" title="Открыть диалог">
                                        <a href="{{ route('messenger.chat', $user->id) }}"
                                            class="message">



                                            <svg width="100%" height="100%" viewBox="-2.4 -2.4 28.80 28.80"
                                                fill="none" xmlns="http://www.w3.org/2000/svg"
                                                transform="rotate(0)">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.048">
                                                </g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M10.3009 13.6949L20.102 3.89742M10.5795 14.1355L12.8019 18.5804C13.339 19.6545 13.6075 20.1916 13.9458 20.3356C14.2394 20.4606 14.575 20.4379 14.8492 20.2747C15.1651 20.0866 15.3591 19.5183 15.7472 18.3818L19.9463 6.08434C20.2845 5.09409 20.4535 4.59896 20.3378 4.27142C20.2371 3.98648 20.013 3.76234 19.7281 3.66167C19.4005 3.54595 18.9054 3.71502 17.9151 4.05315L5.61763 8.2523C4.48114 8.64037 3.91289 8.83441 3.72478 9.15032C3.56153 9.42447 3.53891 9.76007 3.66389 10.0536C3.80791 10.3919 4.34498 10.6605 5.41912 11.1975L9.86397 13.42C10.041 13.5085 10.1295 13.5527 10.2061 13.6118C10.2742 13.6643 10.3352 13.7253 10.3876 13.7933C10.4468 13.87 10.491 13.9585 10.5795 14.1355Z"
                                                        stroke="#777777" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </g>
                                            </svg>



                                        </a>
                                    </button>
                                @endif

{{-- REQUEST FRIEND --}}
@if ($user->id !== auth()->id() && !auth()->user()->areFriends($user->id) && !auth()->user()->arePending($user->id) && !auth()->user()->areSubscriber($user->id))
    <form method="POST" class="mini_button" action="{{ route('send-friend-request', $user) }}" title="Добавить в друзья">
        @csrf
        <button type="submit">
            @include('general.elements.profile.svg-request-friend')
        </button>
    </form>
@endif

{{-- ACCEPT FRIEND REQUEST --}}
@if ($user->id !== auth()->id() && auth()->user()->arePending($user->id) && $user->isRequesting(auth()->id()))
    <form method="POST" class="mini_button" action="{{ route('accept-friend-request', $user) }}" title="Принять в друзья">
        @csrf
        <button type="submit">
            @include('general.elements.profile.svg-request-friend')

        </button>
    </form>

    <form method="POST" class="mini_button" action="{{ route('reject-friend-request', $user) }}" title="Отказаться от дружбы">
        @csrf
        <button type="submit">
            @include('general.elements.profile.svg-remove-friend')
        </button>
    </form>
@endif

{{-- REMOVE FRIEND --}}
@if ($user->id !== auth()->id() && auth()->user()->areFriends($user->id))
    <button class="mini_button" type="button" onclick="confirmRemoveFriend()" title="Удалить из друзей">
        <form id="removeFriendForm" method="POST" action="{{ route('friend.remove', $user) }}">
            @csrf
            @method('DELETE')
            @include('general.elements.profile.svg-remove-friend')
        </form>
    </button>
@endif

{{-- REMOVE REQUEST FRIEND --}}
@if ($user->id !== auth()->id() && auth()->user()->arePending($user->id) && !$user->isRequesting(auth()->id()))
    <form id="unsubscribeForm" method="POST" action="{{ route('friend.remove', $user) }}" class="mini_button">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="confirmUnsubscribe()" title="Отменить запрос в друзья">
            @include('general.elements.profile.svg-remove-friend')
        </button>
    </form>
@endif

{{-- REMOVE SUBSCRIBER --}}
@if ($user->id !== auth()->id() && auth()->user()->isSender($user->id))
    <form id="unsubscribeForm" method="POST" action="{{ route('friend.remove', $user) }}" class="mini_button">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="confirmUnsubscribe()" title="Отписаться">
            @include('general.elements.profile.svg-remove-friend')
        </button>
    </form>
@endif


{{-- ADD SUBSCRIBER --}}
@if ($user->id !== auth()->id() && auth()->user()->isRecipient($user->id) )


<form method="POST" class="mini_button" action="{{ route('accept-friend-request', $user) }}" title="Принять в друзья">
    @csrf
    <button type="submit">
        @include('general.elements.profile.svg-request-friend')
    </button>
</form>

@endif



                                <script>
function confirmRemoveFriend() {
    if (confirm('Вы уверены, что хотите удалить этого пользователя из друзей?')) {
        document.getElementById('removeFriendForm').submit();
    }
}

function confirmUnsubscribe() {
    if (confirm('Вы уверены, что хотите отписаться от этого пользователя?')) {
        document.getElementById('unsubscribeForm').submit();
    }
}

                                </script>




                                {{-- REPORT --}}


                                @if ($user->id !== auth()->id())
                                    @if (!$user->complaints->contains('status', 'block') && !$user->complaints->contains('status', 'unblock'))
                                        <button onclick="confirmSendComplaint()" class="mini_button" title="Отправить жалобу"> 
                                        @include('general.elements.svg-complaint')
                                        </button>
                                    @endif
                                @endif



                                {{-- BUTTONS UPLOAD --}}
                                @if ($user->id == auth()->id())
                                    <button class="mini_button" onclick="location.href='{{ route('newvideo') }}'"
                                        type="button" title="Опубликовать видеоматериал">


                                        @include('general.elements.profile.svg-newvideo')
                                    </button>
                                @endif

                                @if ($user->id == auth()->id())
                                    <button class="mini_button" onclick="location.href='{{ route('newstatement') }}'"
                                        type="button" title="Опубликовать фотоматериал">

                                        @include('general.elements.profile.svg-newstatement')

                                    </button>
                                @endif

                                {{-- SETTINGS --}}

                                @if ($user->id == auth()->id())
                                    <button class="mini_button" onclick="location.href='/profile'"
                                        type="button" title="Настройки пользователя">


                                        @include('general.elements.profile.svg-setting')

                                    </button>




                                    
                                @endif



                            </div>


                        </div>


                    </div>

                </div>

                <div class="profileuser_block_contents">

                    @if (count($statements) > 0)
                        <div class="profileuser_block_contents_wrap">

                            <div class="profileuser_block_contents_first_wrap_title">
                                <p>Фотоматериалы</p>
                            </div>

                            <div class="profileuser_block_wrap_line">
                            </div>

                            <a href="{{ route('profile.profileuserstatements', ['id' => $user->id]) }}"
                                class="profileuser_block_contents_wrap_btn">
                                <p>Показать все</p>
                            </a>

                        </div>

                        <div class="profileuser_block_contents_first">


                            <div id="scrollContainerFirst" class="profileuser_block_contents_first_contents">


                                @foreach ($statements as $statement)
                                    <a class="profileuser_content_first"
                                        href="{{ route('statementuser', ['id' => $statement->id]) }}">



                                        <img src="{{ asset('storage/' . $statement->photo_path) }}">


                                        <div class="longvideos_video_thumbnail_title">
                                            <p class="txt_2">{{ $statement->title }}</p>
                                        </div>



                                    </a>
                                @endforeach



                            </div>

                        </div>
                    @endif

                    @if (count($videos) > 0)
                        <div class="profileuser_block_contents_wrap">

                            <div class="profileuser_block_contents_second_wrap_title">
                                <p>Видеоматериалы</p>
                            </div>

                            <div class="profileuser_block_wrap_line"></div>

                            <a href="{{ route('profile.profileuservideos', ['id' => $user->id]) }}"
                                class="profileuser_block_contents_wrap_btn">
                                <p>Показать все</p>
                            </a>

                        </div>






                        <div class="profileuser_block_contents_second">


                            <div id="scrollContainerSecond"
                                class="profileuser_block_contents_second_contents{{ count($videos) < 6 ? ' profileuser_block_contents_second_contents_flex' : '' }}">

                                @foreach ($videos as $key => $video)
                                    <div
                                        class="profileuser_content_second{{ ($key + 1) % 4 == 0 || $loop->first ? ' block1' : '' }}">
                                        <a href="{{ route('videouser', ['id' => $video->id]) }}">
                                            <img src="{{ asset('storage/' . $video->thumbnail_path) }}">
                                            <div class="longvideos_video_thumbnail_title">
                                                <p class="txt_2">{{ $video->title }}</p>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach

                            </div>




                        </div>
                    @endif
                </div>

            </div>


        </div>
    @endforeach

    <script>
        const containers = document.querySelectorAll('#scrollContainerFirst, #scrollContainerSecond');


        containers.forEach(container => {
            container.addEventListener('wheel', (event) => {
                event.preventDefault();
                container.scrollBy({
                    left: event.deltaY,
                    behavior: 'smooth'
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const avatarInput = document.getElementById("avatarInput");
            const avatarPreview = document.getElementById("avatarPreview");
            const submitBtn = document.getElementById("submitBtn");
            const cancelBtn = document.getElementById("cancelBtn");

            avatarPreview.addEventListener("click", function(event) {
                event.preventDefault();

                avatarInput.click();
            });

            avatarInput.addEventListener("change", function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                        submitBtn.style.display = "inline-block";
                        cancelBtn.style.display = "inline-block";
                    };
                    reader.readAsDataURL(file);
                }
            });

            cancelBtn.addEventListener("click", function() {
                avatarInput.value = "";
                avatarPreview.src =
                    "{{ $user->avatar ? asset('storage/' . $user->avatar) : '/uploads/ProfilePhoto.png' }}";
                submitBtn.style.display = "none";
                cancelBtn.style.display = "none";
            });
        });
    </script>



</x-app-layout>
