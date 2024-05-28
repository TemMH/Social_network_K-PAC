<section class="message_history">




        <div class="message_history_author_background">
            <a href="{{ route('profile.profileuser', $recipient) }}" class="message_history_author_info">
                <div class="message_history_author_info_img">
                    @if ($recipient->avatar !== null)
                        <img style="border-radius: 12px;" src="{{ asset('storage/' . $recipient->avatar) }}" alt="Avatar">
                    @else
                        <img style="border-radius: 12px;" src="/uploads/ProfilePhoto.png">
                    @endif
                </div>
                <div class="message_history_author_info_name">
                    <p>{{ $recipient->name }}</p>
                    <div class="message_history_author_info_online">
                        <p>{{ $recipient->condition }}</p>
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
                        @if ($message->sender_id === $recipient->id)
                            <!-- Сообщения получателя -->
                            <div class="message_history_dialog_field_left">
                                <div class="message_history_dialog_field_width">
                                    <div style="align-items: center;" class="d-flex">
                                        <p class="txt_2">{{ $recipient->name }}</p>
                                        <p>{{ \Carbon\Carbon::parse($message['created_at'])->format('d.m.Y H:i') }}</p>
                                    </div>
                                    <div class="message_history_dialog_field_left_rama">
                                        <div class="message_history_dialog_field_left_content">
                                            <div class="txt_2">
                                                {!! $message->message !!}
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
                                        <p>{{ \Carbon\Carbon::parse($message['created_at'])->format('d.m.Y H:i') }}</p>
                                        <p class="txt_2">{{ $user->name }}</p>
                                    </div>
                                    <div class="message_history_dialog_field_right_rama">
                                        <div class="message_history_dialog_field_right_content">
                                            <div class="txt_2">
                                                {!! $message->message !!}
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

    <div class="message_history_input">

    </div>
    <script>
        function clearInputField() {
            document.getElementById('message').value = '';
        }
    </script>

    



</section>
