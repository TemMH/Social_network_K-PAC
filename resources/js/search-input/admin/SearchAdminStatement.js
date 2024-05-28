$(document).ready(function() {
    // изначальный список
    var initialDialogs = $('#searchResultsAdmin').html();

    $('#searchInputdAdmin').on('input', function() {
        let searchTerm = $(this).val().trim();

        if (searchTerm.length >= 3) {
            $.ajax({
                type: 'GET',
                url: '/admin/autocomplete/statement',
                data: {
                    search: searchTerm
                },
                success: function(response) {
                    console.log(response);
                    let resultsDiv = $('#searchResultsAdmin');
                    resultsDiv.empty();

                    if (searchTerm !== '') {
                        $.each(response.statements, function(index, statement) {
                            if (statement) {

                                var isBlocked = statement.is_blocked;

                                var createdDate = new Date(statement.created_at);
                                var formattedDate = createdDate.toISOString().replace('T', ' ').replace(/\.\d+Z$/, '');
                                
                                var bannedDate = statement.first_ban ? new Date(statement.first_ban.created_at) : null;
                                var formattedDateBan = bannedDate ? bannedDate.toISOString().replace('T', ' ').replace(/\.\d+Z$/, '') : null;

var avatarSrc = (statement.user && statement.user.avatar) ? response.base_url + '/' + statement.user.avatar : '/uploads/ProfilePhoto.png';
var csrfToken = $('meta[name="csrf-token"]').attr('content');
                                resultsDiv.append(
                                    '<div class="report_content_test">' +
                                    '<div class="report_block_top_open">' +
                                    '<div class="report_block_top_info_left_open">' +
                                    '<div class="statement_block_top_image_open">' +
                                    '<img src="' + response.base_url + '/' + statement.photo_path + '" alt="Photo" style="object-fit:contain;" class="videoThumbnail" style="cursor:pointer;">' +
                                    '</div>' +
                                    '<div class="statement_block_top_addinfo">' +
                                    '<div class="statement_block_top_addinfo_first">' +
                                    '<p>' + statement.title + '</p>' +
                                    '</div>' +
                                    '<div class="statement_block_top_addinfo_second">' +
                                    '<div class="statement_block_top_avatar_open">' +
                                    '<img class="avatar_mini" src="' + avatarSrc + '" alt="Avatar">' +
                                    '</div>' +
                                    '<p>' + statement.user.name + '</p>' +
                                    '</div>' +
                                    '<div class="statement_block_top_addinfo">' +
                                    '<p>' + formattedDate + '</p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="report_block_top_info_right_open">' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="report_block_down_open">' +
                                    '<div class="statement_block_down_views_open">' +



                                    (isBlocked ?
                                        '<p>Заблокирован: ' + formattedDateBan + '</p>' +
                                            '<p>пользователем: ' + (statement.first_ban.sender_name ? statement.first_ban.sender_name : 'Неизвестный отправитель') + '</p>' +
                                            '<p>По причине: ' + (statement.first_ban.reason_name ? statement.first_ban.reason_name : 'Неизвестная причина') + '</p>'
                                        : '<p>Не заблокирован</p>') +
                                    '</div>' +
                                    '<div class="statement_block_down_description_open" style="display: flex;">' +


                                    (isBlocked ?


                                        '<form id="sendcomplaint" action="/adminnavigation/statement/deleteban/' + statement.id + '" method="post">' +
                                         
                                         '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                                             '<button name="edit_status" value="rejected" class="statements_categories_btn" > Разблокировать </button>' +
                                         '</form>'
                                     :
                                         '<form id="sendcomplaint" action="/adminnavigation/statement/' + statement.id + '" method="post">' +

                                         '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                                         
                                             '<button name="edit_status" value="accepted" class="statements_categories_btn" > Заблокировать </button>' +
                                         '</form>') +



                                   '<form onclick="confirmStatementRemove(\'' + statement.title + '\', event)" action="/statement/delete/' + statement.id + '" method="post">' +
                                   '<input type="hidden" name="_method" value="DELETE">' +
                                    '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                                    '<button id="removeStatementForm" class="statements_categories_btn">Удалить фотоматериал</button>' +
                                    '</form>' +


                                    '</div>' +
                                    '</div>' +
                                    '</div>'
                                    );
                            }
                        });
                    }
                }
            });
        } else if (searchTerm === '') {

            $('#searchResultsAdmin').html(initialDialogs);
        } else {

        }
    });
});