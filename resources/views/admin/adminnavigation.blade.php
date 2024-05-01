<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="reports_field_setting">

        <div class="statements_settings">

            <form class="statements_settings_left" id="categoryForm" method="GET">

                <button value="Все" class="statements_categories_btn">Все</button>
                <button value="Фотоматериалы" class="statements_categories_btn">Фотоматериалы</button>
                <button value="Видеоматериалы" class="statements_categories_btn">Видеоматериалы</button>
                <button value="Пользователи" class="statements_categories_btn">Пользователи</button>
            </form>


            <div class="statements_settings_middle" id="categoryForm" method="GET">

                <input type="text" id="title" name="title" required class="message_history_input_container"
                placeholder="Введите заголовок жалобы...">

            </div>

            <div class="reports_settings_right">

                <div class="statements_settings_right_btn">

                    <form class="statements_settings_right" id="categoryForm" method="GET">
                        <button value="Видеоматериалы" class="statements_categories_btn">Доступные</button>
                        <button value="Пользователи" class="statements_categories_btn">Заблокированные</button>
                        <button value="Фотоматериалы" class="statements_categories_btn">Разрешенные</button>


                    </form>

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

                <div class="report_content">

                    <div class="report_block_top_open">


                        <div class="report_block_top_info_left_open">



                            <div class="statement_block_top_image_open">
                                <img src=" 'video->thumbnail_path)'"
                                    alt="Thumbnail" style="object-fit:contain;" class="videoThumbnail"
                                    style="cursor:pointer;">
                            </div>

                            <div class="statement_block_top_addinfo">

                                <div class="statement_block_top_addinfo_first">

                                    <p> '$reports['video_complaint']->video->title' </p>

                                </div>


                                <div class="statement_block_top_addinfo_second">

                                    <div class="statement_block_top_avatar_open">

                                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                           
                                    </div>


                                    <p>' $reports['video_complaint']->video->user->name }}'</p>

                                </div>

                                <div class="statement_block_top_addinfo">


                                    <p>{'{ $reports['video_complaint']->video->created_at }}'</p>

                                </div>

                            </div>
                        </div>

                        <div class="report_block_top_info_right_open">
                            <p>Статус:</p>
                            <select class="message_history_input_container" name="edit_status" id="edit_status">
                                <option value="unblock">Разрешить</option>
                                <option value="block">Заблокировать</option>
                            </select>
                        </div>



                    </div>


                    <div class="report_block_down_open">


                        <div class="statement_block_down_views_open">
                            <p>Частая причина: {'{ $reports['video_complaint']->reason }}'</p>
                        </div>

                        <div class="statement_block_down_description_open">
                            <button class="statements_categories_btn">Принять</button>
                        </div>

                    </div>

                </div>








            <div class="notification_block_contents_wrap">

                <div class="profileuser_block_contents_second_wrap_title">
                    <p>Фотоматериалы</p>
                </div>

                <div class="right_block_wrap_line"></div>


            </div>

                <div class="report_content">

                    <div class="report_block_top_open">


                        <div class="report_block_top_info_left_open">



                            <div class="statement_block_top_image_open">
                                <img src="{'{ asset('storage/' . $reports['statement_complaint']->statement->photo_path) }}'"
                                    alt="Thumbnail" style="object-fit:contain;" class="videoThumbnail"
                                    style="cursor:pointer;">
                            </div>

                            <div class="statement_block_top_addinfo">

                                <div class="statement_block_top_addinfo_first">

                                    <p>{'{ $reports['statement_complaint']->statement->title }}'</p>

                                </div>


                                <div class="statement_block_top_addinfo_second">

                                    <div class="statement_block_top_avatar_open">

                                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                             
                                    </div>

                                    <p>{'{ $reports['statement_complaint']->statement->user->name }}'</p>

                                </div>

                                <div class="statement_block_top_addinfo">


                                    <p>{'{ $reports['statement_complaint']->statement->created_at }}'</p>

                                </div>

                            </div>
                        </div>

                        <div class="report_block_top_info_right_open">
                            <p>Статус:</p>
                            <select class="message_history_input_container" name="edit_status" id="edit_status">
                                <option value="unblock">Разрешить</option>
                                <option value="block">Заблокировать</option>
                            </select>
                        </div>



                    </div>


                    <div class="report_block_down_open">

                        <div class="statement_block_down_views_open">
                            <p>Частая причина: {'{ $reports['statement_complaint']->reason }}'</p>
                        </div>

                        <div class="statement_block_down_description_open">
                            <button class="statements_categories_btn">Принять</button>
                        </div>

                    </div>

                </div>






            {{-- user --}}



            <div class="notification_block_contents_wrap">

                <div class="profileuser_block_contents_second_wrap_title">
                    <p>Пользователи</p>
                </div>

                <div class="right_block_wrap_line"></div>


            </div>


                    <div class="report_content">

                        <div class="report_block_top_open">


                            <div class="report_block_top_info_left_open">



                                <div class="statement_block_top_user_image_open">
                                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                      
                                </div>

                                <div class="statement_block_top_addinfo">

                                    <div class="statement_block_top_addinfo">

                                        <p>{'{ $reports['user_complaint']->user->name }}'</p>

                                    </div>


                                    <div class="statement_block_top_addinfo">


                                        <p>{'{ $reports['user_complaint']->user->condition }}'</p>

                                    </div>

                                    <div class="statement_block_top_addinfo">


                                        <p>{'{ $reports['user_complaint']->user->created_at }}'</p>

                                    </div>

                                </div>
                            </div>

                            <div class="report_block_top_info_right_open">

                                <p>Статус:</p>

                                <select class="message_history_input_container" name="edit_status" id="edit_status">
                                    <option value="unblock">Разрешить</option>
                                    <option value="block">Заблокировать</option>
                                </select>
                            </div>



                        </div>


                        <div class="report_block_down_open">

                            <div class="statement_block_down_views_open">
                                <p>Частая причина: {'{ $reports['user_complaint']->reason }}'</p>
                            </div>

                            <div class="statement_block_down_description_open">
                                <button type="submit" class="statements_categories_btn">Принять</button>
                            </div>

                        </div>

                    </div>












        </div>


    </div>


</x-app-layout>
