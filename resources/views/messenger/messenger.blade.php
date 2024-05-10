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

            @foreach ($dialogs as $dialog)
                @if ($dialog->user->name !== auth()->user()->name)
                    <div class="message_dialogs">
                        <a href="{{ route('messenger.chat', $dialog->user->id) }}"
                            class="message_dialog
                         @if ($dialog->user->id == $user->id) active @endif">


                            <div class="author">
                                <div class="avatar_mini">
                                    @if ($dialog->user->avatar !== null)
                                        <img class="avatar_mini" src="{{ asset('storage/' . $dialog->user->avatar) }}"
                                            alt="Avatar">
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

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const dialogs = document.querySelectorAll('.message_dialog');

                    dialogs.forEach(function(dialog) {
                        dialog.addEventListener('click', function() {

                            dialogs.forEach(function(dialog) {
                                dialog.classList.remove('active');
                            });

                            this.classList.add('active');
                        });
                    });
                });
            </script>

        </div>

@if (Route::is('messenger.chat'))

        @livewire('chat-component', ['user_id' => $id])

        @else



        <p>Выберите диалог для чата</p>



@endif

    </div>

</x-app-layout>
