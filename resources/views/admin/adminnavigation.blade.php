<x-app-layout>
    <x-slot name="header">

    </x-slot>





    <div class="reports_field_setting">

        <div class="statements_settings">

            <div class="statements_settings_left">

                <button onclick="location.href='{{ route('reports') }}';"
                    class="statements_type_btn {{ Route::is('reports') ? 'selected' : '' }}">Жалобы</button>
                <button onclick="location.href='{{ route('admin.navigation.statements') }}';"
                    class="statements_type_btn {{ Route::is('admin.navigation.statements') ? 'selected' : '' }}">Фотоматериалы</button>
                <button onclick="location.href='{{ route('admin.navigation.videos') }}';"
                    class="statements_type_btn {{ Route::is('admin.navigation.videos') ? 'selected' : '' }}">Видеоматериалы</button>
                <button onclick="location.href='{{ route('admin.navigation.users') }}';"
                    class="statements_type_btn {{ Route::is('admin.navigation.users') ? 'selected' : '' }}">Пользователи</button>
                    <button onclick="location.href='{{ route('admin.navigation.create') }}';"
                    class="statements_type_btn {{ Route::is('admin.navigation.create') ? 'selected' : '' }}">Добавить</button>

            </div>


            <div class="reports_settings_middle">

                <input type="text" id="searchInputdAdmin" name="search" class="message_history_input_container"
                    placeholder="Введите название...">

            </div>



            <form class="statements_settings_right" id="categoryForm" method="GET" action="{{ url()->current() }}">
                <button name="status" value="" class="statements_categories_btn">Все</button>
                <button name="status" value="new" class="statements_categories_btn">Доступные</button>
                <button name="status" value="block" class="statements_categories_btn">Заблокированные</button>
                <button name="status" value="unblock" class="statements_categories_btn">Разрешенные</button>
            </form>







        </div>






    </div>
    <div class="reports_field_frame_test" >

            {{-- Видеоматериалы --}}

            @if (Route::is('admin.navigation.videos'))
                <div class="notification_block_contents_wrap">

                    <div class="profileuser_block_contents_second_wrap_title">
                        <p>Видеоматериалы</p>
                    </div>

                    <div class="right_block_wrap_line"></div>


                </div>

                <div id="searchResultsAdmin">
                @foreach ($videos as $video)
                @include('admin.partials.complaint-modal-reason', ['video' => $video])


                    <div class="report_content_test">

                        <div class="report_block_top_open">


                            <div class="report_block_top_info_left_open">



                                <div class="statement_block_top_image_open">
                                    <img src="{{ asset('storage/' . $video->thumbnail_path) }}" alt="Thumbnail"
                                        style="object-fit:contain;" class="videoThumbnail" style="cursor:pointer;">
                                </div>

                                <div class="statement_block_top_addinfo">

                                    <div class="statement_block_top_addinfo_first">

                                        <p> {{ $video->title }} </p>

                                    </div>


                                    <div class="statement_block_top_addinfo_second">

                                        <div class="statement_block_top_avatar_open">
                                            @if ($video->user->avatar !== null)
                                                <img class="avatar_mini"
                                                    src="{{ asset('storage/' . $video->user->avatar) }}"
                                                    alt="Avatar">
                                            @else
                                                <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                            @endif
                                        </div>


                                        <p>{{ $video->user->name }}</p>

                                    </div>

                                    <div class="statement_block_top_addinfo">


                                        <p>{{ $video->created_at }}</p>

                                    </div>

                                </div>
                            </div>

                            <div class="report_block_top_info_right_open">




                                <div class="report_block_top_info_right_open">

                                </div>


                            </div>



                        </div>


                        <div class="report_block_down_open">


                            <div class="statement_block_down_views_open">
                                <p>Статус: </p>
                            </div>

                            <div class="statement_block_down_description_open" style="display: flex;">

                                @if (!$video->complaints->contains('status', 'block') && !$video->complaints->contains('status', 'unblock'))
                                <button class="statements_categories_btn" 
                                data-user-id="{{ $user->id ?? null }}" 
                                data-video-id="{{ $video->id }}"
                                data-statement-id="{{ $statement->id ?? null }}" 
                                onclick="confirmSendComplaint(this)"> Заблокировать </button>
                                
                                @endif


                                <form onclick="confirmVideoRemove('{{ $video->title }}', event)"
                                    action="{{ route('admin.video.delete', $video) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button id="removeVideoForm" class="statements_categories_btn">Удалить
                                        видеоматериал</button>
                                </form>
                                
                            </div>


                        </div>

                    </div>
                @endforeach
                </div>
            <script>
                function confirmVideoRemove(title, event) {
                    if (!confirm('Вы уверены, что хотите удалить видео ' + title + ' ?')) {
                        event.preventDefault();
                    }
                }
            </script>




