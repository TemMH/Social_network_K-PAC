<section>

    <div id="complaint-modal-{{ $video->id }}" class="statement_field_open">
        <div class="modal_block_open">
            <div class="modal-content">
                <form action="{{ route('video.complaint', ['id' => $video->id]) }}" method="post">
                    @csrf
                    <p>Причина жалобы</p>
                    <div class='radio-group'>
                        <!-- Причины -->
                    </div>
                    <button type="submit" style="float:right; display:none;"
                        class="statements_categories_btn">Отправить</button>
                </form>
            </div>
        </div>


        <button class="statement_block_btn_close">

            @include('general.elements.svg-close-modal')

        </button>

    </div>



    @vite(['resources/js/buttons/button-close-modal.js'])

</section>
