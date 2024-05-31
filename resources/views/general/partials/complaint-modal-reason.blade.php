<section>

    <div class="statement_field_open">
        <div class="modal_block_open">

            <div class="modal-content">
                @if (isset($statement))
                <form id="sendcomplaint" action="{{ route('statement.complaint', ['id' => $statement->id]) }}" method="post">
            @elseif (isset($video))
                <form id="sendcomplaint" action="{{ route('video.complaint', ['id' => $video->id]) }}" method="post">
            @elseif (isset($user))
                <form id="sendcomplaint" action="{{ route('user.complaint', ['id' => $user->id]) }}" method="post">
            @endif
                    @csrf
    
                    <p>Причина жалобы</p>
                    <div class='radio-group' id="reasons-container">
                        <!-- Причины -->
                    </div>
    
                    <button type="submit" id="submit-button" style="float:right; display:none;" class="statements_categories_btn">Отправить</button>
                </form>
            </div>
        </div>


        <button class="statement_block_btn_close">

            @include('general.elements.svg-close-modal')

        </button>

    </div>


    <script>
        const statementFieldOpen = document.querySelector(".statement_field_open");
        const closeButton = document.querySelector(".statement_block_btn_close");


        function closeModal() {
            statementFieldOpen.classList.remove("opened");
        }

        function openModal() {

            statementFieldOpen.classList.add("opened");
        }

        closeButton.addEventListener("click", closeModal);

        statementFieldOpen.addEventListener("click", function(event) {
            if (event.target === statementFieldOpen) {
                closeModal();
            }
        });

        document.addEventListener("keydown", function(event) {
            if (event.key === "Escape" && statementFieldOpen.classList.contains("opened")) {
                closeModal();
            }
        });

        function confirmSendComplaint() {
            openModal();
        }
    </script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('{{ route('reasons') }}')
        .then(response => response.json())
        .then(data => {
            const reasonsContainer = document.getElementById('reasons-container');
            reasonsContainer.innerHTML = '';
            if (data.length > 0) {
                data.forEach(reason => {
                    if (reason.id !== 1) {
                        const label = document.createElement('label');
                        label.className = 'radio-label';
                        
                        const input = document.createElement('input');
                        input.type = 'radio';
                        input.name = 'reason';
                        input.value = reason.id;
                        input.required = true;
                        input.addEventListener('change', toggleSubmitButton);
                        
                        const span = document.createElement('span');
                        span.className = 'inner-label';
                        span.textContent = reason.name;
    
                        label.appendChild(input);
                        label.appendChild(span);
                        reasonsContainer.appendChild(label);
                    }
                });
            } else {
                reasonsContainer.innerHTML = '<p>Причины не созданы</p>';
            }
        })
        .catch(error => console.error('Ошибка получения причин:', error));
});
    
    function toggleSubmitButton() {
        const submitButton = document.getElementById('submit-button');
        const reasonSelected = document.querySelector('input[name="reason"]:checked');
        if (reasonSelected) {
            submitButton.style.display = 'block';
        } else {
            submitButton.style.display = 'none';
        }
    }
    </script>

</section>
