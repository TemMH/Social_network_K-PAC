<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">

        </h2>
    </x-slot>




    <div class="main">



        <div class="main_osnova_allusers">
            <div class="useriii">
                @foreach ($users as $user)
                    <div class="main_novost">

                        <div class="main_novost_top">
                            <div class="main_novost_img">
                                <a href="{{ route('profileuser.profile', ['id' => $user->id]) }}">
                                    <img class="avatar" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar">
                                </a>
                            </div>

                            <div class="main_novost_zagolovok">
                                <div> <a href="{{ route('profileuser.profile', ['id' => $user->id]) }}">

                                        <p class="txt_2">{{ $user->name }}</p>
                                    </a>
                                </div>
                                <div>
                                    <p class="txt_2">{{ $user->created_at }}</p>
                                </div>
                            </div>

                        </div>
                        <div class="main_novost_middle">
                            <p class="txt_2">{{ $user->condition }}</p>
                        </div>
                        <div class="main_novost_down">
                            <form method="POST" action="{{ route('permissionedit', ['id' => $user->id]) }}">
                                @csrf
                                <div class="main_novost_down">

                                    <div class="novost_down_func">

                                        <p class="txt_2"> {{ $user->permission }}</p>



                                    </div>


                                    <input type="hidden" name="id" value="{{ $user->id }}">

                                    <div class="status">
                                        <label class="txt_2" for="permission">Запреты</label>
                                        <select class="custom-select" name="permission" id="permission">
                                            <option value="enabled">Разрешить предлагать новости</option>
                                            <option value="disabled">Запретить предлагать новости</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <button class="txt_2" type="submit" class="btn btn-dark">Сохранить</button>
                                    </div>

                                </div>
                            </form>
                            <div class="novost_down_func">
                                <form method="POST" action="{{ route('deleteUser', ['id' => $user->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Удалить пользователя</button>
                                </form>
                            </div>



                        </div>

                    </div>
                @endforeach
            </div>


            <div class="main_filter">
                <form method="GET" action="{{ route('usersort') }}">
                    @csrf
                    <input type="hidden" name="id" value={{ $user->id }}>
                    <div class="sortirovka">
                        <label class="txt_2" for="main_filter_drop">Выберите сортировку</label>
                        <select class="custom-select" name="sortirovka" id="sortirovka">
                            <option value="recent">Сначала недавние</option>
                            <option value="old">Сначала старые</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <button class="btn_1" type="submit" class="btn btn-dark">Применить</button>
                    </div>
                </form>
            </div>

        </div>

    </div>



</x-app-layout>
