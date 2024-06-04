<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="reports_field_setting">

        <div class="statements_settings">

            <div class="statements_settings_left">

                <button onclick="location.href='{{ route('reports') }}';"
                    class="long_button {{ Route::is('reports') ? 'selected' : '' }}">Жалобы</button>
                <button onclick="location.href='{{ route('admin.navigation.statements') }}';"
                    class="long_button {{ Route::is('admin.navigation.statements') ? 'selected' : '' }}">Фотоматериалы</button>
                <button onclick="location.href='{{ route('admin.navigation.videos') }}';"
                    class="long_button {{ Route::is('admin.navigation.videos') ? 'selected' : '' }}">Видеоматериалы</button>
                <button onclick="location.href='{{ route('admin.navigation.users') }}';"
                    class="long_button {{ Route::is('admin.navigation.users') ? 'selected' : '' }}">Пользователи</button>


                    <div class="statements_settings_right">
                        <div class="dropdown">
                            <div class="dropbtn">Настройки</div>
                            <div class="dropdown-content">

                                <a href="{{ route('admin.navigation.view.category') }}" class="long_button">Категории</a>
                
                                <a href="{{ route('admin.navigation.view.reason') }}" class="long_button">Причины</a>
                
                            </div>
                        </div>
                
                    </div>

            </div>
        </div>






    </div>

    <div class="reports_field_frame_test">



        @if (Route::is('admin.navigation.view.category'))

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="static_form">
                    <div class="max-w-xl">
                        @include('admin.partials.create-category-form')
                    </div>
                </div>


                <div class="static_form">
                    <header>
                        <h2 class="txt_2">
                            {{ __('Имеющиеся категории') }}
                        </h2>

                    </header>
                      

@foreach ($categories as $category)

<div id="category-{{ $category->id }}" style="display: flex; justify-content:space-between;">
    <div class="category-name">{{ $category->name }}</div>
    <input type="text" class="message_history_input_container" value="{{ $category->name }}" style="display:none;">
    <button class="save-button" data-id="{{ $category->id }}" style="display:none;">Сохранить</button>
    <div>Дата создания {{ $category->created_at }}</div>
    <div style="display: flex; justify-content:space-between;">
        <button class="long_button edit-button" data-id="{{ $category->id }}">Редактировать</button>
        @csrf
        <x-danger-button class="delete-category" data-id="{{ $category->id }}">Удалить</x-danger-button>
    </div>
