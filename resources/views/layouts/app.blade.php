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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="backgroundall">


        <!-- Page Heading -->
        @if (isset($header))
            <header class="header">





                <div class="header_top">


                    <div class="logotype">



                        <a href="{{ route('allvideouser') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="none"
                                viewBox="0 0 50 50">
                                <path stroke="#F5F5F5" stroke-opacity=".961" d="M3.5 3.5h43v43h-43z" />
                                <path fill="#F5F5F5" fill-opacity=".961"
                                    d="M16.44 16.38v-.78h7.23v.78l-1.65.18c-.32.02-.51.1-.57.24-.06.12-.09.53-.09 1.23v8.82l7.5-9c.5-.58.75-.93.75-1.05.02-.14-.14-.22-.48-.24l-1.53-.18v-.78h5.7v.78l-1.53.18c-.2.02-.36.06-.48.12-.12.04-.26.15-.42.33-.14.16-.38.44-.72.84l-4.68 5.64 5.7 10.08c.26.46.45.79.57.99.14.2.28.33.42.39.14.04.33.07.57.09l1.44.18V36h-4.68l-5.76-10.41-2.37 2.82v5.16c0 .7.03 1.11.09 1.23.06.12.25.2.57.24l1.65.18V36h-7.23v-.78l1.65-.18c.32-.04.51-.12.57-.24.06-.12.09-.53.09-1.23V18.03c0-.7-.03-1.11-.09-1.23-.06-.14-.25-.22-.57-.24l-1.65-.18Z" />
                                <path stroke="#F5F5F5" stroke-opacity=".961" d="M.5.5h49v49H.5z" />
                            </svg>

                        </a>



                    </div>

                </div>




                <div class="header_middle">



                    @auth

                        {{-- @if (auth()->user()->role == 'Admin')
                            <div class="adminpanel">
                                <a href="{{ route('allUsers', ['previous' => 'video']) }}">
                                    <p class="txt_1">Все пользователи - ADMIN</p>
                                </a>
                            </div>
                        @endif --}}


                        <div class="adminpanel">

                            <a href="{{ route('allvideouser') }}" title="Видео">

                                <div class="adminpanel">

                                    <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                    <lord-icon src="https://cdn.lordicon.com/uwtqzoif.json" trigger="hover"
                                        colors="primary:#777777" style="width:50px;height:50px">
                                    </lord-icon>

                                </div>
                            </a>

                        </div>

                        <div class="adminpanel">

                            <a href="{{ route('allshortsvideouser') }}" title="Клипы">

                                <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                <lord-icon src="https://cdn.lordicon.com/eouimtlu.json" trigger="hover"
                                    colors="primary:#777777" style="width:50px;height:50px">
                                </lord-icon>

                            </a>

                        </div>

                        <div class="adminpanel">

                            <a href="{{ route('allstatementuser') }}" title="Фотографии">
                                <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                <lord-icon src="https://cdn.lordicon.com/zyzoecaw.json" trigger="hover"
                                    colors="primary:#777777" style="width:50px;height:50px">
                                </lord-icon>
                            </a>

                        </div>

                        <div class="adminpanel">

                            <a href="{{ route('messenger') }}" title="Мессенджер">
                                <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                <lord-icon src="https://cdn.lordicon.com/fdxqrdfe.json" trigger="hover"
                                    colors="primary:#777777" style="width:50px;height:50px">
                                </lord-icon>
                            </a>

                        </div>

                        <div class="adminpanel">

                            <a href="{{ route('friendfeeduser') }}" title="Лента друзей">
                                <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                <lord-icon src="https://cdn.lordicon.com/ijahpotn.json" trigger="hover"
                                    colors="primary:#777777" style="width:50px;height:50px">
                                </lord-icon>
                            </a>

                        </div>








                    @endauth


                </div>


                <script>
                    function toggleSearch() {
                        const searchBlock = document.getElementById('searchBlock');
                        const notificationBlock = document.getElementById('notificationBlock');


                        if (notificationBlock.classList.contains('show') && window.innerWidth <= window.screen.width * 0.9) {
                            toggleNotification();
                        }


                        if (searchBlock.classList.contains('show')) {
                            searchBlock.classList.remove('show');
                        } else {

                            if (!notificationBlock.classList.contains('show') || window.innerWidth > window.screen.width * 0.9) {
                                searchBlock.classList.add('show');
                            }
                        }
                    }

                    function toggleNotification() {
                        const notificationBlock = document.getElementById('notificationBlock');
                        const searchBlock = document.getElementById('searchBlock');


                        if (searchBlock.classList.contains('show') && window.innerWidth <= window.screen.width * 0.9) {
                            toggleSearch();
                        }


                        if (notificationBlock.classList.contains('show')) {
                            notificationBlock.classList.remove('show');
                        } else {
                            if (!searchBlock.classList.contains('show') || window.innerWidth > window.screen.width * 0.9) {
                                notificationBlock.classList.add('show');
                            }
                        }
                    }

                    window.addEventListener('resize', function() {
                        const searchBlock = document.getElementById('searchBlock');
                        const notificationBlock = document.getElementById('notificationBlock');

                        searchBlock.classList.remove('show');
                        notificationBlock.classList.remove('show');
                    });
                </script>









                <div class="header_down1">
                    @auth
                    <div class="adminpanel">

                        <button type="button" onclick="toggleSearch()">
                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                            <lord-icon src="https://cdn.lordicon.com/kkvxgpti.json" trigger="hover"
                                colors="primary:#777777" style="width:50px;height:50px">
                            </lord-icon>
                        </button>

                    </div>
                    @endauth
                </div>




            </header>
        @endif
        <div id="searchBlock" class="search_block">

            <div class="notification_container">





                <div class="notification-block">



                    <div class="notification_block_contents_wrap">

                        <div class="profileuser_block_contents_second_wrap_title">
                            <p>Видеоматериалы</p>
                        </div>

                        <div class="profileuser_block_wrap_line"></div>


                    </div>






                    <div class="notification-block_frame" id="searchResultsVideo">



                    </div>




                </div>










                <div class="notification-block">



                    <div class="notification_block_contents_wrap">

                        <div class="profileuser_block_contents_second_wrap_title">
                            <p>Фотоматериалы</p>
                        </div>

                        <div class="profileuser_block_wrap_line"></div>


                    </div>


                    <div class="notification-block_frame" id="searchResultsStatement">





                    </div>




                </div>














                <div class="notification-block">



                    <div class="notification_block_contents_wrap">

                        <div class="profileuser_block_contents_second_wrap_title">
                            <p>Пользователи</p>
                        </div>

                        <div class="profileuser_block_wrap_line"></div>


                    </div>






                    <div class="notification-block_frame" id="searchResultsUser">

                        

                    </div>




                </div>























                <!-- Другие уведомления... -->
            </div>

            <form action="" class="message_history_input">

                <div class="message_history_input_search_container">
                    <input type="text" id="searchInput" type="text" name="message" required autofocus
                        autocomplete="message" class="message_history_input_container"
                        placeholder="Введите текст для поиска...">
                </div>

            </form>


        </div>





        <main>
            {{ $slot }}
        </main>


        {{-- @include('layouts.navigation') --}}





        <?php
        $friendRequests = \App\Models\Friendship::where('recipient_id', auth()->id())->where('status', 'pending')->get();
        ?>



        <div id="notificationBlock" class="notification_block">



            @foreach ($friendRequests as $request)
                <div class="notification_container">

                    <div class="notication_top">
                        <div class="notification_image">

                            <p>ава</p>

                        </div>

                        <div class="notification_content">

                            <div class="">
                                <a href="{{ route('profile.profileuser', ['id' => $request->id]) }}">
                                    {{ $request->sender->name }}
                                </a>

                                отправил вам запрос в друзья
                            </div>

                            <div class="">
                                дата
                            </div>
                        </div>


                    </div>

                    <div class="notification_actions">
                        <div>
                            <form action="{{ route('accept-friend-request', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="accept-btn">Принять</button>
                            </form>
                        </div>

                        <div>
                            <form action="{{ route('reject-friend-request', $request->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="reject-btn">Отказать</button>
                            </form>
                        </div>
                    </div>

                </div>
            @endforeach

        </div>


        @if (isset($header))


            <header class="header">




                <div class="header_top">

                    <div class="profile">



                        @if (Auth::check())
                            <a href="{{ route('profileuser') }}">

                                @if (Auth::user()->avatar !== null)
                                    <img class="avatar_mini"
                                        src="{{ asset('storage/' . Auth::user()->avatar) }}"alt="Avatar">
                                @else
                                    <img class="avatar_mini" src="/uploads/ProfilePhoto.png" width="50px"
                                        height="50px">
                                @endif

                            </a>
                        @else
                            <a href="/login">


                                <img class="avatar_mini" src="/uploads/ProfilePhoto.png" width="50px"
                                    height="50px">
                            </a>
                        @endif


                    </div>




                    @auth
                    <div class="adminpanel">

                        <button type="button" onclick="toggleNotification()">

                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                            <lord-icon src="https://cdn.lordicon.com/vspbqszr.json" trigger="hover" state="loop-bell"
                                colors="primary:#777777" style="width:50px;height:50px">
                            </lord-icon>

                        </button>
                    </div>
