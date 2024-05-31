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
    @vite(['resources/css/app.css',
    'resources/css/profileuser/profileuserfull.css',
    'resources/css/profileuser/profileuserPublicate.css',
    'resources/css/statement/statementBlock.css',
    'resources/css/statement/statementFull.css',
    'resources/css/video/videoCatalog.css',
    'resources/css/video/videoControl.css',
    'resources/css/video/videoFullvideo.css',
    'resources/css/video/videoShortvideo.css',
    'resources/css/adminpanel.css',
    'resources/css/friendfeed.css',
    'resources/css/messenger.css',
    'resources/css/notification.css',
    'resources/js/app.js'])
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
                    <input type="text" id="searchInput" type="text" name="message" required class="message_history_input_container" placeholder="Введите текст для поиска...">
                </div>

            </form>


        </div>





        <main>
            {{ $slot }}
            @include('flash::message')

        </main>


        {{-- @include('layouts.navigation') --}}

        <script>
            $(document).ready(function(){
                $('.flash-success').delay(5000).fadeOut('slow');
            });
        </script>



        <?php
        $friendRequests = \App\Models\Friendship::where('recipient_id', auth()->id())->where('status', 'pending')->get();
        ?>



        <div id="notificationBlock" class="notification_block">



            @foreach ($friendRequests as $friendRequest)
                <div class="notification_container">

                    <div class="notication_top">
                        <div class="notification_image">

                            <p>ава</p>

                        </div>

                        <div class="notification_content">

                            <div class="">
                                <a href="{{ route('profile.profileuser', ['id' => $friendRequest->sender->id]) }}">
                                    {{ $friendRequest->sender->name }}
                                </a>

                                отправил вам запрос в друзья
                            </div>

                            <div class="">
                                дата {{ $friendRequest->created_at}}
                            </div>
                        </div>


                    </div>

                    <div class="notification_actions">
                        <div>
                            <form action="{{ route('accept-friend-request', $friendRequest->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="accept-btn">Принять</button>
                            </form>
                        </div>

                        <div>
                            <form action="{{ route('reject-friend-request', $friendRequest->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="reject-btn">Отказать</button>
                            </form>
                        </div>
                    </div>

                </div>
            @endforeach

        </div>


        @include('layouts.navigation-right')


    </div>

    <script>
        $(document).ready(function() {
            $('#searchInput').on('input', function() {
                let searchTerm = $(this).val().trim();
    
                if (searchTerm.length >= 3) {
                    // Очищаем результаты поиска перед новым запросом
                    $('#searchResultsVideo, #searchResultsStatement').empty();
    
                    let searchConfigs = [
                        {url: '/video/autocomplete', resultsDiv: '#searchResultsVideo', template: 'video'},
                        {url: '/statement/autocomplete', resultsDiv: '#searchResultsStatement', template: 'statement'}
                    ];
    
                    searchConfigs.forEach(function(config) {
                        $.ajax({
                            type: 'GET',
                            url: config.url,
                            data: { search: searchTerm },
                            success: function(response) {
                                let resultsDiv = $(config.resultsDiv);
                                resultsDiv.empty();
    
                                $.each(response[config.template + 's'], function(index, item) {
                                    let template = `
                                        <a href="/${config.template}user/${item.id}">
                                            <div class="statement_block">
                                                <div class="statement_block_top">
                                                    <div class="statement_block_top_info_left">
                                                        <div class="statement_block_top_avatar">
                                                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                                        </div>
                                                        <div class="statement_block_top_info">
                                                            <div class="statement_block_top_info_name">${item.user.name}</div>
                                                            <div class="statement_block_top_info_createdat">${item.created_at}</div>
                                                        </div>
                                                    </div>
                                                    <div class="statement_block_top_info_right">
                                                        <div class="statement_block_top_info_right_info">
                                                            <!-- Оставить вашу логику для лайков, комментариев и т.д. -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="statement_block_middle">
                                                    <img src="${response.base_url}/${item.thumbnail_path || item.photo_path}" alt="Photo">
                                                </div>
                                                <div class="statement_block_down">
                                                    <div class="statement_block_down_title">${item.title}</div>
                                                    <div class="statement_block_down_description">${item.description}</div>
                                                </div>
                                            </div>
                                        </a>`;
                                    resultsDiv.append(template);
                                });
                            }
                        });
                    });
                } else {
                    $('#searchResultsVideo, #searchResultsStatement').empty();
                }
            });
        });
    </script>
    
    






    <script>
        $(document).ready(function() {
            $('#searchInput').on('input', function() {
                let searchTerm = $(this).val().trim();
    
                if (searchTerm.length >= 3) {
                    $.ajax({
                        type: 'GET',
                        url: '/user/autocomplete',
                        data: { search: searchTerm },
                        success: function(response) {
                            let resultsDiv = $('#searchResultsUser');
                            resultsDiv.empty();
    
                            $.each(response.users, function(index, user) {
                                let template = `
                                    <a href="/profileuser/${user.id}">
                                        <div class="statement_block">
                                            <div class="statement_block_top">
                                                <div class="statement_block_top_info_left">
                                                    <div class="statement_block_top_avatar">
                                                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                                    </div>
                                                    <div class="statement_block_top_info">
                                                        <div class="statement_block_top_info_name">${user.name}</div>
                                                        <div class="statement_block_top_info_createdat">${user.condition}</div>
                                                    </div>
                                                </div>
                                                <div class="statement_block_top_info_right">
                                                    <div class="statement_block_top_info_right_info">
                                                        <form method="POST" class="full_notication_btn" action="/send-friend-request/${user.id}">
                                                            @csrf
                                                            <button type="submit">
                                                                <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                    <g id="SVGRepo_iconCarrier">
                                                                        <path d="M20 18L17 18M17 18L14 18M17 18V15M17 18V21M11 21H4C4 17.134 7.13401 14 11 14C11.695 14 12.3663 14.1013 13 14.2899M15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7Z" stroke="#777777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </g>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>`;
                                resultsDiv.append(template);
                            });
                        }
                    });
                } else {
                    $('#searchResultsUser').empty();
                }
            });
        });
    </script>
    


</body>

</html>
