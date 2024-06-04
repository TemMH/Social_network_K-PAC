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

                <div class="message_dialogs">
                    <a href="{{ route('messenger.chat', $selfDialog->user->id) }}" class="message_dialog
                 @if ($selfDialog->user->id == $user->id) active @endif">

                        <div class="author">

                            <div class="avatar_mini">
                                @if ($selfDialog->user->avatar !== null)
                                    <img class="avatar_mini"
                                        src="{{ asset('storage/' . $selfDialog->user->avatar) }}" alt="Avatar">
                                @else
                                    <img class="avatar_mini" src="/uploads/ProfilePhoto.png">
                                @endif
                            </div>
                            @if ($selfDialog->user->name == auth()->user()->name)

                            <p class="txt2">Избранное</p> 
                            @endif


                           
                        

                        </div>

                        <div class="message_dialog_last">
                            
                            <p class="txt1">

                                @if ($selfDialog->lastMessage->type === 'repost')
                                <p>Ссылка</p>
                                @endif

                                @if ($selfDialog->lastMessage->type === 'text')
                                {{ $selfDialog->lastMessage->message }}
                                @endif
                            </p>

                        </div>

                    </a>
                </div>


                @foreach ($dialogs as $dialog)
                @if ($dialog->user->name !== auth()->user()->name)

                        <div class="message_dialogs">
                            <a href="{{ route('messenger.chat', $dialog->user->id) }}" class="message_dialog
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

                                        @if ($dialog->lastMessage->type === 'repost')
                                        <p>Ссылка</p>
                                        @endif
    
                                        @if ($dialog->lastMessage->type === 'text')
                                        {{ $dialog->lastMessage->message }}
                                        @endif
                                    </p>

                                </div>

                            </a>
                        </div>

              
                        @endif
                @endforeach
            </div>

        </div>

        @if (Route::is('messenger.chat'))
            @livewire('chat-component', ['user_id' => $id])
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