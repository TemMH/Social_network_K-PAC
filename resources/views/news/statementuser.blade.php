<x-app-layout>
    <x-slot name="header">

    </x-slot>

    @include('general.partials.complaint-modal-reason', ['statement' => $statement])



    <div class="full_statement_field">

        <div class="full_statement_block">

            <div class="full_statement_block_user">

                <div class="full_statement_block_user_avatar">

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

                <div class="full_statement_block_user_info">

                    <div class="full_statement_block_user_info_name">
                        <a href="{{ route('profile.profileuser', ['id' => $statement->user_id]) }}">
                            {{ $statement->user->name }}
                        </a>
                    </div>

                    @if ($statement->user->condition !== null)
                        <div class="full_statement_block_user_info_condition">
                            <p>{{ $statement->user->condition }}</p>
                        </div>
                    @endif

                </div>

            </div>
            <div class="full_statement_block_buttons">

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



                <script>
                    $(document).ready(function() {
                        var csrfToken = $('meta[name="csrf-token"]').attr('content');

                        $('.like-button, .unlike-button').click(function(e) {
                            e.preventDefault();
                            var statementId = $(this).data('id');
                            var $button = $(this);

                            var isLiked = $button.hasClass('unlike-button');

                            var requestType = isLiked ? 'DELETE' : 'POST';

                            var url = isLiked ? '/statement/' + statementId + '/unlike' : '/statement/' + statementId + '/like';

                            $.ajax({
                                type: requestType,
                                url: url,
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                success: function(response) {
                                    console.log(response);

                                    $button.toggleClass('like-button unlike-button');

                                    var svgIcon = isLiked ?
                                        '<svg class="like-icon" width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#777777"> <g id="SVGRepo_bgCarrier" stroke-width="0"></g> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g> <g id="SVGRepo_iconCarrier"> <path d="M12 19.7501C11.8012 19.7499 11.6105 19.6708 11.47 19.5301L4.70001 12.7401C3.78387 11.8054 3.27072 10.5488 3.27072 9.24006C3.27072 7.9313 3.78387 6.6747 4.70001 5.74006C5.6283 4.81186 6.88727 4.29042 8.20001 4.29042C9.51274 4.29042 10.7717 4.81186 11.7 5.74006L12 6.00006L12.28 5.72006C12.739 5.25606 13.2857 4.88801 13.8883 4.63736C14.4909 4.3867 15.1374 4.25845 15.79 4.26006C16.442 4.25714 17.088 4.38382 17.6906 4.63274C18.2931 4.88167 18.8402 5.24786 19.3 5.71006C20.2161 6.6447 20.7293 7.9013 20.7293 9.21006C20.7293 10.5188 20.2161 11.7754 19.3 12.7101L12.53 19.5001C12.463 19.5752 12.3815 19.636 12.2904 19.679C12.1994 19.7219 12.1006 19.7461 12 19.7501ZM8.21001 5.75006C7.75584 5.74675 7.30551 5.83342 6.885 6.00505C6.4645 6.17669 6.08215 6.42989 5.76001 6.75006C5.11088 7.40221 4.74646 8.28491 4.74646 9.20506C4.74646 10.1252 5.11088 11.0079 5.76001 11.6601L12 17.9401L18.23 11.6801C18.5526 11.3578 18.8086 10.9751 18.9832 10.5538C19.1578 10.1326 19.2477 9.68107 19.2477 9.22506C19.2477 8.76905 19.1578 8.31752 18.9832 7.89627C18.8086 7.47503 18.5526 7.09233 18.23 6.77006C17.9104 6.44929 17.5299 6.1956 17.1109 6.02387C16.6919 5.85215 16.2428 5.76586 15.79 5.77006C15.3358 5.76675 14.8855 5.85342 14.465 6.02505C14.0445 6.19669 13.6621 6.44989 13.34 6.77006L12.53 7.58006C12.3869 7.71581 12.1972 7.79149 12 7.79149C11.8028 7.79149 11.6131 7.71581 11.47 7.58006L10.66 6.77006C10.3395 6.44628 9.95791 6.18939 9.53733 6.01429C9.11675 5.83919 8.66558 5.74937 8.21001 5.75006Z" fill="#777777"></path> </g> </svg>' :
                                        '<svg class="unlike-icon" width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <g id="SVGRepo_bgCarrier" stroke-width="0"></g> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g> <g id="SVGRepo_iconCarrier"> <path d="M19.3 5.71002C18.841 5.24601 18.2943 4.87797 17.6917 4.62731C17.0891 4.37666 16.4426 4.2484 15.79 4.25002C15.1373 4.2484 14.4909 4.37666 13.8883 4.62731C13.2857 4.87797 12.739 5.24601 12.28 5.71002L12 6.00002L11.72 5.72001C10.7917 4.79182 9.53273 4.27037 8.22 4.27037C6.90726 4.27037 5.64829 4.79182 4.72 5.72001C3.80386 6.65466 3.29071 7.91125 3.29071 9.22002C3.29071 10.5288 3.80386 11.7854 4.72 12.72L11.49 19.51C11.6306 19.6505 11.8212 19.7294 12.02 19.7294C12.2187 19.7294 12.4094 19.6505 12.55 19.51L19.32 12.72C20.2365 11.7823 20.7479 10.5221 20.7442 9.21092C20.7405 7.89973 20.2218 6.64248 19.3 5.71002Z" fill="#777777"></path> </g> </svg>';
                                    $button.html(svgIcon);

                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            });
                        });
                    });
                </script>


                            @livewire('repost-statement-component', ['statementId' => $statement->id])




                            @include('news.modal.report')






                <?php
                $friendsList = \App\Models\Friendship::where(function ($query) {
                    $query->where('sender_id', auth()->id())->where('status', 'accepted');
                })
                    ->orWhere(function ($query) {
                        $query->where('recipient_id', auth()->id())->where('status', 'accepted');
                    })
                    ->get();
                
                $friendIds = $friendsList->pluck('sender_id')->merge($friendsList->pluck('recipient_id'))->unique();
                
                $friends = \App\Models\User::whereIn('id', $friendIds)->get();
                ?>


                <div id="friendsList{{ $statement->id }}" style="display: none;">
                    <div class="friendsList_repost">
                        @foreach ($friends as $friend)
                            @if ($friend->id !== auth()->id())
                                <a
                                    href="{{ route('sendPostToFriend', ['postId' => $statement->id, 'friendId' => $friend->id]) }}">
                                    {{ $friend->name }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>


                <script>
                    function toggleFriendsList(postId) {
                        const friendsList = document.getElementById(`friendsList${postId}`);
                        friendsList.style.display = friendsList.style.display === 'none' ? 'block' : 'none';
                    }
                </script>
            </div>

        </div>


        <div class="full_statement_content">


            <div class="full_statement_content_statement">
                <div class="full_statement_content_statement_scroll">

                    <div class="full_statement_content_statement_top">
                        <div>
                            <div class="full_statement_content_statement_top_title">

                                <p>{{ $statement->title }}</p>

                            </div>

                            <div class="full_statement_content_statement_top_created">

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
                                        $formattedTime =
                                            $days . ' ' . pluralForm($days, 'день', 'дня', 'дней') . ' назад';
                                    } elseif ($timeDiff >= 3600) {
                                        $hours = floor($timeDiff / 3600);
                                        $formattedTime =
                                            $hours . ' ' . pluralForm($hours, 'час', 'часа', 'часов') . ' назад';
                                    } elseif ($timeDiff >= 60) {
                                        $minutes = floor($timeDiff / 60);
                                        $formattedTime =
                                            $minutes .
                                            ' ' .
                                            pluralForm($minutes, 'минута', 'минуты', 'минут') .
                                            ' назад';
                                    } else {
                                        $formattedTime = 'только что';
                                    }
                                @endphp

                             <p>{{ $statement->views_count }} Просмотров</p>   <p>{{ $formattedTime }}</p>

                            </div>
                        </div>
                        <div class="full_statement_content_statement_top_category">

                            <div class="full_statement_category">{{ isset($statement->category)? $statement->category->name : 'без категории' }}</div>

                        </div>

                    </div>
                    <div class="full_statement_content_statement_middle">

                        <div class="full_statement_content_statement_middle_img">
                            <img src="{{ asset('storage/' . $statement->photo_path) }}"
                                style="object-fit: contain; border-radius:12px;">
                        </div>


                    </div>

                    <div class="full_statement_content_statement_down">

                        <div class="full_statement_content_statement_down_description">

                            <p>{{ $statement->description }}</p>

                        </div>
                    </div>

                </div>
            </div>
            <div class="full_statement_content_commentsblock">

                <div class="full_statement_content_comments">
                    @foreach ($statement->comments as $comment)
                        <div class="full_statement_comment">

                            <div class="main_novost_top">
                                <a
                                    href="{{ route('profile.profileuser', ['id' => $comment->user_id]) }}">
                                    <div class="main_novost_img">

                                    @if ($comment->user->avatar !== null)
                        <a href="{{ route('profile.profileuser', ['id' => $comment->user_id]) }}">
                            <img class="avatar_mini" src="{{ asset('storage/' . $comment->user->avatar) }}"
                                alt="Avatar">
                        </a>
                    @else
                        <a href="{{ route('profile.profileuser', ['id' => $comment->user_id]) }}">
                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                        </a>
                    @endif

                                    </div>
                                </a>


                                <div class="main_novost_title">
                                    <div>
                                        <a
                                            href="{{ route('profile.profileuser', ['id' => $comment->user_id, 'previous' => 'news']) }}">
                                            <p class="txt_2">{{ $comment->user->name }}</p>
                                        </a>
                                    </div>
                                    <div>
                                        <p class="txt_2">{{ $comment->created_at }}</p>
                                    </div>
                                </div>

                            </div>

                            <div class="main_comment_show">
                                <p class="txt_2">{{ $comment->content }}</p>
                            </div>



                            @if (auth()->user()->role == 'Admin')
                                <form method="POST"
                                    action="{{ route('admin.statement.comment.delete', ['statementId' => $statement->id, 'commentId' => $comment->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="novost_down_func" type="submit">Удалить комментарий</button>
                                </form>
                            @endif



                        </div>
                    @endforeach
                </div>

                <form method="POST" class="full_statement_content_comments_form"
                    action="{{ route('statement.comment', ['id' => $statement->id]) }}">


                    @csrf

                    <input class="full_statement_content_comments_field" placeholder="Введите комментарий..."
                        name="comment">




                    <button class="mini_button" style="padding: 0%">
                        @include('general.elements.svg-send')

                    </button>





                </form>

            </div>

        </div>




    </div>



</x-app-layout>
