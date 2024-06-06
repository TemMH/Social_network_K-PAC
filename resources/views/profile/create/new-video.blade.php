<section>

    <button
    x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'create-new-video')"
    class="mini_button"
    title="Опубликовать фотоматериал"
>@include('general.elements.profile.svg-newvideo')</button>




<x-modal name="create-new-video" :show="$errors->userDeletion->isNotEmpty()" focusable>




    <form method="POST" class="newvideo_frame" action="{{ route('createvideo') }}" enctype="multipart/form-data">
        @csrf

        <div class="newvideo_frame_text">

            <div class="newvideo_frame_text_title">

                <p>Название видеоматериала</p>

                <div>
                    <input type="text" id="title" name="title" required
                        class="message_history_input_container" placeholder="Введите название видеоматериала...">
                </div>

            </div>

            <div class="newvideo_frame_text_description">

                <p>Описание видеоматериала</p>

                <div class="newvideo_frame_text_description_textarea">
                    <textarea type="text" id="description" type="text" name="description" required class="newvideo_textarea"
                        placeholder="Введите описание видеоматериала..."></textarea>
                </div>


            </div>

        </div>
        <div class="newvideo_frame_upload">
            <label for="video" class="drop-container" id="dropcontainer">
                <div class="newvideo_frame_upload_info">


                    @include('general.elements.svg-upload')



                </div>
                <p>Загрузить видео</p>
                <p style="color:#777777;">Перетащите файл сюда или нажмите на форму, чтобы выбрать их на
                    устройстве.
                </p>
                <div style="display: flex; justify-content:center;">

                    <input type="file" name="video" id="video" accept="video/mp4" required>
                </div>
            </label>
        </div>






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

                <div class="newvideo_frame_optionally_thumbnail_upload">


                    <label for="thumbnail" class="drop-container" id="dropcontainer_thumbnail">
                        <div class="newvideo_frame_upload_info">

                            @include('general.elements.svg-upload')


                        </div>
                        <p>Загрузить обложку</p>
                        <p style="color:#777777; font-size: 12px;">Перетащите файл сюда или нажмите на форму, чтобы
                            выбрать их на
                            устройстве.
                        </p>
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/*" required>
                    </label>



                </div>

            </div>

        </div>

        <script>
            var dropContainerVideo = document.getElementById('dropcontainer');
            var inputVideo = document.getElementById('video');
        
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropContainerVideo.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });
        
            ['dragenter', 'dragover'].forEach(eventName => {
                dropContainerVideo.addEventListener(eventName, hover, false);
            });
        
            ['dragleave', 'drop'].forEach(eventName => {
                dropContainerVideo.addEventListener(eventName, unhover, false);
            });
        
            dropContainerVideo.addEventListener('drop', handleDropVideo, false);
        
            function handleDropVideo(e) {
    var dt = e.dataTransfer;
    var files = dt.files;

    if (files.length === 1) {
        var file = files[0];
        var validFormats = ['video/mp4', 'video/quicktime', 'video/x-msvideo'];
        var maxSize = 500000000;

        if (validFormats.includes(file.type) && file.size <= maxSize) {
            handleFiles(files);
        } else {
            showFlashError('Пожалуйста, используйте один файл в формате mp4, mov, avi и размером не более 500 МБ.');
        }
    } else {
        showFlashError('Пожалуйста, загрузите только один файл.');
    }
}

        
            var dropContainerThumbnail = document.getElementById('dropcontainer_thumbnail');
            var inputThumbnail = document.getElementById('thumbnail');
        
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropContainerThumbnail.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });
        
            ['dragenter', 'dragover'].forEach(eventName => {
                dropContainerThumbnail.addEventListener(eventName, hover, false);
            });
        
            ['dragleave', 'drop'].forEach(eventName => {
                dropContainerThumbnail.addEventListener(eventName, unhover, false);
            });
        
            dropContainerThumbnail.addEventListener('drop', handleDropThumbnail, false);
        
            function handleDropThumbnail(e) {
                var dt = e.dataTransfer;
                var files = dt.files;
        
                if (files.length === 1 && files[0].type.startsWith('image/')) {
                    handleFiles(files);
                } else {
                    showFlashError('Пожалуйста, используйте один файл в формате jpg/jpeg.');
                }
            }
        

            
            function handleFiles(files) {
                if (files[0].type.startsWith('video/')) {
                    inputVideo.files = files;
                } else if (files[0].type.startsWith('image/')) {
                    inputThumbnail.files = files;
                }
            }
        
            function preventDefaults(e) {
                e.preventDefault();
            }
        
            function hover() {
                this.classList.add('hover');
            }
        
            function unhover() {
                this.classList.remove('hover');
            }
        </script>

        <div class="newvideo_frame_btn">

            <button onclick="showUploadMessage()" class="newvideo_frame_btn_submit">

                Опубликовать

            </button>
<script>
function showUploadMessage() {
    showFlashError('Пожалуйста подождите загрузку видеоматериала...');
}
</script>
        </div>


    </form>

</x-modal>

</section>