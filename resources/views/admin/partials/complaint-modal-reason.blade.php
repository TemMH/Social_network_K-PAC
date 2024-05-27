<section>

    <div class="statement_field_open">



        <div class="modal_block_open">
            <div class="modal-content">
                @if (isset($statement))
                <form id="sendcomplaint" action="{{ route('complaint.post.statement', ['statement' => $statement->id]) }}" method="post">
            @elseif (isset($video))
                <form id="sendcomplaint" action="{{ route('complaint.post.video', ['video' => $video->id]) }}" method="post">
                @elseif (isset($user))
                    <form id="sendcomplaint" action="{{ route('complaint.post.user', ['user' => $user->id]) }}" method="post">
                @endif
                    @csrf
    
                    <p>Причина жалобы</p>
                    <div class='radio-group' id="reasons-container">
                        <!-- Причины -->
                    </div>
    
                    <button type="submit" name="edit_status" id="submit-button" style="float:right; display:none;" value="accepted" class="statements_categories_btn">Заблокировать</button>
               
               
               
               




               
                </form>
            </div>
        </div>

        <div class="modal_block_close">
            <button class="statement_block_btn_close">

                <svg width="90%" height="90%" viewBox="-0.5 0 25 25" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M3 21.32L21 3.32001" stroke="#777777" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M3 3.32001L21 21.32" stroke="#777777" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                </svg>

            </button>
        </div>

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

    // Причины
    fetch('{{ route('reasons') }}')
        .then(response => response.json())
        .then(data => {
            const reasonsContainer = document.getElementById('reasons-container');
            reasonsContainer.innerHTML = '';
            if (data.length > 0) {
                data.forEach(reason => {
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
                });
            } else {
                reasonsContainer.innerHTML = '<p>Причины не созданы</p>';
            }
        })
        .catch(error => console.error('Ошибка получения причин:', error));

    // Модальное окно и url
    window.confirmSendComplaint = function(button) {
    const userId = button.getAttribute('data-user-id');
    const videoId = button.getAttribute('data-video-id');
    const statementId = button.getAttribute('data-statement-id');
    const form = document.getElementById('sendcomplaint');

    let actionUrl = '';

    if (userId) {
        actionUrl = "{{ route('complaint.post.user', ['user' => ':userId']) }}";
        actionUrl = actionUrl.replace(':userId', userId);
    } else if (videoId) {
        actionUrl = "{{ route('complaint.post.video', ['video' => ':videoId']) }}";
        actionUrl = actionUrl.replace(':videoId', videoId);
    } else if (statementId) {
        actionUrl = "{{ route('complaint.post.statement', ['statement' => ':statementId']) }}";
        actionUrl = actionUrl.replace(':statementId', statementId);
    }

    form.setAttribute('action', actionUrl);
    openModal();
};

    // Кнопка отправки при выборе причины
    function toggleSubmitButton() {
        const submitButton = document.getElementById('submit-button');
        const reasonSelected = document.querySelector('input[name="reason"]:checked');
        if (reasonSelected) {
            submitButton.style.display = 'block';
        } else {
            submitButton.style.display = 'none';
        }
    }
});

    </script>

</section>
