<section>

    <div class="notification_block_contents_wrap">

        <div class="profileuser_block_contents_second_wrap_title">
            <p>Пользователи</p>
        </div>

        <div class="right_block_wrap_line"></div>


    </div>

    <div id="searchResultsAdmin">
    @foreach ($users as $user)


        <div class="report_content_test">

            <div class="report_block_top_open">


                <div class="report_block_top_info_left_open">



                    <a href="{{ route('profile.profileuser', ['id' => $user->id]) }}" class="statement_block_top_user_image_open">
                        @if ($user->avatar !== null)
                            <img class="avatar_mini" src="{{ asset('storage/' . $user->avatar) }}"
                                alt="Avatar">
                        @else
                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                        @endif
                    </a>

                    <div class="statement_block_top_addinfo">

           

                            <p>Имя пользователя: {{ $user->name }}</p> <p>Роль в веб-приложении: {{ $user->role }}</p> 
                            <p>Почта пользователя: {{ $user->email }} {{-- Дата подтверждения почты: {{ $user->email_verifed_at }} --}}</p>
                            <p>Состояние: {{ $user->condition }}</p>
                            <p>Дата создания аккаунта: {{ $user->created_at }}</p>

                 

                    </div>
                </div>

                <div class="report_block_top_info_right_open">




                    <div class="report_block_top_info_right_open">


                        @if($user->role !== 'Admin')
                        <form id="sendcomplaint" action="{{ route('admin.update.role.user', ['user' => $user->id]) }}" method="post">
                            @csrf


                            <div class="dropdown">
                                <div class="dropbtn">Изменить роль</div>
                                <div class="dropdown-content">
    
                                    <button name="role" value="Manager" class="long_button">Менеджер</button>
                                    <button name="role" value="User" class="long_button">Пользователь</button>
    
                                </div>
                            </div>

                        </form>


                        <form action="{{ route('admin.show.messenger', ['user' => $user->id])}}" method="get">
                        
                            <button class="long_button">Открыть диалоги пользователя</button>


                        </form>

@endif

                    </div>


                </div>



            </div>

            @if($user->role !== 'Admin')

            <div class="report_block_down_open">

                <div class="statement_block_down_views_open">
               
                        @if ($user->isBlocked())
                        <p>Заблокирован: {{ $user->bans->first()->created_at }}</p> 
                        <p>пользователем: {{ optional($user->bans->first()->sender)->name }}</p>
                        <p>По причине: {{ optional($user->bans->first()->reason)->name }}</p>
                        @else
                        <p>Не заблокирован</p>    
                        @endif
                  
                    
                </div>

                <div class="statement_block_down_description_open" style="display: flex;">






                    @if ($user->isBlocked())
                    <form id="sendcomplaint" action="{{ route('admin.delete.ban.user', ['user' => $user->id]) }}" method="post">
                        @csrf
                    <button name="edit_status" value="rejected" class="statements_categories_btn" > Разблокировать </button>
                    </form>
                    @else

                    <form id="sendcomplaint" action="{{ route('complaint.post.user', ['user' => $user->id]) }}" method="post">
                        @csrf
                    <button name="edit_status" value="accepted" class="statements_categories_btn" > Заблокировать </button>
                    </form>

                    @endif

                
                    <form onclick="confirmUserRemove('{{ $user->name }}', event)"
                        action="{{ route('admin.user.delete', $user) }}" method="post">

                        @method('DELETE')
                        @csrf

                        <button id="removeUserForm" class="statements_categories_btn">Удалить
                            пользователя</button>

                    </form>

                </div>
            </div>
            @endif



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

@vite(['resources/js/search-input/admin/SearchAdminUser.js'])


</section>