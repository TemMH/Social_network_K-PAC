<section>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'statement-modal {{ $statement->id }}')">

        <div class="statement_block" id="statement_{{ $statement->id }}" data-statementId="{{ $statement->id }}">

            <div class="statement_block_top">
                <div class="statement_block_top_info_left">
                    <div class="statement_block_top_avatar">

                        @if ($statement->user->avatar !== null)
                            <a href="{{ route('profile.profileuser', ['id' => $statement->user_id]) }}">
                                <img class="avatar_mini" src="{{ asset('storage/' . $statement->user->avatar) }}"
                                    alt="Avatar">
                            </a>
                        @else
                            <a href="{{ route('profile.profileuser', ['id' => $statement->user_id]) }}">
                                <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                            </a>
                        @endif

                    </div>

                    <div class="statement_block_top_info">

                        <div class="statement_block_top_info_name">{{ $statement->user->name }} </div>

                        @if (!function_exists('pluralForm'))
                            @php
                                function pluralForm($number, $one, $two, $five)
                                {
                                    $number = abs($number) % 100;
                                    $remainder = $number % 10;

                                    if ($number > 10 && $number < 20) {
                                        return $five;
                                    }

                                    if ($remainder > 1 && $remainder < 5) {
                                        return $two;
                                    }

                                    if ($remainder == 1) {
                                        return $one;
                                    }

                                    return $five;
                                }
                            @endphp
                        @endif

                        @php
                            $createdAt = strtotime($statement->created_at);
                            $currentDate = strtotime(date('Y-m-d H:i:s'));
                            $timeDiff = $currentDate - $createdAt;

                            if ($timeDiff >= 86400) {
                                $days = floor($timeDiff / 86400);
                                $formattedTime = $days . ' ' . pluralForm($days, 'день', 'дня', 'дней') . ' назад';
                            } elseif ($timeDiff >= 3600) {
                                $hours = floor($timeDiff / 3600);
                                $formattedTime = $hours . ' ' . pluralForm($hours, 'час', 'часа', 'часов') . ' назад';
                            } elseif ($timeDiff >= 60) {
                                $minutes = floor($timeDiff / 60);
                                $formattedTime =
                                    $minutes . ' ' . pluralForm($minutes, 'минута', 'минуты', 'минут') . ' назад';
                            } else {
                                $formattedTime = 'только что';
                            }
                        @endphp

                        <div class="statement_block_top_info_createdat">{{ $formattedTime }}</div>

                    </div>

                </div>

                <div class="statement_block_top_info_right">

                    {{-- LIKE/UNLIKE --}}
                    <div class="statement_block_top_info_right_info">
                        @if (!$statement->likes()->where('user_id', auth()->id())->exists())
                            <div>
                                @include('general.elements.svg-like')
                            </div>
                            <div>{{ $statement->likes_count }}</div>
                        @else
                            <div>
                                @include('general.elements.svg-unlike')
                            </div>

                            <div>{{ $statement->likes_count }}</div>
                        @endif
                    </div>


                    {{-- COMMENTS --}}
                    <div class="statement_block_top_info_right_info">
                        <div>
                            @include('general.elements.svg-comments')
                        </div>
                        <span>{{ $statement->comments_count }}</span>
                    </div>


                    {{-- VIEWS --}}
                    <div class="statement_block_top_info_right_info">
                        <div>
                            @include('general.elements.svg-view')
                        </div>
                        <span>
                            {{ $statement->views_count }}
                        </span>
                    </div>

                </div>

            </div>

            <div class="statement_block_middle">

                <img src="{{ asset('storage/' . $statement->photo_path) }}" alt="Photo">

            </div>

            <div class="statement_block_down">

                <div class="statement_block_down_title">{{ $statement->title }}</div>

            </div>

        </div>

    </button>






    <x-modal name="statement-modal {{ $statement->id }}" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div class="statement_block_open">
            <div class="statement_block_top_open">
                <div class="statement_block_top_info_left_open">
                    <div class="statement_block_top_avatar_open">
                        @if ($statement->user->avatar !== null)
                            <a href="{{ route('profile.profileuser', ['id' => $statement->user_id]) }}">
                                <img class="avatar_mini" src="{{ asset('storage/' . $statement->user->avatar) }}"
                                    alt="Avatar">
                            </a>
                        @else
                            <a href="{{ route('profile.profileuser', ['id' => $statement->user_id]) }}">
                                <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                            </a>
                        @endif
                    </div>
                    <div class="statement_block_top_info_open">
                        <div class="statement_block_top_info_name_open">
                            <a href="{{ route('profile.profileuser', ['id' => $statement->user_id]) }}">
                                {{ $statement->user->name }}
                            </a>
                        </div>
                        <div class="statement_block_top_info_createdat_open">
                            {{ $statement->created_at }}
                        </div>
                    </div>
                </div>
                <div class="statement_block_top_info_right_open">
                    @if (!$statement->likes()->where('user_id', auth()->id())->exists())
                        {{-- like --}}
                        <div class="mini_button">
                            <button type="submit" class="like-button" data-id="{{ $statement->id }}">
                                @include('general.elements.svg-like')
                            </button>
                        </div>
                    @else
                        {{-- REMOVE LIKE --}}
                        <div class="mini_button">
                            <button type="submit" class="unlike-button" data-id="{{ $statement->id }}">
                                @include('general.elements.svg-unlike')

                            </button>
                        </div>
                    @endif
                    {{-- REPOST --}}
                    @livewire('repost-statement-component', ['statementId' => $statement->id])
                    {{-- OPEFULL --}}

                    <a href="{{ route('statementuser', ['id' => $statement->id]) }}" id="openFull"
                        class="mini_button">

                        @include('general.elements.svg-openfull')
                    </a>
                </div>
            </div>
            <div class="statement_block_middle_open_img_lock">
                <div class="statement_block_middle_open">
                    <img src="{{ asset('storage/' . $statement->photo_path) }}" alt="Photo">
                </div>
            </div>
            <div class="statement_block_down_open">

                <div class="statement_block_down_title_open">
                    <p>{{ $statement->title }}</p>
                </div>
                <div class="statement_block_down_description_open">
                    <p>{{ $statement->description }}</p>
                </div>
            </div>
            <div class="statement_block_comments_open">
                <form id="commentForm_{{ $statement->id }}" class="comment-form" data-statement-id="{{ $statement->id }}" method="POST" action="{{ route('statement.comment', ['id' => $statement->id]) }}">
                    <div class="statementuser_comment">
                        @csrf
                        <div class="main_novost_img">
                            @if (Auth::user()->avatar !== null)
                                <img class="avatar_mini" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar">
                            @else
                                <img class="avatar_mini" src="/uploads/ProfilePhoto.png" width="50px" height="50px">
                            @endif
                        </div>
                        <input class="form_field_comment" name="comment" placeholder="Введите комментарий..." required>
                        <div class="submit_comment">
                            <button class="mini_button">
                                @include('general.elements.svg-send')
                            </button>
                        </div>
                    </div>
                </form>
                <div class="statementuser_comment_show">
                    @foreach ($statement->comments as $comment)
                        <div class="main_novost_top">
                            <a href="{{ route('profile.profileuser', ['id' => $comment->user_id]) }}">
                                <div class="main_novost_img">
                                    @if ($comment->user->avatar !== null)
                                        <a href="{{ route('profile.profileuser', ['id' => $comment->user_id]) }}">
                                            <img class="avatar_mini" src="{{ asset('storage/' . $comment->user->avatar) }}" alt="Avatar">
                                        </a>
                                    @else
                                        <a href="{{ route('profile.profileuser', ['id' => $comment->user_id]) }}">
                                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                        </a>
                                    @endif
                                </div>
                                <div class="main_novost_title">
                                    <div>
                                        <a href="{{ route('profile.profileuser', ['id' => $comment->user_id, 'previous' => 'news']) }}">
                                            <p class="txt_2">{{ $comment->user->name }}</p>
                                        </a>
                                    </div>
                                    <div>
                                        <p class="txt_2">{{ $comment->created_at }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="main_comment_show">
                            <p class="txt_2">{{ $comment->content }}</p>
                        </div>
                        @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Manager')
                            <form method="POST" action="{{ route('admin.statement.comment.delete', ['statementId' => $statement->id, 'commentId' => $comment->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="novost_down_func" type="submit">Удалить комментарий</button>
                            </form>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </x-modal>
</section>
