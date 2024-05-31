<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="reports_field_setting">

        <div class="statements_settings">

            <div class="statements_settings_left">

                <button onclick="location.href='{{ route('reports') }}';"
                class="long_button {{ Route::is('reports') ? 'selected' : '' }}">Жалобы</button>

                @if (auth()->user()->role == 'Admin')

                <button onclick="location.href='{{ route('admin.navigation.statements') }}';"
                    class="long_button {{ Route::is('admin.navigation.statements') ? 'selected' : '' }}">Фотоматериалы</button>
                <button onclick="location.href='{{ route('admin.navigation.videos') }}';"
                    class="long_button {{ Route::is('admin.navigation.videos') ? 'selected' : '' }}">Видеоматериалы</button>
                <button onclick="location.href='{{ route('admin.navigation.users') }}';"
                    class="long_button {{ Route::is('admin.navigation.users') ? 'selected' : '' }}">Пользователи</button>
                    <button onclick="location.href='{{ route('admin.navigation.create') }}';"
                    class="long_button {{ Route::is('admin.navigation.create') ? 'selected' : '' }}">Добавить</button>

                    @endif


            </div>




            <div class="reports_settings_right">

                <div class="statements_settings_right_btn">



                </div>


            </div>



        </div>



    </div>
    <div class="friendfeed_field">
        <div class="reports_field_frame">
            




            <div class="notification_block_contents_wrap">

                <div class="profileuser_block_contents_second_wrap_title">
                    <p>Видеоматериалы</p>
                </div>

                <div class="right_block_wrap_line"></div>


            </div>

            @if ($reports['video_complaint'])

            <form action="{{ route('complaint.update.video', ['video' => $reports['video_complaint']->video->id]) }}" method="post">

                @method('PUT')
                @csrf
                <div class="report_content">

                    <div class="report_block_top_open">


                        <div class="report_block_top_info_left_open">



                            <div class="statement_block_top_image_open">
                                <img src="{{ asset('storage/' . $reports['video_complaint']->video->thumbnail_path) }}"
                                    alt="Thumbnail" style="object-fit:contain;" class="videoThumbnail"
                                    style="cursor:pointer;">
                            </div>

                            <div class="statement_block_top_addinfo">

                                <div class="statement_block_top_addinfo_first">

                                    <p>{{ $reports['video_complaint']->video->title }}</p>

                                </div>


                                <div class="statement_block_top_addinfo_second">

                                    <div class="statement_block_top_avatar_open">
                                        @if ($reports['video_complaint']->video->user->avatar !== null)
                                            <img class="avatar_mini"
                                                src="{{ asset('storage/' . $reports['video_complaint']->video->user->avatar) }}"
                                                alt="Avatar">
                                        @else
                                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                        @endif
                                    </div>


                                    <p>{{ $reports['video_complaint']->video->user->name }}</p>

                                </div>

                                <div class="statement_block_top_addinfo">


                                    <p>{{ $reports['video_complaint']->video->created_at }}</p>

                                </div>

                            </div>
                        </div>

                        <div class="report_block_top_info_right_open">
                            <p>Статус:</p>
                            <select class="message_history_input_container" name="edit_status" id="edit_status">
                                <option value="rejected">Разрешить</option>
                                <option value="accepted">Заблокировать</option>
                            </select>
                        </div>



                    </div>


                    <div class="report_block_down_open">


                        <div class="statement_block_down_views_open">
                            <p>Частая причина: {{ $videoComplaint->reason->name }}</p>                            
                        <input type="hidden" name="reason_id" value="{{ $videoComplaint->reason->id }}">

                        </div>

                        <div class="statement_block_down_description_open">
                            <button class="statements_categories_btn">Принять</button>
                        </div>

                    </div>

                </div>

            </form>
            @else
                <p>Нет жалоб на видео</p>
            @endif






            <div class="notification_block_contents_wrap">

                <div class="profileuser_block_contents_second_wrap_title">
                    <p>Фотоматериалы</p>
                </div>

                <div class="right_block_wrap_line"></div>


            </div>

            @if ($reports['statement_complaint'])

            <form action="{{ route('complaint.update.statement', ['statement' => $reports['statement_complaint']->statement->id]) }}" method="post">

                @method('PUT')
                @csrf
                <div class="report_content">

                    <div class="report_block_top_open">


                        <div class="report_block_top_info_left_open">



                            <div class="statement_block_top_image_open">
                                <div class="statement_block_top_image_open_test">
                                <img src="{{ asset('storage/' . $reports['statement_complaint']->statement->photo_path) }}"
                                    alt="Thumbnail" style="object-fit:contain;" class="videoThumbnail"
                                    style="cursor:pointer;">
                                </div>
                            </div>

                            <div class="statement_block_top_addinfo">

                                <div class="statement_block_top_addinfo_first">

                                    <p>{{ $reports['statement_complaint']->statement->title }}</p>

                                </div>


                                <div class="statement_block_top_addinfo_second">

                                    <div class="statement_block_top_avatar_open">
                                        @if ($reports['statement_complaint']->statement->user->avatar !== null)
                                            <img class="avatar_mini"
                                                src="{{ asset('storage/' . $reports['statement_complaint']->statement->user->avatar) }}"
                                                alt="Avatar">
                                        @else
                                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                        @endif
                                    </div>

                                    <p>{{ $reports['statement_complaint']->statement->user->name }}</p>

                                </div>

                                <div class="statement_block_top_addinfo">


                                    <p>{{ $reports['statement_complaint']->statement->created_at }}</p>

                                </div>

                            </div>
                        </div>

                        <div class="report_block_top_info_right_open">
                            <p>Статус:</p>
                            <select class="message_history_input_container" name="edit_status" id="edit_status">
                            <option value="rejected">Разрешить</option>
                                <option value="accepted">Заблокировать</option>
                            </select>
                        </div>



                    </div>


                    <div class="report_block_down_open">

                        <div class="statement_block_down_views_open">
                            <p>Частая причина: {{ $statementComplaint->reason->name }}</p>
                        <input type="hidden" name="reason_id" value="{{ $statementComplaint->reason->id }}">

                        </div>

                        <div class="statement_block_down_description_open">
                            <button class="statements_categories_btn">Принять</button>
                        </div>

                    </div>

                </div>
            </form>
            @else
                <p>Нет жалоб на заявление</p>
            @endif






            {{-- user --}}



            <div class="notification_block_contents_wrap">

                <div class="profileuser_block_contents_second_wrap_title">
                    <p>Пользователи</p>
                </div>

                <div class="right_block_wrap_line"></div>


            </div>


            @if ($reports['user_complaint'])

            <form action="{{ route('complaint.update.user', ['user' => $reports['user_complaint']->user->id]) }}" method="post">

                @method('PUT')
                @csrf

                    <div class="report_content">

                        <div class="report_block_top_open">


                            <div class="report_block_top_info_left_open">



                                <div class="statement_block_top_user_image_open">
                                    @if ($reports['user_complaint']->user->avatar !== null)
                                        <img class="avatar_mini"
                                            src="{{ asset('storage/' . $reports['user_complaint']->user->avatar) }}"
                                            alt="Avatar">
                                    @else
                                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                    @endif
                                </div>

                                <div class="statement_block_top_addinfo">

                                    <div class="statement_block_top_addinfo">

                                        <p>{{ $reports['user_complaint']->user->name }}</p>

                                    </div>


                                    <div class="statement_block_top_addinfo">


                                        <p>{{ $reports['user_complaint']->user->condition }}</p>

                                    </div>

                                    <div class="statement_block_top_addinfo">


                                        <p>{{ $reports['user_complaint']->user->created_at }}</p>

                                    </div>

                                </div>
                            </div>

                            <div class="report_block_top_info_right_open">

                                <p>Статус:</p>

                                <select class="message_history_input_container" name="edit_status" id="edit_status">
                                <option value="rejected">Разрешить</option>
                                <option value="accepted">Заблокировать</option>
                                </select>
                            </div>



                        </div>


                        <div class="report_block_down_open">

                            <div class="statement_block_down_views_open">
                            <p>Частая причина: {{ $userComplaint->reason->name }}</p>
                        <input type="hidden" name="reason_id" value="{{ $userComplaint->reason->id }}">
                            </div>

                            <div class="statement_block_down_description_open">
                                <button type="submit" class="statements_categories_btn">Принять</button>
                            </div>

                        </div>

                    </div>

                </form>
            @else
                <p>Нет жалоб на пользователя</p>
            @endif











        </div>


    </div>


</x-app-layout>