</div>
@endforeach

                    </div>
                </div>

            </div>


            <script>
                $(document).ready(function() {
                    // Удаление категории
                    $('.delete-category').click(function(e) {
                        e.preventDefault();
            
                        var categoryId = $(this).data('id');
                        var url = `/adminnavigation/delete/category/${categoryId}`;
            
                        if (confirm('Вы уверены, что хотите удалить эту категорию?')) {
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $(`#category-${categoryId}`).remove();

                                    showFlashSuccess('Категория успешно удалена!');

                                    } else {
                                    showFlashError('Ошибка при удалении категории!');


                                    }
                                },
                                error: function(xhr) {
                                    showFlashError('Ошибка при удалении категории!');

                                }
                            });
                        }
                    });
            
                    // Переход в режим редактирования
                    $('.edit-button').click(function(e) {
                        e.preventDefault();
            
                        var categoryId = $(this).data('id');
                        var categoryDiv = $(`#category-${categoryId}`);
                        categoryDiv.find('.category-name').hide();
                        categoryDiv.find('.message_history_input_container').show();
                        categoryDiv.find('.save-button').show();
                        $(this).hide();
                    });
            
                    // Сохранение изменений
                    $('.save-button').click(function(e) {
                        e.preventDefault();
            
                        var categoryId = $(this).data('id');
                        var categoryDiv = $(`#category-${categoryId}`);
                        var newName = categoryDiv.find('.message_history_input_container').val();
                        var url = `/adminnavigation/update/category/${categoryId}`;
            
                        $.ajax({
                            url: url,
                            type: 'PUT',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                name: newName
                            },
                            success: function(response) {
                                if (response.success) {
                                    categoryDiv.find('.category-name').text(newName).show();
                                    categoryDiv.find('.message_history_input_container').hide();
                                    categoryDiv.find('.save-button').hide();
                                    categoryDiv.find('.edit-button').show();
                                    showFlashSuccess('Категория успешно обновлена!');

                                } else {
                                    alert('Ошибка при обновлении категории!');
                                    showFlashError('Ошибка при обновлении категории!');

                                }
                            },
                            error: function(xhr) {
                                showFlashError('Ошибка при обновлении категории!');

                            }
                        });
                    });
                });
                </script>


        @endif


        
        @if (Route::is('admin.navigation.view.reason'))

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="static_form">
                    <div class="max-w-xl">
                        @include('admin.partials.create-reason-form')
                    </div>
                </div>


                <div class="static_form">
                    <div class="max-w-xl">
                        Имеющиеся причины
                    </div>

                    @foreach ($reasons as $reason)

                    <div id="reason-{{ $reason->id }}" style="display: flex; justify-content:space-between;">
                        <div class="reason-name">{{ $reason->name }}</div>
                        <input type="text" class="message_history_input_container" value="{{ $reason->name }}" style="display:none;">
                        <button class="save-button" data-id="{{ $reason->id }}" style="display:none;">Сохранить</button>
                        <div>Дата создания {{ $reason->created_at }}</div>
                        <div style="display: flex; justify-content:space-between;">
                            <button class="long_button edit-button" data-id="{{ $reason->id }}">Редактировать</button>
                            @csrf
                            <x-danger-button class="delete-reason" data-id="{{ $reason->id }}">Удалить</x-danger-button>
                        </div>
                    </div>
                    @endforeach

                </div>

            </div>
        </div>

        <script>
            $(document).ready(function() {
                // Удаление причины
                $('.delete-reason').click(function(e) {
                    e.preventDefault();
        
                    var reasonId = $(this).data('id');
                    var url = `/adminnavigation/delete/reason/${reasonId}`;
        
                    if (confirm('Вы уверены, что хотите удалить эту причину?')) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    $(`#reason-${reasonId}`).remove();
                                    showFlashSuccess('Причина успешно удалена!');
                                } else {
                                    showFlashError('Ошибка при удалении причины!');

                                }
                            },
                            error: function(xhr) {
                                showFlashError('Ошибка при удалении причины!');

                            }
                        });
                    }
                });
        
                // Переход в режим редактирования
                $('.edit-button').click(function(e) {
                    e.preventDefault();
        
                    var reasonId = $(this).data('id');
                    var reasonDiv = $(`#reason-${reasonId}`);
                    reasonDiv.find('.reason-name').hide();
                    reasonDiv.find('.message_history_input_container').show();
                    reasonDiv.find('.save-button').show();
                    $(this).hide();
                });
        
                // Сохранение изменений
                $('.save-button').click(function(e) {
                    e.preventDefault();
        
                    var reasonId = $(this).data('id');
                    var reasonDiv = $(`#reason-${reasonId}`);
                    var newName = reasonDiv.find('.message_history_input_container').val();
                    var url = `/adminnavigation/update/reason/${reasonId}`;
        
                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            name: newName
                        },
                        success: function(response) {
                            if (response.success) {
                                reasonDiv.find('.reason-name').text(newName).show();
                                reasonDiv.find('.message_history_input_container').hide();
                                reasonDiv.find('.save-button').hide();
                                reasonDiv.find('.edit-button').show();
                                showFlashSuccess('Причина успешно обновлена!');

                            } else {
                                showFlashError('Ошибка при обновлении причины!');

                            }
                        },
                        error: function(xhr) {
                            showFlashError('Ошибка при обновлении причины!');

                        }
                    });
                });
            });
            </script>
        

        @endif


    </div>






</x-app-layout>