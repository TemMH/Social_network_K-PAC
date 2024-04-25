<x-app-layout>
    <x-slot name="header">

    </x-slot>






    <div class="longvideos_field">
        @for ($i = 0; $i < min(count($videos), 1); $i++)
            @php $video = $videos[$i]; @endphp
            @if ($video->status == 'true')
                <div class="longvideos_thumbnail">


                    <div class="blurred_bottom"></div>
                    <div class="longvideos_thumbnail_info show">
                        <div class="longvideos_thumbnail_top show">


                            <h1 class="longvideos_thumbnail_title">
                                {{ $video->title }}
                            </h1>

                            <div class="longvideos_thumbnail_dopinfo">

                                <div class="longvideos_thumbnail_avatar">

                                </div>
                                <div class="longvideos_thumbnail_name">
                             

                                        {{ $video->user->name }}

                              
                                </div>
                                <div class="longvideos_thumbnail_created_at">
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
                                        $createdAt = strtotime($video->created_at);
                                        $currentDate = strtotime(date('Y-m-d H:i:s'));
                                        $timeDiff = $currentDate - $createdAt;

                                        if ($timeDiff >= 86400) {
                                            $days = floor($timeDiff / 86400);
                                            $formattedTime =
                                                $days . ' ' . pluralForm($days, 'день', 'дня', 'дней') . ' назад';
                                        } elseif ($timeDiff >= 3600) {
                                            $hours = floor($timeDiff / 3600);
                                            $formattedTime =
                                                $hours . ' ' . pluralForm($hours, 'час', 'часа', 'часов') . ' назад';
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


                              
                                    {{ $video->description }}
                               


                            </div>
                        </details>

                    </div>

                    <div style="position: absolute" class=""></div>

                    <img src="{{ asset('storage/' . $video->thumbnail_path) }}" alt=" "
                        style="object-fit: cover;" class="videoThumbnail_main">

                </div>
            @endif
        @endfor

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

                    <div class="longvideos_scroll_sorting_block_name">Недавние</div>
                    <div class="longvideos_scroll_sorting_block_videos">

                        @for ($i = 0; $i < min(count($videos), 4); $i++)
                            @php $video = $videos[$i]; @endphp
                            @if ($video->status == 'true')
                                <div class="longvideos_scroll_sorting_block_videos_fixed">
                                    <div class="main_novost_allvideo">
                                        <a href="{{ route('videouser', ['id' => $video->id]) }}">
                                            @csrf

                                            <div class="longvideos_video_thumbnail">
                                                <img src="{{ asset('storage/' . $video->thumbnail_path) }}"
                                                    alt="Thumbnail" style="object-fit:contain;" class="videoThumbnail"
                                                    style="cursor:pointer;">
                                                <div class="longvideos_video_thumbnail_title">
                                                    <p class="txt_2">{{ $video->title }}</p>
                                                </div>
                                                <div class="longvideos_thumbnail_dopinfo_formain">
                                                    <p class="lv_name">{{ $video->user->name }}</p>
                                                    <p class="lv_avatar">
                                                        @if ($video->user->avatar !== null)
                                                            <img class="avatar"
                                                                src="{{ asset('storage/' . $video->user->avatar) }}"
                                                                alt="Avatar">
                                                        @else
                                                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png"
                                                                alt="Avatar">
                                                        @endif
                                                    </p>
                                                    <p class="lv_description">{{ $video->description }}</p>


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
                                                        $createdAt = strtotime($video->created_at);
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
                            @endif
                        @endfor

                    </div>
                </div>

                <div class="longvideos_scroll_sorting_block">

                    <div class="longvideos_scroll_sorting_block_name">Тренд</div>
                    <div class="longvideos_scroll_sorting_block_videos">
                        @for ($i = 0; $i < min(count($videos), 4); $i++)
                            @php $video = $videos[$i]; @endphp
                            @if ($video->status == 'true')
                                <div class="longvideos_scroll_sorting_block_videos_fixed">
                                    <div class="main_novost_allvideo">
                                        <a href="{{ route('videouser', ['id' => $video->id]) }}">
                                            @csrf

                                            <div class="longvideos_video_thumbnail">
                                                <img src="{{ asset('storage/' . $video->thumbnail_path) }}"
                                                    alt="Thumbnail" style="object-fit:contain;" class="videoThumbnail"
                                                    style="cursor:pointer;">
                                                <div class="longvideos_video_thumbnail_title">
                                                    <p class="txt_2">{{ $video->title }}</p>
                                                </div>
                                                <div class="longvideos_thumbnail_dopinfo_formain">
                                                    <p class="lv_name">{{ $video->user->name }}</p>
                                                    <p class="lv_avatar">
                                                        @if ($video->user->avatar !== null)
                                                            <img class="avatar"
                                                                src="{{ asset('storage/' . $video->user->avatar) }}"
                                                                alt="Avatar">
                                                        @else
                                                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png"
                                                                alt="Avatar">
                                                        @endif
                                                    </p>
                                                    <p class="lv_description">{{ $video->description }}</p>


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
                                                        $createdAt = strtotime($video->created_at);
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
                            @endif
                        @endfor

                    </div>
                </div>
                <div class="longvideos_scroll_sorting_block">

                    <div class="longvideos_scroll_sorting_block_name">Популярные</div>
                    <div class="longvideos_scroll_sorting_block_videos">
                        @for ($i = 0; $i < min(count($videos), 4); $i++)
                            @php $video = $videos[$i]; @endphp
                            @if ($video->status == 'true')
                                <div class="longvideos_scroll_sorting_block_videos_fixed">
                                    <div class="main_novost_allvideo">
                                        <a href="{{ route('videouser', ['id' => $video->id]) }}">
                                            @csrf

                                            <div class="longvideos_video_thumbnail">
                                                <img src="{{ asset('storage/' . $video->thumbnail_path) }}"
                                                    alt="Thumbnail" style="object-fit:contain;" class="videoThumbnail"
                                                    style="cursor:pointer;">
                                                <div class="longvideos_video_thumbnail_title">
                                                    <p class="txt_2">{{ $video->title }}</p>
                                                </div>
                                                <div class="longvideos_thumbnail_dopinfo_formain">
                                                    <p class="lv_name">{{ $video->user->name }}</p>
                                                    <p class="lv_avatar">
                                                        @if ($video->user->avatar !== null)
                                                            <img class="avatar"
                                                                src="{{ asset('storage/' . $video->user->avatar) }}"
                                                                alt="Avatar">
                                                        @else
                                                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png"
                                                                alt="Avatar">
                                                        @endif
                                                    </p>
                                                    <p class="lv_description">{{ $video->description }}</p>


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
                                                        $createdAt = strtotime($video->created_at);
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
                            @endif
                        @endfor

                    </div>
                </div>
                <div class="longvideos_scroll_sorting_block">

                    <div class="longvideos_scroll_sorting_block_name">Просмотрено</div>
                    <div class="longvideos_scroll_sorting_block_videos">
                        @for ($i = 0; $i < min(count($videos), 4); $i++)
                            @php $video = $videos[$i]; @endphp
                            @if ($video->status == 'true')
                                <div class="longvideos_scroll_sorting_block_videos_fixed">
                                    <div class="main_novost_allvideo">
                                        <a href="{{ route('videouser', ['id' => $video->id]) }}">
                                            @csrf

                                            <div class="longvideos_video_thumbnail">
                                                <img src="{{ asset('storage/' . $video->thumbnail_path) }}"
                                                    alt="Thumbnail" style="object-fit:contain;"
                                                    class="videoThumbnail" style="cursor:pointer;">
                                                <div class="longvideos_video_thumbnail_title">
                                                    <p class="txt_2">{{ $video->title }}</p>
                                                </div>
                                                <div class="longvideos_thumbnail_dopinfo_formain">
                                                    <p class="lv_name">{{ $video->user->name }}</p>
                                                    <p class="lv_avatar">
                                                        @if ($video->user->avatar !== null)
                                                            <img class="avatar"
                                                                src="{{ asset('storage/' . $video->user->avatar) }}"
                                                                alt="Avatar">
                                                        @else
                                                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png"
                                                                alt="Avatar">
                                                        @endif
                                                    </p>
                                                    <p class="lv_description">{{ $video->description }}</p>
                                                    

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
                                                        $createdAt = strtotime($video->created_at);
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
                            @endif
                        @endfor

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


{{-- Категории-сортировка
    
    <div class="main_filter_video">
                <div class="main_filter1">
                    <form method="GET" action="{{ url()->current() }}">
                        @csrf



                        <div class="sortirovka">
                            <label for="sortirovka">Выберите сортировку</label>
                            <select class="custom-select-video" name="sortirovka" id="sortirovka">
                                <option value="recent">Сначала недавние</option>
                                <option value="old">Сначала старые</option>
                                <option value="popular">Сначала популярные</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <button type="submit" class="btn_1">Применить</button>
                        </div>
                    </form>
                </div>
            </div>
            
            
--}}

{{-- 
                
                @if (auth()->user()->permission == 'enabled')
            <a href="{{ route('newvideo') }}">
                <div class="main_new_novo_video">
                    <p class="txt_2">Опубликовать видео</p>
                </div>
            </a>
        @endif 
        
        
--}}
