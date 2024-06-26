<section>

    <div class="messenger">
        <div class="messenger_dialogs">

            <div class="message_dialog_searh">

                <p class="txt2">Мессенджер</p>

                <div class="search-container">
                    <input type="text" id="searchInputdDialog" class="message_history_input_container"
                        placeholder="Поиск по имени...">
                </div>

            </div>
            
            <div id="searchResultsDialog">
                @foreach ($dialogs as $dialog)

                    @if ($dialog->user->name == $user->name)

                        <div class="message_dialogs">
                            <a href="{{ route('admin.show.chat', ['userId' => $user->id, 'dialogId' => $dialog->user->id]) }}" class="message_dialog
                         @if ($dialog->user->id == $user->id) active @endif">

                                <div class="author">

                                    <div class="avatar_mini">
                                        @if ($dialog->user->avatar !== null)
                                            <img class="avatar_mini"
                                                src="{{ asset('storage/' . $dialog->user->avatar) }}" alt="Avatar">
                                        @else
                                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png">
                                        @endif
                                    </div>

                                    <p class="txt2">Избранное {{ $dialog->user->name }}</p> 

                                </div>

                                <div class="message_dialog_last">
                                    
                                    <p class="txt1">
                                        @if ($dialog->lastMessage !== null)
                                            <p class="txt1">{{ $dialog->lastMessage->message }}</p>
                                        @else
                                            <p> </p>
                                        @endif
                                    </p>

                                </div>

                            </a>
                        </div>

                    @endif

                @endforeach

                @foreach ($dialogs as $dialog)

                    @if ($dialog->user->name !== $user->name)

                        <div class="message_dialogs">
                            <a href="{{ route('admin.show.chat', ['userId' => $user->id, 'dialogId' => $dialog->user->id]) }}" class="message_dialog
                         @if ($dialog->user->id == $user->id) active @endif">

                                <div class="author">

                                    <div class="avatar_mini">
                                        @if ($dialog->user->avatar !== null)
                                            <img class="avatar_mini"
                                                src="{{ asset('storage/' . $dialog->user->avatar) }}" alt="Avatar">
                                        @else
                                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png">
                                        @endif
                                    </div>

                                    <p class="txt2">{{ $dialog->user->name }}</p> 

                                </div>

                                <div class="message_dialog_last">
                                    
                                    <p class="txt1">
                                        @if ($dialog->lastMessage !== null)
                                            <p class="txt1">{{ $dialog->lastMessage->message }}</p>
                                        @else
                                            <p> </p>
                                        @endif
                                    </p>

                                </div>

                            </a>
                        </div>

                    @endif

                @endforeach
            </div>

        </div>

        @if (Route::is('admin.show.chat'))
            
@include('messenger.components.chat.check-chat-admin')

        @else

        <div style="justify-content: center; margin: 0 auto; height: 100%;" class="friendfeed_field_frame">

            <div style="text-align: center; max-width: 800px; margin: 0 auto; padding:1%;" class="friendfeed_content">

                <p style="margin:20px 0;"  class="txt_2">Для общения выберите диалог в левом меню</p>
                <p style="margin:20px 0;"  class="txt_2">Если диалогов нет, создайте их сами написав другу</p>

                <button class="long_button" onclick="toggleSearch()" >Найти новых друзей</button>


            </div>
        </div>
        @endif

    </div>

</section>