<x-app-layout>
    <x-slot name="header">

    </x-slot>

    
    <div class="statement_field_open">

        <div class="statement_block_open">

            <div class="statement_block_top_open">

                <div class="statement_block_top_info_left_open">

                    <div class="statement_block_top_avatar_open">

                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png"alt="Avatar">

                    </div>

                    <div class="statement_block_top_info_open">


                        <div class="statement_block_top_info_name_open"></div>

                        <div class="statement_block_top_info_createdat_open"></div>

                    </div>

                </div>


                <div class="statement_block_top_info_right_open">

                    <div class="statement_block_like_button">
                    </div>
                    <div class="statement_block_unlike_button">
                    </div>
                    <button>Repost</button>
                    <button>Report</button>

                </div>




            </div>
            <div class="statement_block_middle_open">

                <img src="" alt="">

            </div>
            <div class="statement_block_down_open">

                <div class="statement_block_down_title_open"></div>
                <div class="statement_block_down_description_open"></div>

            </div>

            <div class="statement_block_comments_open">
                <form id="commentForm" method="POST" action="">
                <div class="statementuser_comment">

                    @csrf

                    <div class="main_novost_img">

                        <img class="avatar_mini" src="/uploads/ProfilePhoto.png"alt="Avatar">

                    </div>

                    <textarea class="form_field_comment" name="comment"></textarea>

                    <div class="submit_comment">
                        <button class="txt_2">
                            Отправить
                        </button>


                    </div>

                </div>
                </form>

                <div class="statementuser_comment_show">



                    <div class="main_novost_top">
                        <a href="">
                            <div class="main_novost_img">

                                <img class="avatar" src="" alt="Avatar">

                            </div>
                        </a>


                        <div class="main_novost_title">
                            <div>
                                <a href="">
                                    <p class="txt_2">username</p>
                                </a>
                            </div>
                            <div>
                                <p class="txt_2">created_at</p>
                            </div>
                        </div>

                    </div>

                    <div class="main_comment_show">
                        <p class="txt_2">content</p>
                    </div>




                </div>


            </div>

        </div>

        <div class="statement_block_close">
            <button class="statement_block_btn_close">X</button>
        </div>

    </div>




    <div class="statements_field">

        <div class="statements_settings">

            <form class="statements_settings_left" id="categoryForm" method="GET" action="{{ url()->current() }}">
                @csrf
                <button value="Игры" class="statements_categories_btn">Тренд</button>
                <button value="Экономика" class="statements_categories_btn">Недавние</button>
                <button value="Транспорт" class="statements_categories_btn">Популярные</button>
            </form>

            <form class="statements_settings_right" id="categoryForm" method="GET" action="{{ url()->current() }}">
                @csrf

                <button value="" class="statements_categories_btn">Все категории</button>
                <button value="Спорт" class="statements_categories_btn">Спорт</button>
                <button value="Игры" class="statements_categories_btn">Игры</button>
                <button value="Экономика" class="statements_categories_btn">Экономика</button>
                <button value="Транспорт" class="statements_categories_btn">Транспорт</button>

            </form>





        </div>

        <div class="statements_scroll_lock">

            @forelse ($statements as $statement)
                @if ($statement->status == 'true')
                    <div class="statement_block" id="statement_{{ $statement->id }}">

                        <div class="statement_block_top">
                            <div class="statement_block_top_info_left">
                                <div class="statement_block_top_avatar">

                                    @if ($statement->user->avatar !== null)
                                        <a href="{{ route('profileuser.profile', ['id' => $statement->user_id]) }}">
                                            <img class="avatar" src="{{ asset('storage/' . $statement->user->avatar) }}"
                                                alt="Avatar">
                                        </a>
                                    @else
                                        <a href="{{ route('profileuser.profile', ['id' => $statement->user_id]) }}">
                                            <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                                        </a>
                                    @endif

                                </div>

                                <div class="statement_block_top_info">

                                    <div class="statement_block_top_info_name">{{ $statement->user->name }} </div>

                                    <div class="statement_block_top_info_createdat">{{ $statement->created_at }}</div>

                                </div>

                            </div>

                            <div class="statement_block_top_info_right">

                                <div class="statement_block_top_info_right_like">
                                    @if (!$statement->likes()->where('user_id', auth()->id())->exists())
                                        <div>♡</div>

                                        <div>{{ $statement->likes_count }}</div>
                                    @else
                                        <div>❤</div>

                                        <div>{{ $statement->likes_count }}</div>
                                    @endif
                                </div>

                                <div class="statement_block_top_info_right_comments">

                                    <span>{{ $statement->comments_count }}</span>

                                </div>

                            </div>

                        </div>

                        <div class="statement_block_middle">

                            <img src="{{ asset('storage/' . $statement->photo_path) }}" alt="Photo">

                        </div>

                        <div class="statement_block_down">

                            <div class="statement_block_down_title">{{ $statement->title }}</div>
                            <div class="statement_block_down_description">{{ $statement->description }}</div>

                        </div>

                    </div>
                @endif

            @empty
                <p class= "txt_1">Новостей нет</p>

            @endforelse

        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const statementBlocks = document.querySelectorAll(".statement_block");
            const statementFieldOpen = document.querySelector(".statement_field_open");
            const closeButton = document.querySelector(".statement_block_btn_close");
    
            function closeModal() {
                statementFieldOpen.classList.remove("opened");
            }
    
            statementBlocks.forEach(function (block) {
                block.addEventListener("click", function () {
                    const statementId = block.getAttribute("id").split("_")[1];
    
                    fetch(`/statement/${statementId}/details`)
                        .then(response => response.json())
                        .then(data => {
                            const statementData = data.statement;
                            const userData = data.user;
                            const likeButtonHtml = data.like_button_html;
                            const likeUrl = data.like_url;
                            const unlikeUrl = data.unlike_url;
                            const comments = data.comments;
                            const createcomment = data.createcomment;
    
                            const commentForm = document.getElementById('commentForm');
                            commentForm.action = createcomment;
    
                            statementFieldOpen.querySelector(".statement_block_top_info_name_open").textContent = statementData.user.name;
                            statementFieldOpen.querySelector(".statement_block_top_info_createdat_open").textContent = statementData.created_at;
                            statementFieldOpen.querySelector(".statement_block_middle_open img").src = data.photo_url;
                            statementFieldOpen.querySelector(".statement_block_down_title_open").textContent = statementData.title;
                            statementFieldOpen.querySelector(".statement_block_down_description_open").textContent = statementData.description;
    
                            const likeButtonContainer = statementFieldOpen.querySelector(".statement_block_like_button");
                            likeButtonContainer.innerHTML = likeButtonHtml;
    
                            const likeButton = likeButtonContainer.querySelector("button");
                            likeButton.addEventListener("click", function (event) {
                                event.preventDefault();
                                const likeAction = likeButton.innerText === '♡' ? 'like' : 'unlike';
                                const url = likeAction === 'like' ? likeUrl : unlikeUrl;
    
                                fetch(url, {
                                    method: likeAction === 'like' ? 'POST' : 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    },
                                    body: JSON.stringify({})
                                })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Network response was not ok');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {})
                                    .catch(error => {
                                        console.error('There has been a problem with your fetch operation:', error);
                                    });
                            });
    
                            const commentsContainer = document.querySelector(".statementuser_comment_show");
                            commentsContainer.innerHTML = "";
    
                            comments.forEach(comment => {
                            const commentElement = document.createElement("div");
                            commentElement.classList.add("statement_comment");

                            const mainNovostTop = document.createElement("div");
                            mainNovostTop.classList.add("main_novost_top");

                            const userLink = document.createElement("a");
                            userLink.href = ""; // ссылка на профиль пользователя
                            const mainNovostImg = document.createElement("div");
                            mainNovostImg.classList.add("main_novost_img");
                            const avatarImg = document.createElement("img");
                            avatarImg.classList.add("avatar");
                            avatarImg.src = ""; // URL аватара пользователя
                            avatarImg.alt = "Avatar";
                            mainNovostImg.appendChild(avatarImg);
                            userLink.appendChild(mainNovostImg);
                            mainNovostTop.appendChild(userLink);

                            const mainNovostTitle = document.createElement("div");
                            mainNovostTitle.classList.add("main_novost_title");

                            const usernameLink = document.createElement("a");
                            usernameLink.href = ""; // ссылка на профиль пользователя
                            const usernameParagraph = document.createElement("p");
                            usernameParagraph.classList.add("txt_2");
                            usernameParagraph.textContent = comment.user.name;
                            usernameLink.appendChild(usernameParagraph);
                            mainNovostTitle.appendChild(usernameLink);

                            const createdAtParagraph = document.createElement("p");
                            createdAtParagraph.classList.add("txt_2");
                            createdAtParagraph.textContent = comment.created_at;
                            mainNovostTitle.appendChild(createdAtParagraph);

                            mainNovostTop.appendChild(mainNovostTitle);
                            commentElement.appendChild(mainNovostTop);

                            const mainCommentShow = document.createElement("div");
                            mainCommentShow.classList.add("main_comment_show");

                            const contentParagraph = document.createElement("p");
                            contentParagraph.classList.add("txt_2");
                            contentParagraph.textContent = comment.content;
                            mainCommentShow.appendChild(contentParagraph);

                            commentElement.appendChild(mainCommentShow);

                            commentsContainer.appendChild(commentElement);
                            });
    
                            statementFieldOpen.classList.add("opened");
                        })
                        .catch(error => console.error('Ошибка при загрузке данных о заявлении:', error));
                });
            });
    
            closeButton.addEventListener("click", closeModal);
    
            statementFieldOpen.addEventListener("click", function (event) {
                if (event.target === statementFieldOpen) {
                    closeModal();
                }
            });
    
            document.addEventListener("keydown", function (event) {
                if (event.key === "Escape" && statementFieldOpen.classList.contains("opened")) {
                    closeModal();
                }
            });
        });
    </script>
    



    <script>
        document.addEventListener('DOMContentLoaded', function () {
    
            var categoryButtons = document.querySelectorAll('.statements_categories_btn');
    
            var selectedCategory = localStorage.getItem('selectedCategory');
    
            var currentUrl = window.location.href;
    
            if (!currentUrl.includes('category')) {
                selectedCategory = null;
                localStorage.removeItem('selectedCategory');
            }
    
            if (selectedCategory) {
                categoryButtons.forEach(function(button) {
                    if (button.value === selectedCategory) {
                        button.classList.add('select');
                    }
                });
            }
    
            categoryButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
    
                    categoryButtons.forEach(function(btn) {
                        btn.classList.remove('select');
                    });
    
                    button.classList.add('select');
    
                    var category = button.value;
    
                    localStorage.setItem('selectedCategory', category);
    
                    var hiddenField = document.createElement('input');
                    hiddenField.type = 'hidden';
                    hiddenField.name = 'category';
                    hiddenField.value = category;
    
                    var form = document.getElementById('categoryForm');
                    form.appendChild(hiddenField);
    
                    form.submit();
                });
            });
        });
    </script>


</x-app-layout>


{{-- РЕПОСТ
<div class="main_novost_down">

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

    <div class="novost_down_func1">
        <button onclick="toggleFriendsList({{ $statement->id }})"
            class="novost_down_func_news">📢</button>

    </div>
    <div id="friendsList{{ $statement->id }}" style="display: none;">
        <div class="friendsList_repost">
            @foreach ($friends as $friend)
                @if ($friend->id !== auth()->id())
                    <a class="txt_2"
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

--}}
