<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="reports_field_setting">

        <div class="statements_settings">

            <div class="statements_settings_left">

                <button onclick="location.href='{{ route('reports') }}';"
                    class="statements_type_btn {{ Route::is('reports') ? 'selected' : '' }}">Жалобы</button>
                <button onclick="location.href='{{ route('admin.navigation.statements') }}';"
                    class="statements_type_btn {{ Route::is('admin.navigation.statements') ? 'selected' : '' }}">Фотоматериалы</button>
                <button onclick="location.href='{{ route('admin.navigation.videos') }}';"
                    class="statements_type_btn {{ Route::is('admin.navigation.videos') ? 'selected' : '' }}">Видеоматериалы</button>
                <button onclick="location.href='{{ route('admin.navigation.users') }}';"
                    class="statements_type_btn {{ Route::is('admin.navigation.users') ? 'selected' : '' }}">Пользователи</button>

            </div>


            <div class="reports_settings_middle">

                <input type="text" id="search" name="search" class="message_history_input_container"
                    placeholder="Введите название...">

            </div>



            <form class="statements_settings_right" id="categoryForm" method="GET" action="{{ url()->current() }}">
                <button name="status" value="" class="statements_categories_btn">Все</button>
                <button name="status" value="new" class="statements_categories_btn">Доступные</button>
                <button name="status" value="block" class="statements_categories_btn">Заблокированные</button>
                <button name="status" value="unblock" class="statements_categories_btn">Разрешенные</button>
            </form>







        </div>






    </div>
    <div class="friendfeed_field_test">
        <div class="reports_field_frame_test">

            {{-- Видеоматериалы --}}

            @if (Route::is('admin.navigation.videos'))
                <div class="notification_block_contents_wrap">

                    <div class="profileuser_block_contents_second_wrap_title">
                        <p>Видеоматериалы</p>
                    </div>

                    <div class="right_block_wrap_line"></div>


                </div>


                @foreach ($videos as $video)
                    <div class="report_content_test">

                        <div class="report_block_top_open">


                            <div class="report_block_top_info_left_open">



                                <div class="statement_block_top_image_open">
                                    <img src="{{ asset('storage/' . $video->thumbnail_path) }}" alt="Thumbnail"
                                        style="object-fit:contain;" class="videoThumbnail" style="cursor:pointer;">
                                </div>

                                <div class="statement_block_top_addinfo">

                                    <div class="statement_block_top_addinfo_first">

                                        <p> {{ $video->title }} </p>

                                    </div>


                                    <div class="statement_block_top_addinfo_second">

                                        <div class="statement_block_top_avatar_open">
                                            @if ($video->user->avatar !== null)
                                                <img class="avatar_mini"
                                                    src="{{ asset('storage/' . $video->user->avatar) }}"
                                                    alt="Avatar">
                                            @else
                                                <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                            @endif
                                        </div>


                                        <p>{{ $video->user->name }}</p>

                                    </div>

                                    <div class="statement_block_top_addinfo">


                                        <p>{{ $video->created_at }}</p>

                                    </div>

                                </div>
                            </div>

                            <div class="report_block_top_info_right_open">
                                {{-- <p>Статус:</p> --}}
                                <form action="{{ route('complaint.post.video', $video) }}" style="display: flex; flex-direction:column; align-items:flex-end;" method="POST">

                                    @csrf

                                    <select class="message_history_input_container" name="edit_status"
                                        id="edit_status">
                                        <option value="unblock">Разрешить</option>
                                        <option value="block">Заблокировать</option>
                                    </select>
                                    <button type="submit" class="statements_categories_btn">Применить</button>
                                </form>
                                
                            </div>



                        </div>


                        <div class="report_block_down_open">


                            <div class="statement_block_down_views_open">
                                <p>Статус: </p>
                            </div>

                            <div class="statement_block_down_description_open" style="display: flex;">

                                <form onclick="confirmVideoRemove('{{ $video->title }}', event)"
                                    action="{{ route('admin.video.delete', $video) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button id="removeVideoForm" class="statements_categories_btn">Удалить
                                        видео</button>
                                </form>
                                
                            </div>


                        </div>

                    </div>
                @endforeach
            @endif

            <script>
                function confirmVideoRemove(title, event) {
                    if (!confirm('Вы уверены, что хотите удалить видео ' + title + ' ?')) {
                        event.preventDefault();
                    }
                }
            </script>
            {{-- Фотоматериалы --}}



            @if (Route::is('admin.navigation.statements'))
                <div class="notification_block_contents_wrap">

                    <div class="profileuser_block_contents_second_wrap_title">
                        <p>Фотоматериалы</p>
                    </div>

                    <div class="right_block_wrap_line"></div>


                </div>

                @foreach ($statements as $statement)
                    <div class="report_content_test">

                        <div class="report_block_top_open">


                            <div class="report_block_top_info_left_open">



                                <div class="statement_block_top_image_open">
                                    <img src="{{ asset('storage/' . $statement->photo_path) }}" alt="Thumbnail"
                                        style="object-fit:contain;" class="videoThumbnail" style="cursor:pointer;">
                                </div>

                                <div class="statement_block_top_addinfo">

                                    <div class="statement_block_top_addinfo_first">

                                        <p>{{ $statement->title }}</p>

                                    </div>


                                    <div class="statement_block_top_addinfo_second">

                                        <div class="statement_block_top_avatar_open">
                                            @if ($statement->user->avatar !== null)
                                                <img class="avatar_mini"
                                                    src="{{ asset('storage/' . $statement->user->avatar) }}"
                                                    alt="Avatar">
                                            @else
                                                <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                            @endif
                                        </div>

                                        <p>{{ $statement->user->name }}</p>

                                    </div>

                                    <div class="statement_block_top_addinfo">


                                        <p>{{ $statement->created_at }}</p>

                                    </div>

                                </div>
                            </div>

                            <div class="report_block_top_info_right_open">
                                {{-- <p>Статус:</p> --}}
                                <form action="{{ route('complaint.post.statement', $statement) }}" method="POST">

                                    @csrf

                                    <select class="message_history_input_container" name="edit_status"
                                        id="edit_status">
                                        <option value="unblock">Разрешить</option>
                                        <option value="block">Заблокировать</option>
                                    </select>
                                    <button type="submit" class="statements_categories_btn">Применить</button>
                                </form>
                            </div>



                        </div>


                        <div class="report_block_down_open">

                            <div class="statement_block_down_views_open">
                                <p>Статус: </p>
                            </div>

                            <div class="statement_block_down_description_open" style="display: flex;">


                                <form onclick="confirmStatementRemove('{{ $statement->title }}', event)"
                                    action="{{ route('admin.statement.delete', $statement) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button id="removeStatementForm" class="statements_categories_btn">Удалить
                                        фотоматериал</button>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            @endif
            <script>
                function confirmStatementRemove(title, event) {
                    if (!confirm('Вы уверены, что хотите удалить запись "' + title + '"?')) {
                        event.preventDefault();
                    }
                }
            </script>




            {{-- Пользователи --}}


            @if (Route::is('admin.navigation.users'))
                <div class="notification_block_contents_wrap">

                    <div class="profileuser_block_contents_second_wrap_title">
                        <p>Пользователи</p>
                    </div>

                    <div class="right_block_wrap_line"></div>


                </div>


                @foreach ($users as $user)
                    <div class="report_content_test">

                        <div class="report_block_top_open">


                            <div class="report_block_top_info_left_open">



                                <div class="statement_block_top_user_image_open">
                                    @if ($user->avatar !== null)
                                        <img class="avatar_mini" src="{{ asset('storage/' . $user->avatar) }}"
                                            alt="Avatar">
                                    @else
                                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                    @endif
                                </div>

                                <div class="statement_block_top_addinfo">

                                    <div class="statement_block_top_addinfo">

                                        <p>{{ $user->name }}</p>

                                    </div>


                                    <div class="statement_block_top_addinfo">


                                        <p>{{ $user->condition }}</p>

                                    </div>

                                    <div class="statement_block_top_addinfo">


                                        <p>{{ $user->created_at }}</p>

                                    </div>

                                </div>
                            </div>

                            <div class="report_block_top_info_right_open">

                                {{-- <p>Статус:</p> --}}

                                <form action="{{ route('complaint.post.user', $user) }}" method="POST">

                                    @csrf

                                    <select class="message_history_input_container" name="edit_status"
                                        id="edit_status">
                                        <option value="unblock">Разрешить</option>
                                        <option value="block">Заблокировать</option>
                                    </select>
                                    <button type="submit" class="statements_categories_btn">Применить</button>
                                </form>
                            </div>



                        </div>


                        <div class="report_block_down_open">

                            <div class="statement_block_down_views_open">
                                <p>Статус: </p>
                            </div>

                            <div class="statement_block_down_description_open" style="display: flex;">


                                <form onclick="confirmUserRemove('{{ $user->name }}', event)"
                                    action="{{ route('admin.user.delete', $user) }}" method="post">

                                    @method('DELETE')
                                    @csrf

                                    <button id="removeUserForm" class="statements_categories_btn">Удалить
                                        пользователя</button>

                                </form>

                            </div>
                        </div>

                    </div>
                @endforeach
            @endif
            <script>
                function confirmUserRemove(name, event) {
                    if (!confirm('Вы уверены, что хотите удалить пользователя "' + name + '"?')) {
                        event.preventDefault();
                    }
                }
            </script>






        </div>


    </div>



</x-app-layout>
