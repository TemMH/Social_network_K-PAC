<x-app-layout>
    <x-slot name="header">

    </x-slot>



    <div class="friendfeed_field">



        <form method="POST" class="newvideo_frame" action="{{ route('createstatement') }}" enctype="multipart/form-data">
            @csrf

            <div class="newvideo_frame_text">

                <div class="newvideo_frame_text_title">

                    <p>Название фотоматериала</p>

                    <div>
                        <input type="text" id="title" name="title" required
                            class="message_history_input_container" placeholder="Введите название видеоматериала...">
                    </div>

                </div>

                <div class="newvideo_frame_text_description">

                    <p>Описание фотоматериала</p>

                    <div class="newvideo_frame_text_description_textarea">
                        <textarea type="text" id="description" type="text" name="description" required class="newvideo_textarea"
                            placeholder="Введите описание видеоматериала..."></textarea>
                    </div>


                </div>

            </div>
            <div class="newvideo_frame_upload">
                <label for="photo" class="drop-container" id="dropcontainer">
                    <div class="newvideo_frame_upload_info">

                        <svg width="75%" height="75%" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M8.00003 8C7.59557 8 7.23093 7.75636 7.07615 7.38268C6.92137 7.00901 7.00692 6.57889 7.29292 6.29289L11.2929 2.29289C11.6834 1.90237 12.3166 1.90237 12.7071 2.29289L16.7071 6.29289C16.9931 6.57889 17.0787 7.00901 16.9239 7.38268C16.7691 7.75636 16.4045 8 16 8H13.5V16C13.5 16.5523 13.0523 17 12.5 17H11.5C10.9477 17 10.5 16.5523 10.5 16V8H8.00003Z"
                                    fill="#777777"></path>
                                <path
                                    d="M20 19C20.5523 19 21 19.4477 21 20V21C21 21.5523 20.5523 22 20 22H4C3.44772 22 3 21.5523 3 21V20C3 19.4477 3.44772 19 4 19H20Z"
                                    fill="#777777"></path>
                            </g>
                        </svg>


                    </div>
                    <p>Загрузить фото</p>
                    <p style="color:#777777;">Перетащите файл сюда или нажмите на форму, чтобы выбрать их на
                        устройстве.
                    </p>
                    <div style="display: flex; justify-content:center;">

                        <input type="file" name="photo" id="photo" accept="image/*" required>
                    </div>
                </label>
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



                </div>

            </div>


            <div class="newvideo_frame_btn">

                <button class="newvideo_frame_btn_submit">

                    Опубликовать

                </button>

            </div>


        </form>




    </div>



</x-app-layout>
