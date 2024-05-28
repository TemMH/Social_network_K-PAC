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