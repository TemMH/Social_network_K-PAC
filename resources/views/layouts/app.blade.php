<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/profileuser/profileuserfull.css', 'resources/css/profileuser/profileuserPublicate.css', 'resources/css/statement/statementBlock.css', 'resources/css/statement/statementFull.css', 'resources/css/video/videoCatalog.css', 'resources/css/video/videoControl.css', 'resources/css/video/videoFullvideo.css', 'resources/css/video/videoShortvideo.css', 'resources/css/adminpanel.css', 'resources/css/friendfeed.css', 'resources/css/messenger.css', 'resources/css/notification.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="backgroundall">


        @include('layouts.navigation-left')





        <div id="searchBlock" class="search_block">

            <div class="notification_container">

                <div class="notification-block">

                    <div class="notification_block_contents_wrap">

                        <div class="profileuser_block_contents_second_wrap_title">
                            <p>Видеоматериалы</p>
                        </div>

                        <div class="right_block_wrap_line"></div>


                    </div>

                    <div class="notification-block_frame" id="searchResultsVideo">

                    </div>

                </div>


                <div class="notification-block">
                    <div class="notification_block_contents_wrap">

                        <div class="profileuser_block_contents_second_wrap_title">
                            <p>Фотоматериалы</p>
                        </div>

                        <div class="right_block_wrap_line"></div>

                    </div>

                    <div class="notification-block_frame" id="searchResultsStatement">
                    </div>

                </div>

                <div class="notification-block">



                    <div class="notification_block_contents_wrap">

                        <div class="profileuser_block_contents_second_wrap_title">
                            <p>Пользователи</p>
                        </div>

                        <div class="right_block_wrap_line"></div>

                    </div>

                    <div class="notification-block_frame" id="searchResultsUser">

                    </div>

                </div>

            </div>

            <form action="" class="message_history_input">

                <div class="message_history_input_search_container">
                    <input type="text" id="searchInput" type="text" name="message" required
                        class="message_history_input_container" placeholder="Введите текст для поиска...">
                </div>

            </form>


        </div>





        <main>
            {{ $slot }}


            @include('flash::message')

            <div id="flash-success" class="flash-success" style="display: none;">
                <div class="flsh-title">K-PAC</div>
                <div class="flash-message"></div>
            </div>

            <div id="flash-error" class="flash-error" style="display: none;">
                <div class="flsh-title">K-PAC</div>
                <div class="flash-message"></div>
            </div>
        </main>


        <script>
            $(document).ready(function() {
                $('.flash-success').delay(5000).fadeOut('slow');
            });
        </script>

        <script>
            $(document).ready(function() {
                $('.flash-error').delay(5000).fadeOut('slow');
            });
        </script>
        <script>
            function showFlashSuccess(message) {
                var flashSuccess = document.getElementById('flash-success');
                var flashMessage = flashSuccess.querySelector('.flash-message');
                flashMessage.textContent = message;
                flashSuccess.style.display = 'block';
            }
        </script>
        <script>
            function showFlashError(message) {
                var flashError = document.getElementById('flash-error');
                var flashMessage = flashError.querySelector('.flash-message');
                flashMessage.textContent = message;
                flashError.style.display = 'block';
            }
        </script>

        <?php
        $friendRequests = \App\Models\Friendship::where('recipient_id', auth()->id())->where('status', 'pending')->get();
        ?>
        <?php
        use App\Models\Complaint;
        
        $complaints = Complaint::where('sender_id', auth()->id())->where('status', 'accepted')->get();
        
        ?>


        <div id="notificationBlock" class="notification_block">



            @foreach ($friendRequests as $friendRequest)
                <div style="height: auto;" class="notification_container">
                    <div style="margin-inline: auto; */
display: flex;
width: -webkit-fill-available;"
                        class="message_dialog  active ">
                        <div style="    width: max-content;" class="notication_top">
                            <div class="notification_image">

                                @if ($friendRequest->sender->avatar !== null)
                                    <a href="{{ route('profile.profileuser', ['id' => $friendRequest->sender->id]) }}">
                                        <img class="avatar_mini"
                                            src="{{ asset('storage/' . $friendRequest->sender->avatar) }}"
                                            alt="Avatar">
                                    </a>
                                @else
                                    <a href="{{ route('profile.profileuser', ['id' => $friendRequest->sender->id]) }}">
                                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                    </a>
                                @endif


                            </div>

                            <div class="notification_content">

                                <div style="display: flex;
                            width: max-content;">
                                    <a href="{{ route('profile.profileuser', ['id' => $friendRequest->sender->id]) }}">
                                        {{ $friendRequest->sender->name }}
                                    </a>

                                    ㅤотправил вам запрос в друзья
                                </div>

                                <div class="">
                                 {{ $friendRequest->created_at }}
                                </div>
                            </div>


                        </div>

                        <div class="notification_actions">
                            <div>
                                <form action="{{ route('accept-friend-request', $friendRequest->sender->id) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="long_button">Принять</button>
                                </form>
                            </div>

                            <div>
                                <form action="{{ route('reject-friend-request', $friendRequest->sender->id) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="long_button">Отказать</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
            @foreach ($complaints as $complaint)
                <div style="height: auto;" class="notification_container_right">

                <div style="height: auto;" class="notification_container">
                    <div style="margin-inline: auto; */
display: flex;
width: -webkit-fill-available;"
                        class="message_dialog  active ">
                        <div style="    width: max-content;" class="notication_top">

                            <div class="notification_content">

                                <div style="
                            width: max-content;">


@if(!is_null($complaint->user_id))
<p>По вашей жалобе был заблокирован </p>
@endif

@if(!is_null($complaint->video_id))
<p>По вашей жалобе было заблокирован  </p>
@endif

@if(!is_null($complaint->statement_id))
<p>По вашей жалобе был заблокирован  </p>
@endif



                        
                        @if(!is_null($complaint->user_id))
                        <p>пользователь "{{ $complaint->user->name }}"</p>
                    @endif
                    
                    @if(!is_null($complaint->video_id))
                        <p>видеоматериал "{{ $complaint->video->title }}"</p>
                    @endif
                    
                    @if(!is_null($complaint->statement_id))
                        <p>фотоматериал "{{ $complaint->statement->title }}"</p>
                    @endif
                    


<p>по причине "{{ $complaint->reason->name }}"</p>
                                </div>


                            </div>


                        </div>

                        <div class="notification_actions">
                            <div>

                                <div style="margin-inline: auto;">
                                    <form action="{{ route('user.update.complaint', ['id' => $complaint->id]) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="long_button">Скрыть</button>
                                    </form>


                                </div>
        
                            </div>



                        </div>
                    </div>
                </div>
                </div>
            @endforeach




        </div>


        @include('layouts.navigation-right')


    </div>

    @vite(['resources/js/search-input/SearchGlobal.js'])
</body>

</html>