<script>
    $(document).ready(function() {
        // изначальный список
        var initialDialogs = $('#searchResultsAdmin').html();

        $('#searchInputdAdmin').on('input', function() {
            let searchTerm = $(this).val().trim();

            if (searchTerm.length >= 3) {
                $.ajax({
                    type: 'GET',
                    url: '/admin/autocomplete/video',
                    data: {
                        search: searchTerm
                    },
                    success: function(response) {
                        console.log(response);
                        let resultsDiv = $('#searchResultsAdmin');
                        resultsDiv.empty();

                        if (searchTerm !== '') {
                            $.each(response.videos, function(index, video) {
                                if (video) {

                                    var createdDate = new Date(video.created_at);
var formattedDate = createdDate.toISOString().replace('T', ' ').replace(/\.\d+Z$/, '');

var avatarSrc = (video.user && video.user.avatar) ? response.base_url + '/' + video.user.avatar : '/uploads/ProfilePhoto.png';

                                    resultsDiv.append(
                    '<div class="report_content_test">' +
                        '<div class="report_block_top_open">' +
                            '<div class="report_block_top_info_left_open">' +
                                '<div class="statement_block_top_image_open">' +
                                    '<img src="' + response.base_url + '/' + video.thumbnail_path + '" alt="Thumbnail" style="object-fit:contain;" class="videoThumbnail" style="cursor:pointer;">' +
                                '</div>' +
                                '<div class="statement_block_top_addinfo">' +
                                    '<div class="statement_block_top_addinfo_first">' +
                                        '<p>' + video.title + '</p>' +
                                    '</div>' +
                                    '<div class="statement_block_top_addinfo_second">' +
                                        '<div class="statement_block_top_avatar_open">' +
                                            '<img class="avatar_mini" src="' + avatarSrc + '" alt="Avatar">' +  
                                        '</div>' +
                                        '<p>' + video.user.name + '</p>' +
                                    '</div>' +
                                    '<div class="statement_block_top_addinfo">' +
                                        '<p>' + formattedDate + '</p>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                                                '<div class="report_block_top_info_right_open">' +
                                                    '<form action="/complaint/post/video/' + video + '" style="display: flex; flex-direction:column; align-items:flex-end;" method="POST">' +
                                                        '@csrf' +
                                                        '<select class="message_history_input_container"  name="edit_status" id="edit_status">' +
                                                            '<option value="unblock">Разрешить</option>' +
                                                            '<option value="block">Заблокировать</option>' +
                                                        '</select>' +
                                                        '<button type="submit" class="statements_categories_btn">Применить</button>' +
                                                    '</form>' +
                                                '</div>' +
                                            '</div>' +
                                            '<div class="report_block_down_open">' +
                                                '<div class="statement_block_down_views_open">' +
                                                    '<p>Статус: </p>' +
                                                '</div>' +
                                                '<div class="statement_block_down_description_open" style="display: flex;">' +
                                                    '<form onclick="confirmUserRemove(\'' + video.title + '\', event)" action="/admin/video/delete/' + video.id + '" method="post">' +
                                                        '@method('DELETE')' +
                                                        '@csrf' +
                                                        '<button id="removeUserForm" class="statements_categories_btn">Удалить видеоматериал</button>' +
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
</script>

            @endif

            {{-- Фотоматериалы --}}



            @if (Route::is('admin.navigation.statements'))
                <div class="notification_block_contents_wrap">

                    <div class="profileuser_block_contents_second_wrap_title">
                        <p>Фотоматериалы</p>
                    </div>

                    <div class="right_block_wrap_line"></div>


                </div>

                <div id="searchResultsAdmin">
                @foreach ($statements as $statement)
                @include('admin.partials.complaint-modal-reason', ['statement' => $statement])

                    <div class="report_content_test">

                        <div class="report_block_top_open">


                            <div class="report_block_top_info_left_open">



                                <div class="statement_block_top_image_open">
                                    <img src="{{ asset('storage/' . $statement->photo_path) }}" alt="Thumbnail"
                                        style="object-fit:contain;" class="videoThumbnail" style="cursor:pointer;">
                                </div>

                                <div class="statement_block_top_addinfo">

                                    <div class="statement_block_top_addinfo_first">

                                        <p>{{ $statement->title }}</p>

                                    </div>


                                    <div class="statement_block_top_addinfo_second">

                                        <div class="statement_block_top_avatar_open">
                                            @if ($statement->user->avatar !== null)
                                                <img class="avatar_mini"
                                                    src="{{ asset('storage/' . $statement->user->avatar) }}"
                                                    alt="Avatar">
                                            @else
                                                <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                            @endif
                                        </div>

                                        <p>{{ $statement->user->name }}</p>

                                    </div>

                                    <div class="statement_block_top_addinfo">


                                        <p>{{ $statement->created_at }}</p>

                                    </div>

                                </div>
                            </div>
                            <div class="report_block_top_info_right_open">

                                <div class="report_block_top_info_right_open">
                                    @if (!$statement->complaints->contains('status', 'block') && !$statement->complaints->contains('status', 'unblock'))
                                    <button class="statements_categories_btn" 
                                    data-user-id="{{ $user->id ?? null }}" 
                                    data-video-id="{{ $video->id ?? null }}"
                                    data-statement-id="{{ $statement->id }}" 
                                    onclick="confirmSendComplaint(this)"> Заблокировать </button>
                                        @endif
                                </div>

                            </div>
                        </div>


                        <div class="report_block_down_open">

                            <div class="statement_block_down_views_open">
                                <p>Статус: </p>
                            </div>

                            <div class="statement_block_down_description_open" style="display: flex;">


                                <form onclick="confirmStatementRemove('{{ $statement->title }}', event)"
                                    action="{{ route('admin.statement.delete', $statement) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button id="removeStatementForm" class="statements_categories_btn">Удалить
                                        фотоматериал</button>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
                </div>
                <script>
                    function confirmStatementRemove(title, event) {
                        if (!confirm('Вы уверены, что хотите удалить запись "' + title + '"?')) {
                            event.preventDefault();
                        }
                    }
                </script>




<script>
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

                                    var createdDate = new Date(statement.created_at);
var formattedDate = createdDate.toISOString().replace('T', ' ').replace(/\.\d+Z$/, '');

var avatarSrc = (statement.user && statement.user.avatar) ? response.base_url + '/' + statement.user.avatar : '/uploads/ProfilePhoto.png';

                                    resultsDiv.append(
                    '<div class="report_content_test">' +
                        '<div class="report_block_top_open">' +
                            '<div class="report_block_top_info_left_open">' +
                                '<div class="statement_block_top_image_open">' +
                                    '<img src="' + response.base_url + '/' + statement.photo_path + '" alt="Thumbnail" style="object-fit:contain;" class="videoThumbnail" style="cursor:pointer;">' +
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
                                                    '<form action="/complaint/post/statement/' + statement + '" style="display: flex; flex-direction:column; align-items:flex-end;" method="POST">' +
                                                        '@csrf' +
                                                        '<select class="message_history_input_container" name="edit_status" id="edit_status">' +
                                                            '<option value="unblock">Разрешить</option>' +
                                                            '<option value="block">Заблокировать</option>' +
                                                        '</select>' +
                                                        '<button type="submit" class="statements_categories_btn">Применить</button>' +
                                                    '</form>' +
                                                '</div>' +
                                            '</div>' +
                                            '<div class="report_block_down_open">' +
                                                '<div class="statement_block_down_views_open">' +
                                                    '<p>Статус: </p>' +
                                                '</div>' +
                                                '<div class="statement_block_down_description_open" style="display: flex;">' +
                                                    '<form onclick="confirmUserRemove(\'' + statement.title + '\', event)" action="/admin/statement/delete/' + statement.id + '" method="post">' +
                                                        '@method('DELETE')' +
                                                        '@csrf' +
                                                        '<button id="removeUserForm" class="statements_categories_btn">Удалить фотоматериал</button>' +
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
</script>

            @endif





            {{-- Пользователи --}}


            @if (Route::is('admin.navigation.users'))



                <div class="notification_block_contents_wrap">

                    <div class="profileuser_block_contents_second_wrap_title">
                        <p>Пользователи</p>
                    </div>

                    <div class="right_block_wrap_line"></div>


                </div>

                <div id="searchResultsAdmin">
                @foreach ($users as $user)
                @include('admin.partials.complaint-modal-reason', ['user' => $user])


                    <div class="report_content_test">

                        <div class="report_block_top_open">


                            <div class="report_block_top_info_left_open">



                                <div class="statement_block_top_user_image_open">
                                    @if ($user->avatar !== null)
                                        <img class="avatar_mini" src="{{ asset('storage/' . $user->avatar) }}"
                                            alt="Avatar">
                                    @else
                                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                    @endif
                                </div>

                                <div class="statement_block_top_addinfo">

                                    <div class="statement_block_top_addinfo">

                                        <p>{{ $user->name }}</p>

                                    </div>


                                    <div class="statement_block_top_addinfo">


                                        <p>{{ $user->condition }}</p>

                                    </div>

                                    <div class="statement_block_top_addinfo">


                                        <p>{{ $user->created_at }}</p>

                                    </div>

                                </div>
                            </div>

                            <div class="report_block_top_info_right_open">




                                <div class="report_block_top_info_right_open">
                                    @if (!$user->complaints->contains('status', 'block') && !$user->complaints->contains('status', 'unblock'))
                                                        <button class="statements_categories_btn" 
                        data-user-id="{{ $user->id }}" 
                        data-video-id="{{ $video->id ?? null }}"
                        data-statement-id="{{ $statement->id ?? null }}" 
                        onclick="confirmSendComplaint(this)"> Заблокировать </button>
                        
                        @endif
                                </div>


                            </div>



                        </div>


                        <div class="report_block_down_open">

                            <div class="statement_block_down_views_open">
                                <p>Статус: </p>
                            </div>

                            <div class="statement_block_down_description_open" style="display: flex;">


                                <form onclick="confirmUserRemove('{{ $user->name }}', event)"
                                    action="{{ route('admin.user.delete', $user) }}" method="post">

                                    @method('DELETE')
                                    @csrf

                                    <button id="removeUserForm" class="statements_categories_btn">Удалить
                                        пользователя</button>

                                </form>

                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

                <script>
                    function confirmUserRemove(name, event) {
                        if (!confirm('Вы уверены, что хотите удалить пользователя "' + name + '"?')) {
                            event.preventDefault();
                        }
                    }
                </script>



<script>
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

                                    var createdDate = new Date(user.created_at);
var formattedDate = createdDate.toISOString().replace('T', ' ').replace(/\.\d+Z$/, '');


                                    var avatarSrc = user.avatar ? response.base_url + '/' + user.avatar : '/uploads/ProfilePhoto.png';

                                    resultsDiv.append(
                                        '<div class="report_content_test">' +
                                            '<div class="report_block_top_open">' +
                                                '<div class="report_block_top_info_left_open">' +
                                                    '<div class="statement_block_top_user_image_open">' +
                                                        '<img class="avatar_mini" src="' + avatarSrc + '" alt="Avatar">' +  
                                                    '</div>' +
                                                    '<div class="statement_block_top_addinfo">' +
                                                    '<div class="statement_block_top_addinfo">' +
                                                        '<p>' + user.name + '</p>' +
                                                    '</div>' +
                                                    '<div class="statement_block_top_addinfo">' +
                                                    '<p>' + (user.condition ? user.condition : '') + '</p>' +
                                                    '<div class="statement_block_top_addinfo">' +
                                                        '</div>' +
                                                        '<p>' + formattedDate + '</p>' +
                                                        '</div>'+
                                                '</div>' +
                                                '</div>' +
                                                '<div class="report_block_top_info_right_open">' +
                                                    '<form action="/complaint/post/user/' + user + '" style="display: flex; flex-direction:column; align-items:flex-end;" method="POST">' +
                                                        '@csrf' +
                                                        '<select class="message_history_input_container" name="edit_status" id="edit_status">' +
                                                            '<option value="unblock">Разрешить</option>' +
                                                            '<option value="block">Заблокировать</option>' +
                                                        '</select>' +
                                                        '<button type="submit" class="statements_categories_btn">Применить</button>' +
                                                    '</form>' +
                                                '</div>' +
                                            '</div>' +
                                            '<div class="report_block_down_open">' +
                                                '<div class="statement_block_down_views_open">' +
                                                    '<p>Статус: </p>' +
                                                '</div>' +
                                                '<div class="statement_block_down_description_open" style="display: flex;">' +
                                                    '<form onclick="confirmUserRemove(\'' + user.name + '\', event)" action="/admin/user/delete/' + user.id + '" method="post">' +
                                                        '@method('DELETE')' +
                                                        '@csrf' +
                                                        '<button id="removeUserForm" class="statements_categories_btn">Удалить пользователя</button>' +
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
</script>


            @endif

        </div>




</x-app-layout>
