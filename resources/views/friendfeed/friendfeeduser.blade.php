<x-app-layout>
    <x-slot name="header">

    </x-slot>



    <div class="friendfeed_field">
        <div class="friendfeed_field_frame">




            @foreach ($feedItems as $index => $feedItem)
                @if ($feedItem->user_id !== auth()->id())
                    <div class="friendfeed_block">
                        <div class="friendfeed_content">

                            <div class="statement_block_top_open">

                                <div class="statement_block_top_info_left_open">

                                    <div class="statement_block_top_avatar_open">


                                        @if ($feedItem->user->avatar !== null)
                                            <img class="avatar_mini"
                                                src="{{ asset('storage/' . $feedItem->user->avatar) }}" alt="Avatar">
                                        @else
                                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                        @endif

                                    </div>

                                    <div class="statement_block_top_info_open">


                                        <div class="statement_block_top_info_name_open">
                                            <p>{{ $feedItem->user->name }}</p>
                                        </div>

                                        <div class="statement_block_top_info_createdat_open">
                                            {{ $feedItem->created_at }}
                                        </div>

                                    </div>

                                </div>


                                <div class="statement_block_top_info_right_open">

                                    <div class="full_statement_btn" type="submit">
                                        <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" stroke="#777777">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M12 19.7501C11.8012 19.7499 11.6105 19.6708 11.47 19.5301L4.70001 12.7401C3.78387 11.8054 3.27072 10.5488 3.27072 9.24006C3.27072 7.9313 3.78387 6.6747 4.70001 5.74006C5.6283 4.81186 6.88727 4.29042 8.20001 4.29042C9.51274 4.29042 10.7717 4.81186 11.7 5.74006L12 6.00006L12.28 5.72006C12.739 5.25606 13.2857 4.88801 13.8883 4.63736C14.4909 4.3867 15.1374 4.25845 15.79 4.26006C16.442 4.25714 17.088 4.38382 17.6906 4.63274C18.2931 4.88167 18.8402 5.24786 19.3 5.71006C20.2161 6.6447 20.7293 7.9013 20.7293 9.21006C20.7293 10.5188 20.2161 11.7754 19.3 12.7101L12.53 19.5001C12.463 19.5752 12.3815 19.636 12.2904 19.679C12.1994 19.7219 12.1006 19.7461 12 19.7501ZM8.21001 5.75006C7.75584 5.74675 7.30551 5.83342 6.885 6.00505C6.4645 6.17669 6.08215 6.42989 5.76001 6.75006C5.11088 7.40221 4.74646 8.28491 4.74646 9.20506C4.74646 10.1252 5.11088 11.0079 5.76001 11.6601L12 17.9401L18.23 11.6801C18.5526 11.3578 18.8086 10.9751 18.9832 10.5538C19.1578 10.1326 19.2477 9.68107 19.2477 9.22506C19.2477 8.76905 19.1578 8.31752 18.9832 7.89627C18.8086 7.47503 18.5526 7.09233 18.23 6.77006C17.9104 6.44929 17.5299 6.1956 17.1109 6.02387C16.6919 5.85215 16.2428 5.76586 15.79 5.77006C15.3358 5.76675 14.8855 5.85342 14.465 6.02505C14.0445 6.19669 13.6621 6.44989 13.34 6.77006L12.53 7.58006C12.3869 7.71581 12.1972 7.79149 12 7.79149C11.8028 7.79149 11.6131 7.71581 11.47 7.58006L10.66 6.77006C10.3395 6.44628 9.95791 6.18939 9.53733 6.01429C9.11675 5.83919 8.66558 5.74937 8.21001 5.75006Z"
                                                    fill="#777777"></path>
                                            </g>
                                        </svg>
                                    </div>



                                    <button class="full_statement_btn" type="submit">

                                        <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M19.3 5.71002C18.841 5.24601 18.2943 4.87797 17.6917 4.62731C17.0891 4.37666 16.4426 4.2484 15.79 4.25002C15.1373 4.2484 14.4909 4.37666 13.8883 4.62731C13.2857 4.87797 12.739 5.24601 12.28 5.71002L12 6.00002L11.72 5.72001C10.7917 4.79182 9.53273 4.27037 8.22 4.27037C6.90726 4.27037 5.64829 4.79182 4.72 5.72001C3.80386 6.65466 3.29071 7.91125 3.29071 9.22002C3.29071 10.5288 3.80386 11.7854 4.72 12.72L11.49 19.51C11.6306 19.6505 11.8212 19.7294 12.02 19.7294C12.2187 19.7294 12.4094 19.6505 12.55 19.51L19.32 12.72C20.2365 11.7823 20.7479 10.5221 20.7442 9.21092C20.7405 7.89973 20.2218 6.64248 19.3 5.71002Z"
                                                    fill="#777777"></path>
                                            </g>
                                        </svg>

                                    </button>

                                    <button id="comments_open_{{ $index }}" class="full_statement_btn">

                                        <svg width="100%" height="100%" viewBox="-0.96 -0.96 33.92 33.92"
                                            version="1.1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#777777"
                                            stroke="#777777">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <title>comment-2</title>
                                                <desc>Created with Sketch Beta.</desc>
                                                <defs> </defs>
                                                <g id="Page-1" stroke-width="0.8" fill="none" fill-rule="evenodd"
                                                    sketch:type="MSPage">
                                                    <g id="Icon-Set" sketch:type="MSLayerGroup"
                                                        transform="translate(-152.000000, -255.000000)" fill="#777777">
                                                        <path
                                                            d="M168,281 C166.832,281 165.704,280.864 164.62,280.633 L159.912,283.463 L159.975,278.824 C156.366,276.654 154,273.066 154,269 C154,262.373 160.268,257 168,257 C175.732,257 182,262.373 182,269 C182,275.628 175.732,281 168,281 L168,281 Z M168,255 C159.164,255 152,261.269 152,269 C152,273.419 154.345,277.354 158,279.919 L158,287 L165.009,282.747 C165.979,282.907 166.977,283 168,283 C176.836,283 184,276.732 184,269 C184,261.269 176.836,255 168,255 L168,255 Z M175,266 L161,266 C160.448,266 160,266.448 160,267 C160,267.553 160.448,268 161,268 L175,268 C175.552,268 176,267.553 176,267 C176,266.448 175.552,266 175,266 L175,266 Z M173,272 L163,272 C162.448,272 162,272.447 162,273 C162,273.553 162.448,274 163,274 L173,274 C173.552,274 174,273.553 174,273 C174,272.447 173.552,272 173,272 L173,272 Z"
                                                            id="comment-2" sketch:type="MSShapeGroup"> </path>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>

                                    </button>

                                    <button class="full_statement_btn">

                                        <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" stroke="#777777"
                                            stroke-width="1.9200000000000004">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M12.0678 2.14611C12.3883 2.00663 12.7431 1.96564 13.0874 2.02906C13.4316 2.09244 13.7478 2.25698 13.9973 2.49935L22.459 10.7164C22.6312 10.8837 22.7672 11.0838 22.8599 11.3041C22.9525 11.5244 23 11.7609 23 11.9994C23 12.238 22.9525 12.4744 22.8599 12.6947C22.7672 12.9151 22.6309 13.1154 22.4587 13.2827L13.9972 21.4997C13.7476 21.742 13.4316 21.9064 13.0874 21.9698C12.7431 22.0332 12.3883 21.9922 12.0678 21.8528C11.7474 21.7134 11.4771 21.4826 11.2883 21.1916C11.0997 20.9008 11.0001 20.5617 11 20.2164L11 17.0208C8.70545 17.1206 7.26436 17.5717 6.17555 18.2297C4.90572 18.9971 4.01283 20.0973 2.77837 21.6278C2.5122 21.9578 2.06688 22.0841 1.66711 21.943C1.26733 21.8018 1 21.424 1 21C1 17.4414 1.5013 13.9586 3.15451 11.341C4.72577 8.85318 7.25861 7.26795 11 7.03095L11 3.78241C11.0001 3.43711 11.0997 3.09808 11.2883 2.80727C11.4771 2.51629 11.7474 2.2855 12.0678 2.14611Z"
                                                    fill=""></path>
                                            </g>
                                        </svg>

                                    </button>


                                    <button class="full_statement_btn"> <svg width="100%" height="100%"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                            stroke="#777777">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M5 21V3.90002C5 3.90002 5.875 3 8.5 3C11.125 3 12.875 4.8 15.5 4.8C18.125 4.8 19 3.9 19 3.9V14.7C19 14.7 18.125 15.6 15.5 15.6C12.875 15.6 11.125 13.8 8.5 13.8C5.875 13.8 5 14.7 5 14.7"
                                                    stroke="#777777" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                </path>
                                            </g>
                                        </svg></button>


                                </div>




                            </div>
                            <div class="statement_block_middle_open_img_lock">
                                <div class="statement_block_middle_open">


                                    @if ($feedItem instanceof \App\Models\Video)

                                        <img src="{{ asset('storage/' . $feedItem->thumbnail_path) }}"
                                            alt="Thumbnail">

                                    @elseif ($feedItem instanceof \App\Models\Statement)

                                        <img src="{{ asset('storage/' . $feedItem->photo_path) }}" alt="Photo">

                                    @endif

                                </div>

                            </div>
                            <div class="statement_block_down_open">

                                <div class="statement_block_down_title_open">
                                    <p>{{ $feedItem->title }}</p>
                                </div>
                                <div class="statement_block_down_views_open">
                                    <p>663 Просмотров</p>
                                </div>

                                <div class="statement_block_down_description_open">
                                    <p>{{ $feedItem->description }}</p>
                                </div>

                            </div>





                        </div>

                        <div class="friendfeed_comments">

                            <div class="friendfeed_comments_scroll">

                                @foreach ($feedItem->comments as $comment)
                                    <div class="friendfeed_comments_block">

                                        <div class="main_novost_top">
                                            <a href="">
                                                <div class="main_novost_img">

                                                    @if ($comment->user->avatar !== null)
                                                        <img class="avatar_mini"
                                                            src="{{ asset('storage/' . $comment->user->avatar) }}"
                                                            alt="Avatar">
                                                    @else
                                                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png"
                                                            alt="Avatar">
                                                    @endif

                                                </div>
                                            </a>


                                            <div class="main_novost_title">
                                                <div>
                                                    <a href="">
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




                                    </div>
                                @endforeach

                                @if ($feedItem->comments->isEmpty())
                                    <p>Комментариев нет...</p>
                                @endif

                            </div>


                            @if ($feedItem instanceof \App\Models\Video)

                            <form id="commentForm" method="POST" action="{{ route('friendfeed.video.comment', ['id' => $feedItem->id] ) }}">
                                <div class="friendfeed_comment_input">

                                    @csrf

                                    <div class="main_novost_img">

                                        <a href="{{ route('profileuser') }}">

                                            @if (Auth::user()->avatar !== null)
                                                <img class="avatar_mini"
                                                    src="{{ asset('storage/' . Auth::user()->avatar) }}"alt="Avatar">
                                            @else
                                                <img class="avatar_mini" src="/uploads/ProfilePhoto.png"
                                                    width="50px" height="50px">
                                            @endif

                                        </a>

                                    </div>

                                    <textarea class="form_field_comment" name="comment"></textarea>

                                    <div class="submit_comment">
                                        <button class="txt_2">
                                            Отправить
                                        </button>


                                    </div>

                                </div>
                            </form>

                        @elseif ($feedItem instanceof \App\Models\Statement)

                        <form id="commentForm" method="POST" action="{{ route('friendfeed.statement.comment', ['id' => $feedItem->id] ) }}">
                            <div class="friendfeed_comment_input">

                                @csrf

                                <div class="main_novost_img">

                                    <a href="{{ route('profileuser') }}">

                                        @if (Auth::user()->avatar !== null)
                                            <img class="avatar_mini"
                                                src="{{ asset('storage/' . Auth::user()->avatar) }}"alt="Avatar">
                                        @else
                                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png"
                                                width="50px" height="50px">
                                        @endif

                                    </a>

                                </div>

                                <textarea class="form_field_comment" name="comment"></textarea>

                                <div class="submit_comment">
                                    <button class="txt_2">
                                        Отправить
                                    </button>


                                </div>

                            </div>
                        </form>
                            
                        @endif






                        </div>



                    </div>
                @endif
            @endforeach





        </div>


    </div>





    <script>
        document.addEventListener("DOMContentLoaded", function() {


            var buttons = document.querySelectorAll('[id^="comments_open"]');
            buttons.forEach(function(button) {
                button.addEventListener("click", function() {
                    var comments = button.closest('.friendfeed_block').querySelector(
                        '.friendfeed_comments');
                    var comments_scroll = button.closest('.friendfeed_block').querySelector(
                        '.friendfeed_comments_scroll');
                    comments.classList.toggle('open');
                    comments_scroll.classList.toggle('open');
                });
            });
        });
    </script>




</x-app-layout>
