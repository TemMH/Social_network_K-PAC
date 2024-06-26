<x-app-layout>
    <x-slot name="header">

    </x-slot>




    <div class="statements_field">

        <div class="statements_settings">
            @if (Route::is('all.statement.user.trend', 'all.statement.user.popular', 'all.statement.user.newforuser', 'all.statement.user.new', 'all.statement.user.viewed'))
            <div class="statements_settings_left">
                <button onclick="location.href='{{ route('all.statement.user.trend') }}';" class="long_button {{ Route::is('all.statement.user.trend') ? 'selected' : ''}}">В тренде</button>
                <button onclick="location.href='{{ route('all.statement.user.popular') }}';" class="long_button {{ Route::is('all.statement.user.popular') ? 'selected' : ''}}">Популярно</button>
                <button onclick="location.href='{{ route('all.statement.user.newforuser') }}';" class="long_button {{ Route::is('all.statement.user.newforuser') ? 'selected' : ''}}">Новое для вас</button>
                <button onclick="location.href='{{ route('all.statement.user.new') }}';" class="long_button {{ Route::is('all.statement.user.new') ? 'selected' : ''}}">Недавно опубликованные</button>
                <button onclick="location.href='{{ route('all.statement.user.viewed') }}';" class="long_button {{ Route::is('all.statement.user.viewed') ? 'selected' : ''}}">Просмотрено</button>
            </div>
            @endif

            @if (Route::is('profile.profileuserstatements.trend', 'profile.profileuserstatements.popular', 'profile.profileuserstatements.newforuser', 'profile.profileuserstatements.viewed', 'profile.profileuserstatements.new'))
            <div class="statements_settings_left">
                <button onclick="location.href='{{ route('profile.profileuserstatements.trend', ['id' => $user->id]) }}';" class="long_button {{ Route::is('profile.profileuserstatements.trend') ? 'selected' : ''}}">В тренде</button>
                <button onclick="location.href='{{ route('profile.profileuserstatements.popular', ['id' => $user->id]) }}';" class="long_button {{ Route::is('profile.profileuserstatements.popular') ? 'selected' : ''}}">Популярно</button>
                <button onclick="location.href='{{ route('profile.profileuserstatements.newforuser', ['id' => $user->id]) }}';" class="long_button {{ Route::is('profile.profileuserstatements.newforuser') ? 'selected' : ''}}">Новое для вас</button>
                <button onclick="location.href='{{ route('profile.profileuserstatements.new', ['id' => $user->id]) }}';" class="long_button {{ Route::is('profile.profileuserstatements.new') ? 'selected' : ''}}">Недавно опубликованные</button>
                <button onclick="location.href='{{ route('profile.profileuserstatements.viewed', ['id' => $user->id]) }}';" class="long_button {{ Route::is('profile.profileuserstatements.viewed') ? 'selected' : ''}}">Просмотрено</button>
            </div>
            @endif


            @if (Route::is('profile.profileuserstatements.trend', 'profile.profileuserstatements.popular', 'profile.profileuserstatements.newforuser', 'profile.profileuserstatements.viewed', 'profile.profileuserstatements.new'))
            <div class="statements_settings_middle">
                <p>Фотоматериалы  
                    
                    <a href="{{ route('profile.profileuser', ['id' => $user->id]) }}">
                    {{ $user->name }}
                    </a>
                
                </p>
            </div>
            @endif


@include('general.partials.dropdown-category')





        </div>
        <div class="invisible-line" style="width: 100%;"></div>

        <div class="statements_scroll_lock">

            @forelse ($statements as $statement)
               
                    @include('news.modal.statement')
         

            @empty
            <p style="columns: 1;" class= "txt_1">Выㅤпосмотрелиㅤвсеㅤфотоматериалыㅤвㅤэтомㅤразделе,ㅤзаходитеㅤпозже</p>

            @endforelse

        </div>

    </div>
    


    <script>
        $(document).ready(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
        
            $(document).on('click', '.like-button, .unlike-button', function(e) {
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






    <script>
        document.addEventListener('DOMContentLoaded', function() {

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
<script>
$(document).ready(function() {
    $('.comment-form').submit(function(e) {
        e.preventDefault();
        var statementId = $(this).data('statement-id');
        var formData = $(this).serialize();
        var form = $(this);
        $.ajax({
            url: form.attr('action'), 
            type: 'POST',
            data: formData,
            success: function(response) {
                let deleteForm = '';
                if (response.user_role === 'Admin' || response.user_role === 'Manager') {
                    deleteForm = `
                        <form method="POST" action="/statement/${response.statement_id}/comment/${response.comment_id}">
                            @csrf
                            @method('DELETE')
                            <button class="novost_down_func" type="submit">Удалить комментарий</button>
                        </form>
                    `;
                }
                var commentsContainer = form.closest('.statement_block_comments_open').find('.statementuser_comment_show');
                commentsContainer.append(`
                    <div class="main_novost_top">
                        <a href="/profileuser/${response.user_id}">
                            <div class="main_novost_img">
                                <img class="avatar_mini" src="${response.user_avatar}" alt="Avatar">
                            </div>
                            <div class="main_novost_title">
                                <div>
                                    <a href="/profileuser/${response.user_id}">
                                        <p class="txt_2">${response.user_name}</p>
                                    </a>
                                </div>
                                <div>
                                    <p class="txt_2">${response.created_at}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="main_comment_show">
                        <p class="txt_2">${response.comment}</p>
                    </div>
                    ${deleteForm}
                `);
                form.find('input[name="comment"]').val('');
            },
            error: function(response) {
                alert('Ошибка при отправке комментария.');
            }
        });
    });
});

    
    </script>

<script>

document.addEventListener("DOMContentLoaded", function() {
    const statementBlocks = document.querySelectorAll(".statement_block");
    const invisibleLine = document.querySelector(".invisible-line");

    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.5
    };

    function handleIntersection(entries, observer) {
        entries.forEach(entry => {
            const statementBlock = entry.target;
            const statementId = statementBlock.getAttribute('data-statementid');
            if (entry.isIntersecting) {
                updateStatementViews(statementId);
            }
        });
    }

    const observer = new IntersectionObserver(handleIntersection, options);

    statementBlocks.forEach(statementBlock => {
        observer.observe(statementBlock);
    });

    observer.observe(invisibleLine);
    function updateStatementViews(statementId) {
        fetch(`/view/statement/${statementId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('There was a problem with your fetch operation:', error);
        });
    }
});



</script>



</x-app-layout>
