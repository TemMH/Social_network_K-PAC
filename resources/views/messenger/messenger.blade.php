<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        </h2>
    </x-slot>


    @if (Route::is('messenger','messenger.chat'))
@include('messenger.components.view-user-dialogs')
@endif

@if (Route::is('admin.show.messenger','admin.show.chat'))
@include('messenger.components.view-admin-dialogs')
@endif

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






@vite(['resources/js/search-input/SearchDialog.js'])

</x-app-layout>
