<x-app-layout>
    <x-slot name="header">

    </x-slot>




    <div class="main">

        <a href="{{ route('newvideo') }}">
            <div class="main_new_novo_neutral">

                <p class="txt_2">Опубликовать свою видео</p>

            </div>
        </a>



        <div class="main_myosnova">
            @foreach ($videos as $video)
                @if ($video->status == 'new')
                    <div class="main_novost">
                        <form method="POST" action="{{ route('statuseditvideo', ['id' => $video->id]) }}">
                            @csrf
                            <div class="main_novost_top">
                                <div class="main_novost_img">
                                    <a href="{{ route('profileuser.profile', ['id' => $video->user_id]) }}">
                                        <img class="avatar" src="{{ asset('storage/' . $video->user->avatar) }}"
                                            alt="Avatar">
                                    </a>
                                </div>



                                <div class="main_novost_zagolovok">
                                    <div> 
                                        {{-- <a href="{{ route('videouser', ['id' => $video->id]) }}"> --}}
                                            <p class="txt_2">{{ $video->title }}</p>
                                        {{-- </a> --}}
                                    </div>
                                    <div class="flex">
                                        <a href="{{ route('profileuser.profile', ['id' => $video->user_id]) }}">
                                            <p class="txt_2">{{ $video->user->name }}</p>
                                        </a>
                                        <p class="txt_2">ㅤ{{ $video->created_at }}</p>
                                    </div>

                                </div>
                            </div>



                            <div class="main_novost_middle">
                                {{-- <a href="{{ route('videouser', ['id' => $video->id]) }}"> --}}
                                    <p class="txt_2">{{ $video->description }}</p>
                                {{-- </a> --}}

                                @if ($video->category !== null)
                                    <p class="txt_2">Категория: {{ $video->category }}</p>
                                @endif
                            </div>
                            <div class="main_novost_down">
                                <div class="novost_down_func">
                                    <p> {{ $video->status }}</p>
                                </div>
                                <input type="hidden" name="id" value={{ $video->id }}>
                                <div class="status">
                                    <label class="txt_2" for="status">Выберите статус</label>
                                    <select class="custom-select" name="status" id="status">
                                        <option value="true">Принято</option>
                                        <option value="false">Отказ</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <button class="txt_2" type="submit" class="btn btn-dark">Сохранить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            @endforeach
        </div>


    </div>



</x-app-layout>
