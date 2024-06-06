<section>

    <button
    x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'create-new-statement')"
    class="mini_button"
    title="Опубликовать фотоматериал"
>@include('general.elements.profile.svg-newstatement')</button>




<x-modal name="create-new-statement" :show="$errors->userDeletion->isNotEmpty()" focusable>




        <form method="POST" class="newvideo_frame" action="{{ route('createstatement') }}" enctype="multipart/form-data">
            @csrf

            <div class="newvideo_frame_text">

                <div class="newvideo_frame_text_title">

                    <p>Название фотоматериала</p>

                    <div>
                        <input type="text" id="title" name="title" required
                            class="message_history_input_container" placeholder="Введите название фотоматериала...">
                    </div>

                </div>

                <div class="newvideo_frame_text_description">

                    <p>Описание фотоматериала</p>

                    <div class="newvideo_frame_text_description_textarea">
                        <textarea type="text" id="description" type="text" name="description" required class="newvideo_textarea"
                            placeholder="Введите описание фотоматериала..."></textarea>
                    </div>


                </div>

            </div>
            <div class="newvideo_frame_upload">
                <label for="photo" class="drop-container" id="dropcontainer_photo">
                    <div class="newvideo_frame_upload_info">

                        @include('general.elements.svg-upload')



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

            <script>
                var dropContainer = document.getElementById('dropcontainer_photo');
                var input = document.getElementById('photo');


                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropContainer.addEventListener(eventName, preventDefaults, false);
                    document.body.addEventListener(eventName, preventDefaults, false);
                });

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropContainer.addEventListener(eventName, hover, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropContainer.addEventListener(eventName, unhover, false);
                });

                dropContainer.addEventListener('drop', handleDrop, false);

                function preventDefaults(e) {
                    e.preventDefault();
                }

                function hover() {
                    dropContainer.classList.add('hover');
                }

                function unhover() {
                    dropContainer.classList.remove('hover');
                }

                function handleDrop(e) {
                    var dt = e.dataTransfer;
                    var files = dt.files;


                    if (files.length === 1 && (files[0].type === 'image/jpeg' || files[0].type === 'image/jpg' || files[0].type === 'image/png')) {
                        handleFiles(files);
                    } else {
                        showFlashError('Пожалуйста, используйте один файл в формате jpg/jpeg/png.');
                    }
                }



                function handleFiles(files) {
                    input.files = files;
                }
            </script>

            <div class="newvideo_frame_optionally">

                <div class="newvideo_frame_optionally_category">

                    <p>Выберите категорию</p>

                    <div>
                        <select class="message_history_input_container" name="category" id="category">
                            <option value="">Без категории</option>

                @forelse ($categories as $category)

                <option value="{{ $category->id }}">{{ $category->name }}</option>

                @empty

                <p>Категорий нет</p>
            @endforelse
                         
                        </select>
                    </div>

                </div>

                <div class="newvideo_frame_optionally_thumbnail">



                </div>

            </div>


            <div class="newvideo_frame_btn">

                <button onclick="showUploadMessageStatement()" class="newvideo_frame_btn_submit">

                    Опубликовать

                </button>

                <script>
function showUploadMessageStatement() {
    showFlashError('Пожалуйста подождите загрузку фотоматериала...');
}

                </script>

            </div>


        </form>

</x-modal>

</section>