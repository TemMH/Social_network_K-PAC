<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        </h2>
    </x-slot>


    <div class="messenger">
        <div class="messenger_dialogs">

            <div class="message_dialog_searh">

                <p class="txt2">Мессенджер</p>

                <div class="search-container">
                    <input type="text" id="" class="custom-search-input-news" placeholder="Поиск по имени...">
                </div>

            </div>


            {{-- ACTIV --}}
            <div class="message_dialogs">

                <div class="message_dialog">

                    <div class="message_dialog_author_info">

                        <div class="message_dialog_author_info_avatar">

                            @if ($user->avatar !== null)
                                <img class="avatar_mini" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar">
                            @else
                                <img class="avatar_mini" src="/uploads/ProfilePhoto.png">
                            @endif

                        </div>

                        <div class="message_dialog_author_info_name" style="margin-left: 2%">

                            <p class="txt2">{{ $user->name }}</p>

                        </div>

                    </div>

                    <div class="message_dialog_last">
                        <p class="txt1">{{ $lastMessage->content }}</p>
                    </div>


                </div>

            </div>

            {{-- foreach --}}

            <div class="message_dialogs">

                <div class="message_dialog">

                    <div class="author">
                        <div class="avatar_mini"></div>
                        <p class="txt2"></p>
                    </div>

                    <div class="message_dialog_last">
                        <p class="txt1"></p>
                    </div>


                </div>


            </div>

            <div class="message_dialogs">

                <div class="message_dialog">

                    <div class="author">
                        <div class="avatar_mini"></div>
                        <p class="txt2"></p>
                    </div>

                    <div class="message_dialog_last">
                        <p class="txt1"></p>
                    </div>


                </div>


            </div>

        </div>

        <div class="message_history">

            <div class="message_history_author_background">

                <div class="message_history_author_info">

                    <div class="message_history_author_info_img">
                        @if ($user->avatar !== null)
                            <img class="avatar" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar">
                        @else
                            <img class="avatar" src="/uploads/ProfilePhoto.png">
                        @endif


                    </div>

                    <div class="message_history_author_info_name">
                        <p>{{ $user->name }}</p>

                        <div class="message_history_author_info_online">
                            <p>В сети...</p>
                        </div>

                    </div>

                </div>

                <div class="message_history_author_buttons">

                    <button class="novost_down_func_video" type="submit">?</button>
                    <button class="novost_down_func_video" type="submit">?</button>

                </div>

            </div>

            <div class="message_history_dialog">

                <script>
                    window.onload = function() {
                        var messageHistoryField = document.querySelector('.message_history_field');
                        messageHistoryField.scrollTop = messageHistoryField.scrollHeight;
                    };
                </script>
                
                <div class="message_history_dialog_field">
                    <div class="message_history_field">

                        @foreach ($messages as $message)
                            @if ($message->sender_id === auth()->id())
                                <!-- Сообщения отправителя -->
                                <div class="message_history_dialog_field_right">

                                    <div class="message_history_dialog_field_width">
                                        {{-- СДЕЛАТЬ У ДАТЫ ОЧ ТЕМНЫЙ ЦВЕТ --}}
                                        <p class="txt_2" style="display: flex; justify-content:flex-end;">
                                            {{ $message->created_at }} Вы</p>

                                        <div class="message_history_dialog_field_right_rama">
                                            <div class="message_history_dialog_field_right_content">

                                                <div class="txt_2">
                                                    {!! $message->content !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @else
                                <!-- Сообщения получателя -->
                                <div class="message_history_dialog_field_left">
                                    <div class="message_history_dialog_field_width">


                                        <p class="txt_2">{{ $user->name }} {{ $message->created_at }}</p>
                                        <div class="message_history_dialog_field_left_rama">
                                            <div class="message_history_dialog_field_left_content">


                                                <div class="txt_2">
                                                    {!! $message->content !!}


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



            <form action="{{ route('message.send', $user->id) }}" class="message_history_input" method="POST">
                @csrf
                <div class="message_history_input_search_container">

                    <input type="text" id="message" type="text" name="message" required autofocus
                        autocomplete="message" class="message_history_input_container"
                        placeholder="Напишите сообщение...">

                </div>

                <div class="message_history_input_send">

                    <button class="novost_down_func_video" type="submit">Отправить</button>

                </div>
            </form>

        </div>
    </div>

</x-app-layout>
