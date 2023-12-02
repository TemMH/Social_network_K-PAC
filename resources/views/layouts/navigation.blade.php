<nav x-data="{ open: false }" class="header-up">
    <div class="header-up">

        <div class="datetime">

            <div class="time">
                <p class="txt_2">
                    @php

                        use Carbon\Carbon;
                        $date = Carbon::now();
                        echo $date->format('H:i   d M ');

                    @endphp
                </p>

            </div>


        </div>


        <div class="px"></div>

        <div class="nav_right">

            @if (Auth::check())
                <div class="field_notification" id="notificationBlock">



                    <?php
                    $friendRequests = \App\Models\Friendship::where('recipient_id', auth()->id())
                        ->where('status', 'pending')
                        ->get();
                    ?>

                    @foreach ($friendRequests as $request)
                        <div class="notificationitem" id="notificationitem">

                            <p>
                                <a href="{{ route('profileuser.profile', ['id' => $request->id]) }}">
                                    {{ $request->sender->name }}
                                </a>

                                отправил вам запрос в друзья

                            </p>


                            <div class="notification-actions">
                                <div>
                                    <form action="{{ route('accept-friend-request', $request->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="accept-btn">Принять</button>
                                    </form>
                                </div>

                                <div>
                                    <form action="{{ route('reject-friend-request', $request->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="reject-btn">Отказать</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach






                    <div class="notification_line">

                    </div>




                    <?php
                    $friendsList = \App\Models\Friendship::where(function ($query) {
                        $query->where('sender_id', auth()->id())->where('status', 'accepted');
                    })
                        ->orWhere(function ($query) {
                            $query->where('recipient_id', auth()->id())->where('status', 'accepted');
                        })
                        ->get();
                    
                    $friendIds = $friendsList
                        ->pluck('sender_id')
                        ->merge($friendsList->pluck('recipient_id'))
                        ->unique();
                    
                    $friends = \App\Models\User::whereIn('id', $friendIds)->get();
                    ?>


                    @foreach ($friends as $friend)
                        @if ($friend->id !== auth()->id())
                            <a href="{{ route('profileuser.profile', ['id' => $friend->id]) }}">

                                <div class="notification_friends">
                                    <div class="notification_func_left">
                                        <div class="notification_img">
                                            <img class="avatar" src="{{ asset('storage/' . $friend->avatar) }}" alt="Avatar">
                                        </div>
                                        <div class="main_novost_zagolovok">
                                            <div>


                                                <p>{{ $friend->name }}</p>



                                            </div>
                                            <div>
                                                <p>{{ $friend->condition }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="notification_func_right">
                                        <a href="{{ route('dialog.show', ['userId' => $friend->id]) }}">
                                            <div class="btn_notification_right">

                                                <p>→</p>

                                            </div>
                                        </a>
                                    </div>
                                </div>

                            </a>
                        @endif
                    @endforeach


                    <script>
                        function toggleNotification() {
                            const notificationBlock = document.getElementById('notificationBlock');
                            const notificationItems = document.querySelectorAll('.notificationitem');
                            const notification_friends = document.querySelectorAll('.notification_friends');

                            notificationBlock.classList.toggle('show');

                            notificationItems.forEach(item => {
                                item.classList.toggle('show');
                            });

                            notification_friends.forEach(item => {
                                item.classList.toggle('show');
                            });
                        }
                    </script>


                </div>
                <button class="button_notification" onclick="toggleNotification()">
                    <p>Ув</p>
                </button>

            @endif





            <div class="number">

                <p class="txt_2">+7 (993) 939 99 7* </p>

            </div>

        </div>


    </div>

</nav>
