 $(document).ready(function() {
        // изначальный список
        var initialDialogs = $('#searchResultsAdmin').html();

        $('#searchInputdAdmin').on('input', function() {
            let searchTerm = $(this).val().trim();

            if (searchTerm.length >= 3) {
                $.ajax({
                    type: 'GET',
                    url: '/admin/autocomplete/user',
                    data: {
                        search: searchTerm
                    },
                    success: function(response) {
                        console.log(response);
                        let resultsDiv = $('#searchResultsAdmin');
                        resultsDiv.empty();

                        if (searchTerm !== '') {
                            $.each(response.users, function(index, user) {
                                if (user) {
                                    var isBlocked = user.is_blocked;
                                    var createdDate = new Date(user.created_at);
                                    var formattedDate = createdDate.toISOString().replace('T', ' ').replace(/\.\d+Z$/, '');
                                    
                                    var bannedDate = user.first_ban ? new Date(user.first_ban.created_at) : null;
                                    var formattedDateBan = bannedDate ? bannedDate.toISOString().replace('T', ' ').replace(/\.\d+Z$/, '') : null;


                                    var avatarSrc = user.avatar ? response.base_url + '/' + user.avatar : '/uploads/ProfilePhoto.png';
                                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                                    resultsDiv.append(
                                        '<div class="report_content_test">' +
                                        '<div class="report_block_top_open">' +
                                            '<div class="report_block_top_info_left_open">' +
                                                '<div class="statement_block_top_user_image_open">' +
                                                    '<img class="avatar_mini" src="' + avatarSrc + '" alt="Avatar">' +
                                                '</div>' +
                                                '<div class="statement_block_top_addinfo">' +
                                                    '<p>Имя пользователя: ' + user.name + '</p>' +
                                                    '<p>Роль в веб-приложении: ' + user.role + '</p>' +
                                                    '<p>Почта пользователя: ' + user.email + '</p>' +
                                                    '<p>Состояние: ' + (user.condition ? user.condition : '') + '</p>' +
                                                    '<p>Дата создания аккаунта: ' + formattedDate + '</p>' +
                                                '</div>' +
                                            '</div>' +
                                            '<div class="report_block_top_info_right_open">' +
                                                (user.role !== 'Admin' ?
                                                    '<form id="sendcomplaint" action="/adminnavigation/user/updaterole/' + user.id + '" method="post">' +

                                                    '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                                                        '<div class="dropdown">' +
                                                            '<div class="dropbtn">Изменить роль</div>' +
                                                            '<div class="dropdown-content">' +
                                                                '<button name="role" value="Manager" class="long_button">Менеджер</button>' +
                                                                '<button name="role" value="User" class="long_button">Пользователь</button>' +
                                                            '</div>' +
                                                        '</div>' +
                                                    '</form>' +

                                                    '<form action="/admin/messenger/' + user.id + '" method="get">' +
                        
                                                    '<button class="long_button">Открыть диалоги пользователя</button>' +
            
                                                '</form>'

                                                : '') +
                                            '</div>' +
                                        '</div>' +
                                        (user.role !== 'Admin' ?
                                            '<div class="report_block_down_open">' +
                                                '<div class="statement_block_down_views_open">' +
                                                (isBlocked ?
                                                    '<p>Заблокирован: ' + formattedDateBan + '</p>' +
                                                        '<p>пользователем: ' + (user.first_ban.sender_name ? user.first_ban.sender_name : 'Неизвестный отправитель') + '</p>' +
                                                        '<p>По причине: ' + (user.first_ban.reason_name ? user.first_ban.reason_name : 'Неизвестная причина') + '</p>'
                                                    : '<p>Не заблокирован</p>') +
                                                '</div>' +
                                                '<div class="statement_block_down_description_open" style="display: flex;">' +
                                                (isBlocked ?


                                                       '<form id="sendcomplaint" action="/adminnavigation/user/deleteban/' + user.id + '" method="post">' +
                                                        
                                                        '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                                                            '<button name="edit_status" value="rejected" class="statements_categories_btn" > Разблокировать </button>' +
                                                        '</form>'
                                                    :
                                                        '<form id="sendcomplaint" action="/adminnavigation/user/' + user.id + '" method="post">' +

                                                        '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                                                        
                                                            '<button name="edit_status" value="accepted" class="statements_categories_btn" > Заблокировать </button>' +
                                                        '</form>') +
                                                '<form onclick="confirmUserRemove(\'' + user.name + '\', event)" action="/user/delete/' + user.id + '" method="post">' +
                                                    '<input type="hidden" name="_method" value="DELETE">' +
                                                    '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                                                        '<button id="removeUserForm" class="statements_categories_btn">Удалить пользователя</button>' +
                                                    '</form>' +
                                                '</div>' +
                                            '</div>'
                                        : '') +
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