<x-app-layout>
    <x-slot name="header">

    </x-slot>




    <div class="main">

        <a href="{{ route('newzayavka') }}">
            <div class="main_new_novo">

                <p class="txt_2">Предложите свою новость</p>

            </div>
        </a>



        <div class="main_myosnova">
            @foreach ($zayavkas as $zayavka)
                @if ($zayavka->status == 'new')
                    <div class="main_novost">
                        <form method="POST" action="{{ route('statusedit', ['id' => $zayavka->id]) }}">
                            @csrf
                            <div class="main_novost_top">
                                <div class="main_novost_img">
                                    <a href="{{ route('profileuser.profile', ['id' => $zayavka->user_id]) }}">
                                        <img class="avatar" src="{{ asset('storage/' . $zayavka->user->avatar) }}"
                                            alt="Avatar">
                                    </a>
                                </div>



                                <div class="main_novost_zagolovok">
                                    <div> <a href="{{ route('zayavkauser', ['id' => $zayavka->id]) }}">
                                            <p class="txt_2">{{ $zayavka->zagolovok }}</p>
                                        </a>
                                    </div>
                                    <div class="flex">
                                        <a href="{{ route('profileuser.profile', ['id' => $zayavka->user_id]) }}">
                                            <p class="txt_2">{{ $zayavka->name }}</p>
                                        </a>
                                        <p class="txt_2">ㅤ{{ $zayavka->created_at }}</p>
                                    </div>

                                </div>
                            </div>
                            <div class="main_novost_middle">
                                <a href="{{ route('zayavkauser', ['id' => $zayavka->id]) }}">
                                    <p class="txt_2">{{ $zayavka->description }}</p>
                                </a>

                                @if ($zayavka->category !== null)
                                    <p class="txt_2">Категория: {{ $zayavka->category }}</p>
                                @endif
                            </div>
                            <div class="main_novost_down">
                                <div class="novost_down_func">
                                    <p> {{ $zayavka->status }}</p>
                                </div>
                                <input type="hidden" name="id" value={{ $zayavka->id }}>
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
