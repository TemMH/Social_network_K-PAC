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
                    <input type="text" id="searchInputdDialog" class="message_history_input_container" placeholder="Поиск по имени...">
                </div>

            </div>
<div id="searchResultsDialog">
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
        </div>





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




    <script>
$(document).ready(function() {
    // изначальный диалог
    var initialDialogs = $('#searchResultsDialog').html();

    $('#searchInputdDialog').on('input', function() {
        let searchTerm = $(this).val().trim();

        if (searchTerm.length >= 3) {
            $.ajax({
                type: 'GET',
                url: '/dialog/autocomplete',
                data: {
                    search: searchTerm
                },
                success: function(response) {
                    console.log(response);
                    let resultsDiv = $('#searchResultsDialog');
                    resultsDiv.empty();

                    if (searchTerm !== '') {
                        $.each(response.dialogs, function(index, dialog) {
                            if (dialog.user) {

                                var avatarSrc = dialog.user.avatar ? response.base_url + '/' + dialog.user.avatar : '/uploads/ProfilePhoto.png';

                                resultsDiv.append(
                                    '<div class="message_dialogs">' +
                                    '<a href="/messenger/' + (dialog.user.id ? dialog.user.id : '') + '" class="message_dialog">' +
                                    '<div class="author">' +
                                    '<div class="avatar_mini">' +
                                    '<img class="avatar_mini" src="' + avatarSrc + '" alt="Avatar">' +
                                    '</div>' +
                                    '<p class="txt2">' + (dialog.user.name ? dialog.user.name : '') + '</p>' +
                                    '</div>' +
                                    '<div class="message_dialog_last">' +
                                    '<p class="txt1">' + (dialog.lastMessage !== null ? dialog.lastMessage.message : '') + '</p>' +
                                    '</div>' +
                                    '</a>' +
                                    '</div>'
                                );
                            }
                        });
                    }
                }
            });
        } else if (searchTerm === '') {

            $('#searchResultsDialog').html(initialDialogs);
        } else {

        }
    });
});
    </script>

</x-app-layout>
