<x-app-layout>
    <x-slot name="header">

    </x-slot>




    <div class="main">

        <a href="{{ route('newstatement') }}">
            <div class="main_new_novo">

                <p class="txt_2">Предложите свою новость</p>

            </div>
        </a>



        <div class="main_myosnova">
            @foreach ($statements as $statement)
                @if ($statement->status == 'new')
                    <div class="main_novost">
                        <form method="POST" action="{{ route('statuseditnews', ['id' => $statement->id]) }}">
                            @csrf
                            <div class="main_novost_top">
                                <div class="main_novost_img">
                                    <a href="{{ route('profileuser.profile', ['id' => $statement->user_id, 'previous' => 'news']) }}">
                                        <img class="avatar" src="{{ asset('storage/' . $statement->user->avatar) }}"
                                            alt="Avatar">
                                    </a>
                                </div>



                                <div class="main_novost_title">
                                    <div> <a href="{{ route('statementuser', ['id' => $statement->id]) }}">
                                            <p class="txt_2">{{ $statement->title }}</p>
                                        </a>
                                    </div>
                                    <div class="flex">
                                        <a href="{{ route('profileuser.profile', ['id' => $statement->user_id, 'previous' => 'news']) }}">
                                            <p class="txt_2">{{ $statement->name }}</p>
                                        </a>
                                        <p class="txt_2">ㅤ{{ $statement->created_at }}</p>
                                    </div>

                                </div>
                            </div>
                            <div class="main_novost_middle">
                                <a href="{{ route('statementuser', ['id' => $statement->id]) }}">
                                    <p class="txt_2">{{ $statement->description }}</p>
                                </a>

                                @if ($statement->category !== null)
                                    <p class="txt_2">Категория: {{ $statement->category }}</p>
                                @endif
                            </div>
                            <div class="main_novost_down">
                                <div class="novost_down_func">
                                    <p> {{ $statement->status }}</p>
                                </div>
                                <input type="hidden" name="id" value={{ $statement->id }}>
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
