<x-app-layout>
    <x-slot name="header">

    </x-slot>



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
                                    <button class="full_statement_btn">
                                        <a href="{{ route('messenger.show', ['userId' => $user->id]) }}"
                                            class="message">



                                            <svg width="100%" height="100%" viewBox="-2.4 -2.4 28.80 28.80"
                                                fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(0)">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.048"></g>
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

                                @if ($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('send-friend-request', $user) }}">
                                        @csrf


                                        <button type="submit" class="full_statement_btn">

                                            <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                </g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M20 18L17 18M17 18L14 18M17 18V15M17 18V21M11 21H4C4 17.134 7.13401 14 11 14C11.695 14 12.3663 14.1013 13 14.2899M15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7Z"
                                                        stroke="#777777" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </g>
                                            </svg>

                                        </button>

                                    </form>
                                @endif




                                {{-- REMOVE FRIEND --}}

                                @if (
                                    $user->id != auth()->id() &&
                                        auth()->user()->areFriends($user->id))
                                    <button class="full_statement_btn" type="button"
                                        onclick="confirmRemoveFriend()">
                                        <form id="removeFriendForm" method="POST"
                                            action="{{ route('friend.remove', ['friend' => $user->id]) }}">
                                            @csrf
                                            @method('DELETE')


                                            <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M20 18L14 18M11 21H4C4 17.134 7.13401 14 11 14C11.695 14 12.3663 14.1013 13 14.2899M15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7Z"
                                                        stroke="#777777" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </g>
                                            </svg>



                                        </form>
                                    </button>
                                @endif

                                <script>
                                    function confirmRemoveFriend() {
                                        if (confirm('Вы уверены, что хотите удалить этого друга?')) {
                                            document.getElementById('removeFriendForm').submit();
                                        }
                                    }
                                </script>




                                {{-- REPORT --}}


                                @if ($user->id !== auth()->id())
                                    <button class="full_statement_btn"> <svg width="100%" height="100%"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                            stroke="#777777">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M5 21V3.90002C5 3.90002 5.875 3 8.5 3C11.125 3 12.875 4.8 15.5 4.8C18.125 4.8 19 3.9 19 3.9V14.7C19 14.7 18.125 15.6 15.5 15.6C12.875 15.6 11.125 13.8 8.5 13.8C5.875 13.8 5 14.7 5 14.7"
                                                    stroke="#777777" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                </path>
                                            </g>
                                        </svg>
                                    </button>
                                @endif




                                {{-- SETTINGS --}}

                                @if ($user->id == auth()->id())
                                    <button class="full_statement_btn" onclick="location.href='/profile'"
                                        type="button">


                                        <svg width="100%" height="100%" viewBox="0 0 1024 1024"
                                            xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path fill="#777777"
                                                    d="M600.704 64a32 32 0 0 1 30.464 22.208l35.2 109.376c14.784 7.232 28.928 15.36 42.432 24.512l112.384-24.192a32 32 0 0 1 34.432 15.36L944.32 364.8a32 32 0 0 1-4.032 37.504l-77.12 85.12a357.12 357.12 0 0 1 0 49.024l77.12 85.248a32 32 0 0 1 4.032 37.504l-88.704 153.6a32 32 0 0 1-34.432 15.296L708.8 803.904c-13.44 9.088-27.648 17.28-42.368 24.512l-35.264 109.376A32 32 0 0 1 600.704 960H423.296a32 32 0 0 1-30.464-22.208L357.696 828.48a351.616 351.616 0 0 1-42.56-24.64l-112.32 24.256a32 32 0 0 1-34.432-15.36L79.68 659.2a32 32 0 0 1 4.032-37.504l77.12-85.248a357.12 357.12 0 0 1 0-48.896l-77.12-85.248A32 32 0 0 1 79.68 364.8l88.704-153.6a32 32 0 0 1 34.432-15.296l112.32 24.256c13.568-9.152 27.776-17.408 42.56-24.64l35.2-109.312A32 32 0 0 1 423.232 64H600.64zm-23.424 64H446.72l-36.352 113.088-24.512 11.968a294.113 294.113 0 0 0-34.816 20.096l-22.656 15.36-116.224-25.088-65.28 113.152 79.68 88.192-1.92 27.136a293.12 293.12 0 0 0 0 40.192l1.92 27.136-79.808 88.192 65.344 113.152 116.224-25.024 22.656 15.296a294.113 294.113 0 0 0 34.816 20.096l24.512 11.968L446.72 896h130.688l36.48-113.152 24.448-11.904a288.282 288.282 0 0 0 34.752-20.096l22.592-15.296 116.288 25.024 65.28-113.152-79.744-88.192 1.92-27.136a293.12 293.12 0 0 0 0-40.256l-1.92-27.136 79.808-88.128-65.344-113.152-116.288 24.96-22.592-15.232a287.616 287.616 0 0 0-34.752-20.096l-24.448-11.904L577.344 128zM512 320a192 192 0 1 1 0 384 192 192 0 0 1 0-384zm0 64a128 128 0 1 0 0 256 128 128 0 0 0 0-256z">
                                                </path>
                                            </g>
                                        </svg>

                                    </button>
                                @endif

                            </div>


                        </div>


                    </div>

                </div>

                <div class="profileuser_block_contents">

                    {{-- 
                        
                        if videoscounts>statementscounts
                        foreach
                        менять местами

                        --}}

                    <div class="profileuser_block_contents_wrap">

                        <div class="profileuser_block_contents_first_wrap_title">
                            <p>Фотоматериалы</p>
                        </div>

                        <div class="profileuser_block_wrap_line">
                        </div>

                        <a href="{{ route('profile.profileuserstatements' , ['id' => $user->id] ) }}" class="profileuser_block_contents_wrap_btn">
                            <p>Показать все</p>
                        </a>

                    </div>

                    <div class="profileuser_block_contents_first">


                        <div id="scrollContainerFirst" class="profileuser_block_contents_first_contents">


                            @foreach ($statements as $statement)
                                <div class="profileuser_content_first">


                                    <img src="{{ asset('storage/' . $statement->photo_path) }}">


                                    <div class="longvideos_video_thumbnail_title">
                                        <p class="txt_2">{{ $statement->title }}</p>
                                    </div>


                                </div>
                            @endforeach



                        </div>

                    </div>

                    <div class="profileuser_block_contents_wrap">

                        <div class="profileuser_block_contents_second_wrap_title">
                            <p>Видеоматериалы</p>
                        </div>

                        <div class="profileuser_block_wrap_line"></div>

                        <div class="profileuser_block_contents_wrap_btn">
                            <p>Показать все</p>
                        </div>

                    </div>






                    <div class="profileuser_block_contents_second">


                        <div id="scrollContainerSecond" class="profileuser_block_contents_second_contents{{ count($videos) < 6 ? ' profileuser_block_contents_second_contents_flex' : '' }}">

                            @foreach ($videos as $key => $video)
                     

                                <div class="profileuser_content_second{{ ($key + 1) % 4 == 0 || $loop->first ? ' block1' : '' }}">
                                    <a href="{{ route('videouser', ['id' => $video->id]) }}">
                                    <img src="{{ asset('storage/' . $video->thumbnail_path) }}">
                                    <div class="longvideos_video_thumbnail_title">
                                        <p class="txt_2">{{$video->title}}</p>
                                    </div>
                                </a>
                                </div>
                       
                            @endforeach
                        
                        </div>
                        



                    </div>






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



{{-- <div class="profile_novosti_verh">

    @if ($user->id == auth()->id())
        <a href="/profile">
            <div class="profile_settings">
                <p class="txt_2">Настройки</p>
            </div>
        </a>
    @endif
    @if ($user->id == auth()->id())
        <div class="profile_condition">
            <form method="POST" action="{{ route('update-condition') }}">
                @csrf
                <input type="text" name="condition" value="{{ $user->condition }}"
                    placeholder="Кратко о себе...">
                <button class="txt_2" type="submit">Обновить условие</button>
            </form>
        </div>
    @endif
    @if ($user->id !== auth()->id())
        <p class="txt_1">{{ $user->condition }}</p>
    @endif

</div> --}}
