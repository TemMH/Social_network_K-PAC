<x-app-layout>
    <x-slot name="header">

    </x-slot>



    <div class="friendfeed_field">




        <div class="newvideo_frame">

            <div class="newvideo_frame_text">

                <div class="newvideo_frame_text_title">

                    <p>Название видеоматериала</p>

                    <div>
                        <input type="text" id="message" type="text" name="message" required autofocus
                            autocomplete="message" class="message_history_input_container"
                            placeholder="Введите название видеоматериала...">
                    </div>

                </div>

                <div class="newvideo_frame_text_description">

                    <p>Описание видеоматериала</p>

                    <div class="newvideo_frame_text_description_textarea">
                        <textarea type="text" id="message" type="text" name="message" required autofocus autocomplete="message"
                            class="newvideo_textarea" placeholder="Введите описание видеоматериала..."></textarea>
                    </div>


                </div>

            </div>


            <div class="newvideo_frame_upload">


                <div class="newvideo_frame_upload_info"></div>

                <p>Загрузить видео</p>

                <p style="color:#777777; ">Перетащите файлы или нажмите на эту форму, чтобы выбрать их на устройстве</p>

            </div>


            <div class="newvideo_frame_optionally">

                <div class="newvideo_frame_optionally_category">

                    <p>Выберите категорию</p>

                    <div>
                        <select class="message_history_input_container" name="category" id="category">
                            <option value=" "> </option>
                            <option value="Спорт">Спорт</option>
                            <option value="Игры">Игры</option>
                            <option value="Экономика">Экономика</option>
                            <option value="Транспорт">Транспорт</option>
                        </select>
                    </div>

                </div>

                <div class="newvideo_frame_optionally_thumbnail">

                    <div class="newvideo_frame_optionally_thumbnail_upload">

                        <div class="newvideo_frame_upload_info"></div>

                        <p>Загрузить обложку</p>

                        <p style="color:#777777;">Перетащите файлы или нажмите на эту форму, чтобы выбрать их на устройстве</p>

                    </div>

                </div>

            </div>


            <div class="newvideo_frame_btn">

                <button class="newvideo_frame_btm_submit">

                    Опубликовать

                </button>

            </div>


        </div>







    </div>



</x-app-layout>
