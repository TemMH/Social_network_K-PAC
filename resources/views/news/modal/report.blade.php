<section>

    <button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'statement-modal-report {{ $statement->id }}')" class="mini_button">

        @include('general.elements.svg-complaint')

    </button>





    <x-modal name="statement-modal-report {{ $statement->id }}" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div style="    height: 100vh;
        /* margin: auto 0; */
        display: flex;
        align-items: center;
        justify-content: center;">
            <div style="margin-inline: auto;" class="modal_block_open">
                <div class="modal-content">
                    <form id="sendcomplaint-{{ $statement->id }}"
                        action="{{ route('statement.complaint', ['id' => $statement->id]) }}" method="post">
                        @csrf

                        <p>Причина жалобы</p>
                        <?php
                        $reasons = \App\Models\Reason::all();
                        ?>
                        <div class="radio-group" id="reasons-container-{{ $statement->id }}">
                            @foreach ($reasons as $reason)
                                <div>
                                    <label class="radio-label">
                                        <input type="radio" name="reason" value="{{ $reason->id }}" required>
                                        <span class="inner-label">{{ $reason->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" id="submit-button-{{ $statement->id }}"
                            style="float:right; display:none;" class="statements_categories_btn">
                            Отправить
                        </button>




                    </form>
                </div>
            </div>
        </div>
    </x-modal>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radioButtons = document.querySelectorAll('input[name="reason"]');
            const submitButton = document.getElementById('submit-button-{{ $statement->id }}');

            radioButtons.forEach(function(radio) {
                radio.addEventListener('change', function() {
                    toggleSubmitButton();
                });
            });

            function toggleSubmitButton() {
                const reasonSelected = document.querySelector('input[name="reason"]:checked');
                if (reasonSelected) {
                    submitButton.style.display = 'block';
                } else {
                    submitButton.style.display = 'none';
                }
            }

            toggleSubmitButton();
        });
    </script>

</section>
