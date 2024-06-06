<div class="message_history">
    <div class="message_history_author_background">
        <a href="{{ route('profile.profileuser', $user) }}" class="message_history_author_info">
            <div class="message_history_author_info_img">
                @if ($user->avatar !== null)
                    <img style="border-radius: 12px;" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar">
                @else
                    <img style="border-radius: 12px;" src="/uploads/ProfilePhoto.png">
                @endif
            </div>
            <div class="message_history_author_info_name">
                @if ($user->name == auth()->user()->name)
                    <p>Избранное</p>
                @else
                    <p>{{ $user->name }}</p>
                @endif
                <div class="message_history_author_info_online">
                    <p>{{ $user->condition }}</p>
                </div>
            </div>
        </a>
    </div>

    <div class="message_history_dialog">
        <script>
            window.onload = function() {
                var messageHistoryField = document.querySelector('.message_history_field');
                messageHistoryField.scrollTop = messageHistoryField.scrollHeight;
            };
        </script>
        <div class="message_history_dialog_field">
            <div class="message_history_field" id="messageHistoryField">
                @foreach ($messages as $message)
                    @if ($message['sender'] != auth()->user()->name)
                        <!-- Сообщения получателя -->
                        <div class="message_history_dialog_field_left">
                            <div class="message_history_dialog_field_width">
                                <div style="align-items: center;" class="d-flex">
                                    <p class="txt_2">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($message['created_at'])->format('d.m.Y H:i') }}</p>
                                </div>
                                <div class="message_history_dialog_field_left_rama">
                                    <div class="message_history_dialog_field_left_content">
                                        <div class="txt_2">
                                            @if ($message['type'] === 'repost')
                                                {!! $message['message'] !!}
                                            @endif

                                            @if ($message['type'] === 'text')
                                                {{ $message['message'] }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Сообщения отправителя -->
                        <div class="message_history_dialog_field_right">
                            <div class="message_history_dialog_field_width">
                                <div style="display: flex; justify-content:flex-end; align-items: center;">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($message['created_at'])->format('d.m.Y H:i') }}</p>
                                    <p class="txt_2">Вы</p>
                                </div>
                                <div class="message_history_dialog_field_right_rama">
                                    <div class="message_history_dialog_field_right_content">
                                        <div class="txt_2">



                                            @if ($message['type'] === 'repost')
                                                {!! $message['message'] !!}
                                            @endif

                                            @if ($message['type'] === 'text')
                                                {{ $message['message'] }}
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>


    @if (auth()->user()->areFriends($user->id) || auth()->user()->id == $user->id)
    <form id="sendMessageForm" wire:submit.prevent="sendMessage()" class="message_history_input" onsubmit="clearInputField()">
        @csrf
        <div class="message_history_input_search_container">
            <input type="text" wire:model="message" id="message" name="message" required  class="message_history_input_container" placeholder="Напишите сообщение...">
        </div>
        <button class="full_video_btn_send" type="submit">
            <svg width="100%" height="100%" viewBox="-2.4 -2.4 28.80 28.80" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(0)">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.048"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M10.3009 13.6949L20.102 3.89742M10.5795 14.1355L12.8019 18.5804C13.339 19.6545 13.6075 20.1916 13.9458 20.3356C14.2394 20.4606 14.575 20.4379 14.8492 20.2747C15.1651 20.0866 15.3591 19.5183 15.7472 18.3818L19.9463 6.08434C20.2845 5.09409 20.4535 4.59896 20.3378 4.27142C20.2371 3.98648 20.013 3.76234 19.7281 3.66167C19.4005 3.54595 18.9054 3.71502 17.9151 4.05315L5.61763 8.2523C4.48114 8.64037 3.91289 8.83441 3.72478 9.15032C3.56153 9.42447 3.53891 9.76007 3.66389 10.0536C3.80791 10.3919 4.34498 10.6605 5.41912 11.1975L9.86397 13.42C10.041 13.5085 10.1295 13.5527 10.2061 13.6118C10.2742 13.6643 10.3352 13.7253 10.3876 13.7933C10.4468 13.87 10.491 13.9585 10.5795 14.1355Z"
                        stroke="#777777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </g>
            </svg>
        </button>
    </form>
    @else
    <div class="message_history_input">
        <p>Вы не являетесь друзьями для доступа к диалогу.</p>
    </div>
    @endif
    


    <script>
        function clearInputField() {
            document.getElementById('message').value = '';
        }
    </script>


</div>
