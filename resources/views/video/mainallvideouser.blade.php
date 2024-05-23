<x-app-layout>
    <x-slot name="header">

    </x-slot>






    <div class="longvideos_field">
        @if ($trendvideos->isNotEmpty())
        @php
            $trendvideo = $trendvideos->first();
        @endphp
    
        <div class="longvideos_thumbnail">
            <div class="blurred_bottom"></div>
            <div class="longvideos_thumbnail_info show">
                <div class="longvideos_thumbnail_top show">
                    <h1 class="longvideos_thumbnail_title">
                        {{ $trendvideo->title }}
                    </h1>
    
                    <div class="longvideos_thumbnail_dopinfo">
                        <div class="longvideos_thumbnail_avatar"></div>
                        <div class="longvideos_thumbnail_name">
                            {{ $trendvideo->user->name }} ㅤ
                        </div>
                        <div class="longvideos_thumbnail_created_at">
                            @if (!function_exists('pluralForm'))
                                @php
                                    function pluralForm($number, $one, $two, $five) {
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
                                    $formattedTime = $days . ' ' . pluralForm($days, 'день', 'дня', 'дней') . ' назад';
                                } elseif ($timeDiff >= 3600) {
                                    $hours = floor($timeDiff / 3600);
                                    $formattedTime = $hours . ' ' . pluralForm($hours, 'час', 'часа', 'часов') . ' назад';
                                } elseif ($timeDiff >= 60) {
                                    $minutes = floor($timeDiff / 60);
                                    $formattedTime = $minutes . ' ' . pluralForm($minutes, 'минута', 'минуты', 'минут') . ' назад';
                                } else {
                                    $formattedTime = 'только что';
                                }
                            @endphp
                            <p class="longvideos_thumbnail_created_at">
                                {{ $formattedTime }}
                            </p>
                        </div>
                    </div>
                </div>
    
                <details class="longvideos_thumbnail_description">
                    <summary>
                        Раскрывающийся список
                    </summary>
                    <div class="longvideos_thumbnail_description_text">
                        {{ $trendvideo->description }}
                    </div>
                </details>
            </div>
            <div style="position: absolute" class=""></div>
            <img src="{{ asset('storage/' . $trendvideo->thumbnail_path) }}" alt=" " style="object-fit: cover;" class="videoThumbnail_main">
        </div>
    @else
        <p>No trend videos available.</p>
    @endif
    

        <div class="longvideos_selections">

            <div class="longvideos_categories">
                <form id="categoryForm" method="GET" action="{{ url()->current() }}">
                    @csrf
                    <div class="category">


                        <button value="" class="longvideos_categories_btn">Все категории</button>
                        <button value="Спорт" class="longvideos_categories_btn">Спорт</button>
                        <button value="Игры" class="longvideos_categories_btn">Игры</button>
                        <button value="Экономика" class="longvideos_categories_btn">Экономика</button>
                        <button value="Транспорт" class="longvideos_categories_btn">Транспорт</button>

                    </div>
                </form>
            </div>
            <div class="longvideos_scroll_lock">



                <div class="longvideos_scroll_sorting_block">

                    <div class="longvideos_scroll_sorting_block_name"><button
                            onclick="location.href='{{ route('all.video.user.trend') }}';" class="statements_type_btn">В
                            тренде</button>
                        <div class="longvideos_scroll_sorting_block_wrap_line"></div>
                    </div>

                    <div class="longvideos_scroll_sorting_block_videos">

                        @foreach ($trendvideos as $trendvideo)

                            <div class="longvideos_scroll_sorting_block_videos_fixed">
                                <div class="main_novost_allvideo">
                                    <a href="{{ route('videouser', ['id' => $trendvideo->id]) }}">
                                        @csrf

                                        <div class="longvideos_video_thumbnail">
                                            <img src="{{ asset('storage/' . $trendvideo->thumbnail_path) }}" alt="Thumbnail"
                                                style="object-fit:contain;" class="videoThumbnail"
                                                style="cursor:pointer;">
                                            <div class="longvideos_video_thumbnail_title">
                                                <p class="txt_2">{{ $trendvideo->title }}</p>
                                            </div>
                                            <div class="longvideos_thumbnail_dopinfo_formain">
                                                <p class="lv_name">{{ $trendvideo->user->name }}</p>
                                                <p class="lv_avatar">
                                                    @if ($trendvideo->user->avatar !== null)
                                                        <img class="avatar"
                                                            src="{{ asset('storage/' . $trendvideo->user->avatar) }}"
                                                            alt="Avatar">
                                                    @else
                                                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png"
                                                            alt="Avatar">
                                                    @endif
                                                </p>
                                                <p class="lv_description">{{ $trendvideo->description }}</p>


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
                                                <p class="lv_created_at">{{ $formattedTime }}</p>
                                            </div>
                                        </div>

                                    </a>
                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>

                <div class="longvideos_scroll_sorting_block">

                    <div class="longvideos_scroll_sorting_block_name"><button
                            onclick="location.href='{{ route('all.video.user.popular') }}';"
                            class="statements_type_btn">Популярное</button>
                        <div class="longvideos_scroll_sorting_block_wrap_line"></div>
                    </div>

                    <div class="longvideos_scroll_sorting_block_videos">
                        
                        @foreach ($popularvideos as $popularvideo)

                            <div class="longvideos_scroll_sorting_block_videos_fixed">
                                <div class="main_novost_allvideo">
                                    <a href="{{ route('videouser', ['id' => $popularvideo->id]) }}">
                                        @csrf

                                        <div class="longvideos_video_thumbnail">
                                            <img src="{{ asset('storage/' . $popularvideo->thumbnail_path) }}" alt="Thumbnail"
                                                style="object-fit:contain;" class="videoThumbnail"
                                                style="cursor:pointer;">
                                            <div class="longvideos_video_thumbnail_title">
                                                <p class="txt_2">{{ $popularvideo->title }}</p>
                                            </div>
                                            <div class="longvideos_thumbnail_dopinfo_formain">
                                                <p class="lv_name">{{ $popularvideo->user->name }}</p>
                                                <p class="lv_avatar">
                                                    @if ($popularvideo->user->avatar !== null)
                                                        <img class="avatar"
                                                            src="{{ asset('storage/' . $popularvideo->user->avatar) }}"
                                                            alt="Avatar">
                                                    @else
                                                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png"
                                                            alt="Avatar">
                                                    @endif
                                                </p>
                                                <p class="lv_description">{{ $popularvideo->description }}</p>


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
                                                    $createdAt = strtotime($popularvideo->created_at);
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
                                                <p class="lv_created_at">{{ $formattedTime }}</p>
                                            </div>
                                        </div>

                                    </a>
                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>

                <div class="longvideos_scroll_sorting_block">

                    <div class="longvideos_scroll_sorting_block_name"><button
                            onclick="location.href='{{ route('all.video.user.newforuser') }}';"
                            class="statements_type_btn">Новое для вас</button>
                        <div class="longvideos_scroll_sorting_block_wrap_line"></div>
                    </div>

                    <div class="longvideos_scroll_sorting_block_videos">

                        @foreach ($newforuservideos as $newforuservideo)
                        
                            <div class="longvideos_scroll_sorting_block_videos_fixed">
                                <div class="main_novost_allvideo">
                                    <a href="{{ route('videouser', ['id' => $newforuservideo->id]) }}">
                                        @csrf

                                        <div class="longvideos_video_thumbnail">
                                            <img src="{{ asset('storage/' . $newforuservideo->thumbnail_path) }}"
                                                alt="Thumbnail" style="object-fit:contain;" class="videoThumbnail"
                                                style="cursor:pointer;">
                                            <div class="longvideos_video_thumbnail_title">
                                                <p class="txt_2">{{ $newforuservideo->title }}</p>
                                            </div>
                                            <div class="longvideos_thumbnail_dopinfo_formain">
                                                <p class="lv_name">{{ $newforuservideo->user->name }}</p>
                                                <p class="lv_avatar">
                                                    @if ($newforuservideo->user->avatar !== null)
                                                        <img class="avatar"
                                                            src="{{ asset('storage/' . $newforuservideo->user->avatar) }}"
                                                            alt="Avatar">
                                                    @else
                                                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png"
                                                            alt="Avatar">
                                                    @endif
                                                </p>
                                                <p class="lv_description">{{ $newforuservideo->description }}</p>


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
                                                    $createdAt = strtotime($newforuservideo->created_at);
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
                                                <p class="lv_created_at">{{ $formattedTime }}</p>
                                            </div>
                                        </div>

                                    </a>
                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>

                <div class="longvideos_scroll_sorting_block">

                    <div class="longvideos_scroll_sorting_block_name"><button
                            onclick="location.href='{{ route('all.video.user.new') }}';"
                            class="statements_type_btn">Недавно опубликованные</button>
                        <div class="longvideos_scroll_sorting_block_wrap_line"></div>
                    </div>

                    <div class="longvideos_scroll_sorting_block_videos">

                        @foreach ($newvideos as $newvideo)

                            <div class="longvideos_scroll_sorting_block_videos_fixed">
                                <div class="main_novost_allvideo">
                                    <a href="{{ route('videouser', ['id' => $newvideo->id]) }}">
                                        @csrf

                                        <div class="longvideos_video_thumbnail">
                                            <img src="{{ asset('storage/' . $newvideo->thumbnail_path) }}"
                                                alt="Thumbnail" style="object-fit:contain;" class="videoThumbnail"
                                                style="cursor:pointer;">
                                            <div class="longvideos_video_thumbnail_title">
                                                <p class="txt_2">{{ $newvideo->title }}</p>
                                            </div>
                                            <div class="longvideos_thumbnail_dopinfo_formain">
                                                <p class="lv_name">{{ $newvideo->user->name }}</p>
                                                <p class="lv_avatar">
                                                    @if ($newvideo->user->avatar !== null)
                                                        <img class="avatar"
                                                            src="{{ asset('storage/' . $newvideo->user->avatar) }}"
                                                            alt="Avatar">
                                                    @else
                                                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png"
                                                            alt="Avatar">
                                                    @endif
                                                </p>
                                                <p class="lv_description">{{ $newvideo->description }}</p>


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
                                                    $createdAt = strtotime($newvideo->created_at);
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
                                                <p class="lv_created_at">{{ $formattedTime }}</p>
                                            </div>
                                        </div>

                                    </a>
                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>

                <div class="longvideos_scroll_sorting_block">

                    <div class="longvideos_scroll_sorting_block_name"><button
                            onclick="location.href='{{ route('all.video.user.viewed') }}';"
                            class="statements_type_btn">Посмотрено</button>
                        <div class="longvideos_scroll_sorting_block_wrap_line"></div>
                    </div>

                    <div class="longvideos_scroll_sorting_block_videos">

                        @foreach ($viewedrvideos as $viewedrvideo)

                            <div class="longvideos_scroll_sorting_block_videos_fixed">
                                <div class="main_novost_allvideo">
                                    <a href="{{ route('videouser', ['id' => $viewedrvideo->id]) }}">
                                        @csrf

                                        <div class="longvideos_video_thumbnail">
                                            <img src="{{ asset('storage/' . $viewedrvideo->thumbnail_path) }}"
                                                alt="Thumbnail" style="object-fit:contain;" class="videoThumbnail"
                                                style="cursor:pointer;">
                                            <div class="longvideos_video_thumbnail_title">
                                                <p class="txt_2">{{ $viewedrvideo->title }}</p>
                                            </div>
                                            <div class="longvideos_thumbnail_dopinfo_formain">
                                                <p class="lv_name">{{ $viewedrvideo->user->name }}</p>
                                                <p class="lv_avatar">
                                                    @if ($viewedrvideo->user->avatar !== null)
                                                        <img class="avatar"
                                                            src="{{ asset('storage/' . $viewedrvideo->user->avatar) }}"
                                                            alt="Avatar">
                                                    @else
                                                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png"
                                                            alt="Avatar">
                                                    @endif
                                                </p>
                                                <p class="lv_description">{{ $viewedrvideo->description }}</p>


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
                                                    $createdAt = strtotime($viewedrvideo->created_at);
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
                                                <p class="lv_created_at">{{ $formattedTime }}</p>
                                            </div>
                                        </div>

                                    </a>
                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>





            </div>


        </div>


        <script>
            let lastThumbnailSrc = "";
            let lastTitle = "";
            let lastAvatar = "";
            let lastName = "";
            let lastDescription = "";
            let lastCreatedAt = "";

            const hoverThumbnail = document.querySelector('.videoThumbnail_main');
            const hoverTitle = document.querySelector('.longvideos_thumbnail_title');
            const hoverAvatar = document.querySelector('.longvideos_thumbnail_avatar');
            const hoverName = document.querySelector('.longvideos_thumbnail_name');
            const hoverDescription = document.querySelector('.longvideos_thumbnail_description_text');
            const hoverCreatedAt = document.querySelector('.longvideos_thumbnail_created_at p');

            const hoverDopinfo1 = document.querySelector('.longvideos_thumbnail_info');
            const hoverDopinfo2 = document.querySelector('.longvideos_thumbnail_top');

            document.addEventListener("DOMContentLoaded", function() {
                const mainNovostAllVideos = document.querySelectorAll('.main_novost_allvideo');
                let isHovered = false;

                mainNovostAllVideos.forEach(videoElement => {
                    videoElement.addEventListener('mouseenter', () => {
                        isHovered = true;
                        const thumbnail = videoElement.querySelector('.videoThumbnail');
                        lastThumbnailSrc = thumbnail.getAttribute('src');
                        const title = videoElement.querySelector(
                            '.longvideos_video_thumbnail_title .txt_2').textContent;
                        lastTitle = title;
                        const avatar = videoElement.querySelector('.lv_avatar').textContent;
                        lastAvatar = avatar;
                        const name = videoElement.querySelector('.lv_name').textContent;
                        lastName = name;
                        const description = videoElement.querySelector('.lv_description').textContent;
                        lastDescription = description;
                        const createdAt = videoElement.querySelector('.lv_created_at').textContent;
                        lastCreatedAt = createdAt;

                        hoverThumbnail.classList.add('hide');
                        hoverTitle.classList.add('hide');
                        hoverAvatar.classList.add('hide');
                        hoverName.classList.add('hide');
                        hoverDescription.classList.add('hide');
                        hoverCreatedAt.classList.add('hide');

                        hoverDopinfo1.classList.add('hide', 'show');
                        hoverDopinfo2.classList.add('hide', 'show');

                        hoverThumbnail.addEventListener('transitionend', updateThumbnail);
                        hoverTitle.addEventListener('transitionend', updateTitle);
                        hoverAvatar.addEventListener('transitionend', updateAvatar);
                        hoverName.addEventListener('transitionend', updateName);
                        hoverDescription.addEventListener('transitionend', updateDescription);
                        hoverCreatedAt.addEventListener('transitionend', updateCreatedAt);

                        hoverDopinfo1.addEventListener('transitionend', updateDopinfo1);
                        hoverDopinfo2.addEventListener('transitionend', updateDopinfo2);
                    });

                    videoElement.addEventListener('mouseleave', () => {
                        isHovered = false;
                    });
                });
            });

            function updateThumbnail() {
                hoverThumbnail.setAttribute('src', lastThumbnailSrc);
                hoverThumbnail.classList.remove('hide');
                hoverThumbnail.removeEventListener('transitionend', updateThumbnail);
            }

            function updateTitle() {
                hoverTitle.textContent = lastTitle;
                hoverTitle.classList.remove('hide');
                hoverTitle.removeEventListener('transitionend', updateTitle);
            }

            function updateAvatar() {
                hoverAvatar.textContent = lastAvatar;
                hoverAvatar.classList.remove('hide');
                hoverAvatar.removeEventListener('transitionend', updateAvatar);
            }

            function updateName() {
                hoverName.textContent = lastName;
                hoverName.classList.remove('hide');
                hoverName.removeEventListener('transitionend', updateName);
            }

            function updateDescription() {
                hoverDescription.textContent = lastDescription;
                hoverDescription.classList.remove('hide');
                hoverDescription.removeEventListener('transitionend', updateDescription);
            }

            function updateCreatedAt() {
                hoverCreatedAt.textContent = lastCreatedAt;
                hoverCreatedAt.classList.remove('hide');
                hoverCreatedAt.removeEventListener('transitionend', updateCreatedAt);
            }

            function updateDopinfo1() {
                hoverDopinfo1.classList.remove('hide');
                hoverDopinfo1.removeEventListener('transitionend', updateDopinfo1);
            }

            function updateDopinfo2() {
                hoverDopinfo2.classList.remove('hide');
                hoverDopinfo2.removeEventListener('transitionend', updateDopinfo2);
            }
        </script>



        <script>
            document.addEventListener('DOMContentLoaded', function() {

                var categoryButtons = document.querySelectorAll('.longvideos_categories_btn');

                var selectedCategory = localStorage.getItem('selectedCategory');

                var currentUrl = window.location.href;

                if (!currentUrl.includes('category')) {
                    selectedCategory = null;
                    localStorage.removeItem('selectedCategory');
                }

                if (selectedCategory) {
                    categoryButtons.forEach(function(button) {
                        if (button.value === selectedCategory) {
                            button.classList.add('select');
                        }
                    });
                }

                categoryButtons.forEach(function(button) {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();

                        categoryButtons.forEach(function(btn) {
                            btn.classList.remove('select');
                        });

                        button.classList.add('select');

                        var category = button.value;

                        localStorage.setItem('selectedCategory', category);

                        var hiddenField = document.createElement('input');
                        hiddenField.type = 'hidden';
                        hiddenField.name = 'category';
                        hiddenField.value = category;

                        var form = document.getElementById('categoryForm');
                        form.appendChild(hiddenField);

                        form.submit();
                    });
                });
            });
        </script>





</x-app-layout>