@endauth



                    <svg fill="#777777" width="50px" height="50px" viewBox="0 -6 44 44"
                        xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" stroke="#777777">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M42.001,32.000 L14.010,32.000 C12.908,32.000 12.010,31.104 12.010,30.001 L12.010,28.002 C12.010,27.636 12.211,27.300 12.532,27.124 L22.318,21.787 C19.040,18.242 19.004,13.227 19.004,12.995 L19.010,7.002 C19.010,6.946 19.015,6.891 19.024,6.837 C19.713,2.751 24.224,0.007 28.005,0.007 C28.006,0.007 28.008,0.007 28.009,0.007 C31.788,0.007 36.298,2.749 36.989,6.834 C36.998,6.889 37.003,6.945 37.003,7.000 L37.006,12.994 C37.006,13.225 36.970,18.240 33.693,21.785 L43.479,27.122 C43.800,27.298 44.000,27.634 44.000,28.000 L44.000,30.001 C44.000,31.104 43.103,32.000 42.001,32.000 ZM31.526,22.880 C31.233,22.720 31.039,22.425 31.008,22.093 C30.978,21.761 31.116,21.436 31.374,21.226 C34.971,18.310 35.007,13.048 35.007,12.995 L35.003,7.089 C34.441,4.089 30.883,2.005 28.005,2.005 C25.126,2.006 21.570,4.091 21.010,7.091 L21.004,12.997 C21.004,13.048 21.059,18.327 24.636,21.228 C24.895,21.438 25.033,21.763 25.002,22.095 C24.972,22.427 24.778,22.722 24.485,22.882 L14.010,28.596 L14.010,30.001 L41.999,30.001 L42.000,28.595 L31.526,22.880 ZM18.647,2.520 C17.764,2.177 16.848,1.997 15.995,1.997 C13.116,1.998 9.559,4.083 8.999,7.083 L8.993,12.989 C8.993,13.041 9.047,18.319 12.625,21.220 C12.884,21.430 13.022,21.755 12.992,22.087 C12.961,22.419 12.767,22.714 12.474,22.874 L1.999,28.588 L1.999,29.993 L8.998,29.993 C9.550,29.993 9.997,30.441 9.997,30.993 C9.997,31.545 9.550,31.993 8.998,31.993 L1.999,31.993 C0.897,31.993 -0.000,31.096 -0.000,29.993 L-0.000,27.994 C-0.000,27.629 0.200,27.292 0.521,27.117 L10.307,21.779 C7.030,18.234 6.993,13.219 6.993,12.988 L6.999,6.994 C6.999,6.939 7.004,6.883 7.013,6.829 C7.702,2.744 12.213,-0.000 15.995,-0.000 C15.999,-0.000 16.005,-0.000 16.010,-0.000 C17.101,-0.000 18.262,0.227 19.369,0.656 C19.885,0.856 20.140,1.435 19.941,1.949 C19.740,2.464 19.158,2.720 18.647,2.520 Z">
                            </path>
                        </g>
                    </svg>

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

                    @foreach ($friends as $friend)
                        @if ($friend->id !== auth()->id())
                            <a href="{{ route('profile.profileuser', ['id' => $friend->id]) }}">

                                @if ($friend->avatar !== null)
                                    <img class="avatar_mini" src="{{ asset('storage/' . $friend->avatar) }}"
                                        alt="Avatar">
                                @else
                                    <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                @endif

                            </a>
                        @endif
                    @endforeach




                </div>


                <div class="header_down">


                    <div class="logout">


                        @if (Auth::check())
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-responsive-nav-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30"
                                        height="30" fill="#777777">
                                        <g id="_01_align_center" data-name="01 align center">
                                            <path
                                                d="M2,21V3A1,1,0,0,1,3,2H8V0H3A3,3,0,0,0,0,3V21a3,3,0,0,0,3,3H8V22H3A1,1,0,0,1,2,21Z" />
                                            <path
                                                d="M23.123,9.879,18.537,5.293,17.123,6.707l4.264,4.264L5,11l0,2,16.443-.029-4.322,4.322,1.414,1.414,4.586-4.586A3,3,0,0,0,23.123,9.879Z" />
                                        </g>
                                    </svg>

                                </x-responsive-nav-link>

                            </form>
                        @else
                        @endif





                    </div>

                </div>

            </header>

        @endif

    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#searchInput').on('input', function() {
                let searchTerm = $(this).val().trim();
    
                if (searchTerm.length >= 3) {
                    $.ajax({
                        type: 'GET',
                        url: '/video/autocomplete',
                        data: {
                            search: searchTerm
                        },
                        success: function(response) {
                            console.log(
                                response);
                            let resultsDiv = $('#searchResultsVideo');
                            resultsDiv.empty();
    
                            $.each(response.videos, function(index, video) {
                                resultsDiv.append(
                                    '<a href="/videouser/' + video.id +
                                    '">' +
                                    '<div class="statement_block">' +
                                        '<div class="statement_block_top">' +
            '<div class="statement_block_top_info_left">' +
               '<div class="statement_block_top_avatar">' +
                  '<img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">' +
        '</div>' +
        '<div class="statement_block_top_info">' +
                    '<div class="statement_block_top_info_name">' +
                        video.user.name +
                    '</div>' +
                    '<div class="statement_block_top_info_createdat">' +
                        video.created_at +
                    '</div>' +
               '</div>' +
            '</div>' +
            '<div class="statement_block_top_info_right">' +
                '<div class="statement_block_top_info_right_info">' +
                    '<div>' +
                        '<svg width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                            '<g id="SVGRepo_bgCarrier" stroke-width="0"></g>' +
                            '<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>' +
                            '<g id="SVGRepo_iconCarrier">' +
                                '<path d="M19.3 5.71002C18.841 5.24601 18.2943 4.87797 17.6917 4.62731C17.0891 4.37666 16.4426 4.2484 15.79 4.25002C15.1373 4.2484 14.4909 4.37666 13.8883 4.62731C13.2857 4.87797 12.739 5.24601 12.28 5.71002L12 6.00002L11.72 5.72001C10.7917 4.79182 9.53273 4.27037 8.22 4.27037C6.90726 4.27037 5.64829 4.79182 4.72 5.72001C3.80386 6.65466 3.29071 7.91125 3.29071 9.22002C3.29071 10.5288 3.80386 11.7854 4.72 12.72L11.49 19.51C11.6306 19.6505 11.8212 19.7294 12.02 19.7294C12.2187 19.7294 12.4094 19.6505 12.55 19.51L19.32 12.72C20.2365 11.7823 20.7479 10.5221 20.7442 9.21092C20.7405 7.89973 20.2218 6.64248 19.3 5.71002Z" fill="#777777"></path>' +
                            '</g>' +
                        '</svg>' +
                    '</div>' +
                    '<div>66</div>' +
                '</div>' +
                '<div class="statement_block_top_info_right_info">' +
                    '<div>' +
                        '<svg width="100%" height="100%" viewBox="-0.96 -0.96 33.92 33.92" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#777777" stroke="#777777">' +
                            '<g id="SVGRepo_bgCarrier" stroke-width="0"></g>' +
                            '<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>' +
                            '<g id="SVGRepo_iconCarrier">' +
                                '<title>comment-2</title>' +
                                '<desc>Created with Sketch Beta.</desc>' +
                                '<defs> </defs>' +
                                '<g id="Page-1" stroke-width="0.8" fill="none" fill-rule="evenodd" sketch:type="MSPage">' +
                                    '<g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-152.000000, -255.000000)" fill="#777777">' +
                                        '<path d="M168,281 C166.832,281 165.704,280.864 164.62,280.633 L159.912,283.463 L159.975,278.824 C156.366,276.654 154,273.066 154,269 C154,262.373 160.268,257 168,257 C175.732,257 182,262.373 182,269 C182,275.628 175.732,281 168,281 L168,281 Z M168,255 C159.164,255 152,261.269 152,269 C152,273.419 154.345,277.354 158,279.919 L158,287 L165.009,282.747 C165.979,282.907 166.977,283 168,283 C176.836,283 184,276.732 184,269 C184,261.269 176.836,255 168,255 L168,255 Z M175,266 L161,266 C160.448,266 160,266.448 160,267 C160,267.553 160.448,268 161,268 L175,268 C175.552,268 176,267.553 176,267 C176,266.448 175.552,266 175,266 L175,266 Z M173,272 L163,272 C162.448,272 162,272.447 162,273 C162,273.553 162.448,274 163,274 L173,274 C173.552,274 174,273.553 174,273 C174,272.447 173.552,272 173,272 L173,272 Z" id="comment-2" sketch:type="MSShapeGroup"> </path>' +
                                    '</g>' +
                                '</g>' +
                            '</g>' +
                        '</svg>' +
                    '</div>' +
                    '<div>66</div>' +
                '</div>' +
                '<div class="statement_block_top_info_right_info">' +
                    '<div>' +
                        '<svg width="100%" height="100%" viewBox="0 0 24 24" fill="none"' +
                            'xmlns="http://www.w3.org/2000/svg">' +
                            '<g id="SVGRepo_bgCarrier" stroke-width="0"></g>' +
                            '<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>' +
                            '<g id="SVGRepo_iconCarrier">' +
                                '<path d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#777777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>' +
                                '<path d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#777777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>' +
                            '</g>' +
                        '</svg>' +
                    '</div>' +
                    '<div>' +
                        '66' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>' +
        '<div class="statement_block_middle">' +
            '<img src="' + response.base_url + '/' + video.thumbnail_path + '" alt="Photo">' +
        '</div>' +
        '<div class="statement_block_down">' +
            '<div class="statement_block_down_title">' +
                video.title +
           '</div>' +
            '<div class="statement_block_down_description">' +
                video.description +
            '</div>' +
        '</div>' +
    '</div>' +
                                    '</a>'
                                );
                            });
                        }
    
                    });
                } else {
                    $('#searchResultsVideo').empty();
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
                        url: '/statement/autocomplete',
                        data: {
                            search: searchTerm
                        },
                        success: function(response) {
                            console.log(
                                response);
                            let resultsDiv = $('#searchResultsStatement');
                            resultsDiv.empty();

                            $.each(response.statements, function(index, statement) {
                                resultsDiv.append(
                                    '<a href="/statementuser/' + statement.id +
                                    '">' +
                                    '<div class="statement_block">' +
                                        '<div class="statement_block_top">' +
            '<div class="statement_block_top_info_left">' +
               '<div class="statement_block_top_avatar">' +
                  '<img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">' +
        '</div>' +
        '<div class="statement_block_top_info">' +
                    '<div class="statement_block_top_info_name">' +
                        statement.user.name +
                    '</div>' +
                    '<div class="statement_block_top_info_createdat">' +
                        statement.created_at +
                    '</div>' +
               '</div>' +
            '</div>' +
            '<div class="statement_block_top_info_right">' +
                '<div class="statement_block_top_info_right_info">' +
                    '<div>' +
                        '<svg width="100%" height="100%" viewBox="0 0 24 24" fill="none"' +
                            'xmlns="http://www.w3.org/2000/svg">' +
                            '<g id="SVGRepo_bgCarrier" stroke-width="0"></g>' +
                            '<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>' +
                            '<g id="SVGRepo_iconCarrier">' +
                                '<path d="M19.3 5.71002C18.841 5.24601 18.2943 4.87797 17.6917 4.62731C17.0891 4.37666 16.4426 4.2484 15.79 4.25002C15.1373 4.2484 14.4909 4.37666 13.8883 4.62731C13.2857 4.87797 12.739 5.24601 12.28 5.71002L12 6.00002L11.72 5.72001C10.7917 4.79182 9.53273 4.27037 8.22 4.27037C6.90726 4.27037 5.64829 4.79182 4.72 5.72001C3.80386 6.65466 3.29071 7.91125 3.29071 9.22002C3.29071 10.5288 3.80386 11.7854 4.72 12.72L11.49 19.51C11.6306 19.6505 11.8212 19.7294 12.02 19.7294C12.2187 19.7294 12.4094 19.6505 12.55 19.51L19.32 12.72C20.2365 11.7823 20.7479 10.5221 20.7442 9.21092C20.7405 7.89973 20.2218 6.64248 19.3 5.71002Z" fill="#777777"></path>' +
                            '</g>' +
                        '</svg>' +
                    '</div>' +
                    '<div>66</div>' +
                '</div>' +
                '<div class="statement_block_top_info_right_info">' +
                    '<div>' +
                        '<svg width="100%" height="100%" viewBox="-0.96 -0.96 33.92 33.92" version="1.1"' +
                            'xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"' +
                            'xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#777777" stroke="#777777">' +
                            '<g id="SVGRepo_bgCarrier" stroke-width="0"></g>' +
                            '<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>' +
                            '<g id="SVGRepo_iconCarrier">' +
                                '<title>comment-2</title>' +
                                '<desc>Created with Sketch Beta.</desc>' +
                                '<defs> </defs>' +
                                '<g id="Page-1" stroke-width="0.8" fill="none" fill-rule="evenodd" sketch:type="MSPage">' +
                                    '<g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-152.000000, -255.000000)" fill="#777777">' +
                                        '<path d="M168,281 C166.832,281 165.704,280.864 164.62,280.633 L159.912,283.463 L159.975,278.824 C156.366,276.654 154,273.066 154,269 C154,262.373 160.268,257 168,257 C175.732,257 182,262.373 182,269 C182,275.628 175.732,281 168,281 L168,281 Z M168,255 C159.164,255 152,261.269 152,269 C152,273.419 154.345,277.354 158,279.919 L158,287 L165.009,282.747 C165.979,282.907 166.977,283 168,283 C176.836,283 184,276.732 184,269 C184,261.269 176.836,255 168,255 L168,255 Z M175,266 L161,266 C160.448,266 160,266.448 160,267 C160,267.553 160.448,268 161,268 L175,268 C175.552,268 176,267.553 176,267 C176,266.448 175.552,266 175,266 L175,266 Z M173,272 L163,272 C162.448,272 162,272.447 162,273 C162,273.553 162.448,274 163,274 L173,274 C173.552,274 174,273.553 174,273 C174,272.447 173.552,272 173,272 L173,272 Z" id="comment-2" sketch:type="MSShapeGroup"> </path>' +
                                    '</g>' +
                                '</g>' +
                            '</g>' +
                        '</svg>' +
                    '</div>' +
                    '<div>66</div>' +
                '</div>' +
                '<div class="statement_block_top_info_right_info">' +
                    '<div>' +
                        '<svg width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                            '<g id="SVGRepo_bgCarrier" stroke-width="0"></g>' +
                            '<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>' +
                            '<g id="SVGRepo_iconCarrier">' +
                                '<path d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#777777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>' +
                                '<path d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#777777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>' +
                            '</g>' +
                        '</svg>' +
                    '</div>' +
                    '<div>' +
                        '66' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>' +
        '<div class="statement_block_middle">' +
            '<img src="' + response.base_url + '/' + statement.photo_path + '" alt="Photo">' +
        '</div>' +
        '<div class="statement_block_down">' +
            '<div class="statement_block_down_title">' +
                 statement.title +
           '</div>' +
            '<div class="statement_block_down_description">' +
                 statement.description +
            '</div>' +
        '</div>' +
    '</div>' +
                                    '</a>'
                                );
                            });
                        }

                    });
                } else {
                    $('#searchResultsStatement').empty();
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
                    data: {
                        search: searchTerm
                    },
                    success: function(response) {
                        console.log(
                            response);
                        let resultsDiv = $('#searchResultsUser');
                        resultsDiv.empty();

                        $.each(response.users, function(index, user) {
                            resultsDiv.append(
                                '<a href="/profileuser/' + user.id +
                                '">' +
'<div class="statement_block">' +
'<div class="statement_block_top">' +
    '<div class="statement_block_top_info_left">' +
        '<div class="statement_block_top_avatar">' +
            '<img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">' +
        '</div>' +
        '<div class="statement_block_top_info">' +
            '<div class="statement_block_top_info_name">' + user.name + '</div>' +
            '<div class="statement_block_top_info_createdat">' + user.condition + '</div>' +
        '</div>' +
    '</div>' +
    '<div class="statement_block_top_info_right">' +
        '<div class="statement_block_top_info_right_info">' +
            '<form method="POST"class="full_notication_btn" action="">' +
               '@csrf' +
                '<button type="submit">' +
                    '<svg width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                        '<g id="SVGRepo_bgCarrier" stroke-width="0"></g>' +
                        '<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>' +
                        '<g id="SVGRepo_iconCarrier">' +
                            '<path d="M20 18L17 18M17 18L14 18M17 18V15M17 18V21M11 21H4C4 17.134 7.13401 14 11 14C11.695 14 12.3663 14.1013 13 14.2899M15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7Z" stroke="#777777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>' +
'</g>' +
                    '</svg>' +
                '</button>' +
            '</form>' +
        '</div>' +
    '</div>' +
'</div>' +
'</div>' +
                                '</a>'
                            );
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
