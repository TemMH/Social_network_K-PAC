<section>

    <div class="notification_block_contents_wrap">

        <div class="profileuser_block_contents_second_wrap_title">
            <p>Фотоматериалы</p>
        </div>

        <div class="right_block_wrap_line"></div>


    </div>

    <div id="searchResultsAdmin">
    @foreach ($statements as $statement)


        <div class="report_content_test">

            <div class="report_block_top_open">


                <div class="report_block_top_info_left_open">



                    <a href="{{ route('statementuser', ['id' => $statement->id]) }}" class="statement_block_top_image_open">
                        <img src="{{ asset('storage/' . $statement->photo_path) }}" alt="Thumbnail"
                            style="object-fit:contain;" class="videoThumbnail" style="cursor:pointer;">
                    </a>

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



                </div>
            </div>


            <div class="report_block_down_open">

                <div class="statement_block_down_views_open">
                    @if ($statement->isBlocked())
                    <p>Заблокирован {{ $statement->bans->first()->created_at }}</p> 
                    <p>пользователем {{ optional($statement->bans->first()->sender)->name }}</p>
                    <p>По причине: {{ optional($statement->bans->first()->reason)->name }}</p>

                    @else
                    <p>Не заблокирован</p>    
                    @endif
                </div>

                <div class="statement_block_down_description_open" style="display: flex;">
                    @if ($statement->isBlocked())
                    <form id="sendcomplaint" action="{{ route('admin.delete.ban.statement', ['statement' => $statement->id]) }}" method="post">
                        @csrf
                    <button name="edit_status" value="rejected" class="statements_categories_btn" > Разблокировать </button>
                    </form>
                    @else
    
                    <form id="sendcomplaint" action="{{ route('complaint.post.statement', ['statement' => $statement->id]) }}" method="post">
                        @csrf
                    <button name="edit_status" value="accepted" class="statements_categories_btn" > Заблокировать </button>
                    </form>
    
                    @endif


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


@vite(['resources/js/search-input/admin/SearchAdminStatement.js'])


</section>