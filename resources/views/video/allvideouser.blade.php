<x-app-layout>
    <x-slot name="header">

    </x-slot>






    <div class="longvideos_field">

        <div class="longvideos_thumbnail">


            <div class="blurred_bottom"></div>
            <div class="longvideos_thumbnail_info">
                <div class="longvideos_thumbnail_top">


                    <h1 class="longvideos_thumbnail_title">TESTTESTTESTTESTTEST</h1>

                    <div class="longvideos_thumbnail_dopinfoo">

                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png" width="50px" height="50px">
                        <p>НИКНЕЙМ</p>
                        <p>00.00.0000</p>

                    </div>

                </div>

                <div class="longvideos_thumbnail_description">
                    <p>ОПИСАНИЕ С РАСКРЫВАЮЩИМ СПИСКОМ</p>
                </div>

            </div>

            <div style="position: absolute" class=""></div>
            {{-- object-fit: cover; --}}
            <img src="http://127.0.0.1:8000/storage/thumbnails/thumbnail_1710888252.jpg" alt="Thumbnail"
                style="object-fit: cover;" class="videoThumbnail">

        </div>

        <div class="longvideos_selections">

            <div class="longvideos_categories">

                <div class="category">
                    <select class="custom-select-video" name="category" id="category">
                        <option value="">Все категории</option>
                        <option value="Спорт">Спорт</option>
                        <option value="Игры">Игры</option>
                        <option value="Экономика">Экономика</option>
                        <option value="Транспорт">Транспорт</option>
                    </select>
                </div>

            </div>
            <div class="longvideos_scroll_lock">



                <div class="longvideos_scroll_sorting_block">

                    <div class="longvideos_scroll_sorting_block_name">Недавние</div>
                    <div class="longvideos_scroll_sorting_block_videos">
                        @php $count = 0; @endphp
                        @for ($i = 0; $i < count($videos); $i += 4)

                            @for ($j = $i; $j < $i + 4 && $j < count($videos); $j++)
                                @php $video = $videos[$j]; @endphp
                                @if ($video->status == 'true')
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
                                            </div>

                                        </a>
                                    </div>
                                @endif
                            @endfor

                        @endfor
                    </div>
                </div>

                <div class="longvideos_scroll_sorting_block">

                    <div class="longvideos_scroll_sorting_block_name">Тренд</div>
                    <div class="longvideos_scroll_sorting_block_videos">
                        @php $count = 0; @endphp
                        @for ($i = 0; $i < count($videos); $i += 4)

                            @for ($j = $i; $j < $i + 4 && $j < count($videos); $j++)
                                @php $video = $videos[$j]; @endphp
                                @if ($video->status == 'true')
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
                                            </div>

                                        </a>
                                    </div>
                                @endif
                            @endfor

                        @endfor
                    </div>
                </div>
                <div class="longvideos_scroll_sorting_block">

                    <div class="longvideos_scroll_sorting_block_name">Популярные</div>
                    <div class="longvideos_scroll_sorting_block_videos">
                        @php $count = 0; @endphp
                        @for ($i = 0; $i < count($videos); $i += 4)

                            @for ($j = $i; $j < $i + 4 && $j < count($videos); $j++)
                                @php $video = $videos[$j]; @endphp
                                @if ($video->status == 'true')
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
                                            </div>

                                        </a>
                                    </div>
                                @endif
                            @endfor

                        @endfor
                    </div>
                </div>
                <div class="longvideos_scroll_sorting_block">

                    <div class="longvideos_scroll_sorting_block_name">Просмотрено</div>
                    <div class="longvideos_scroll_sorting_block_videos">
                        @php $count = 0; @endphp
                        @for ($i = 0; $i < count($videos); $i += 4)

                            @for ($j = $i; $j < $i + 4 && $j < count($videos); $j++)
                                @php $video = $videos[$j]; @endphp
                                @if ($video->status == 'true')
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
                                            </div>

                                        </a>
                                    </div>
                                @endif
                            @endfor

                        @endfor
                    </div>
                </div>





            </div>


        </div>




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




{{-- Скоректированная дата
            
            
            <div class="main_video_info_2">

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

            <p class="txt_2">ㅤ{{ $formattedTime }}</p>

        </div> 
        
        
--}}
