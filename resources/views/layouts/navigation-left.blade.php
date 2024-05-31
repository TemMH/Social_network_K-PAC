<header class="header">





    <div class="header_top">


        <div class="logotype">
@auth




    @if (in_array(auth()->user()->role, ['Admin', 'Manager']))

            <a href="{{ route('reports') }}">
@include('general.elements.header.svg-logotype')

            </a>

            @else

            <a href="{{ ('/') }}">
                @include('general.elements.header.svg-logotype')


            </a>

            @endif




            @else

            <a href="{{ ('/') }}">
                @include('general.elements.header.svg-logotype')


            </a>




@endauth
        </div>

    </div>




    <div class="header_middle">
        @auth

   
        <div>
            <button title="Видеокаталог" onclick="location.href='{{ route('main.all.video.user') }}';">@include('general.elements.header.svg-allvideo')</button>
        </div>  
        <div>    
            <button title="Клипы" onclick="location.href='{{ route('allshortsvideouser') }}';">@include('general.elements.header.svg-allshortsvideo')</button>
        </div>  
            <div>
            <button title="Фотокаталог" onclick="location.href='{{ route('all.statement.user.trend') }}';">@include('general.elements.header.svg-allstatements')</button>
        </div>  
            <div>
            <button title="Мессенджер" onclick="location.href='{{ route('messenger') }}';">@include('general.elements.header.svg-messenger')</button>
        </div>  
        <div>
            <button title="Лента друзей" onclick="location.href='{{ route('friendfeeduser') }}';">@include('general.elements.header.svg-friendnews')</button>
        </div>  


        @endauth
    </div>


    <script>
        function toggleSearch() {
            const searchBlock = document.getElementById('searchBlock');
            const notificationBlock = document.getElementById('notificationBlock');


            if (notificationBlock.classList.contains('show') && window.innerWidth <= window.screen.width * 0.9) {
                toggleNotification();
            }


            if (searchBlock.classList.contains('show')) {
                searchBlock.classList.remove('show');
            } else {

                if (!notificationBlock.classList.contains('show') || window.innerWidth > window.screen.width * 0.9) {
                    searchBlock.classList.add('show');
                }
            }
        }

        function toggleNotification() {
            const notificationBlock = document.getElementById('notificationBlock');
            const searchBlock = document.getElementById('searchBlock');


            if (searchBlock.classList.contains('show') && window.innerWidth <= window.screen.width * 0.9) {
                toggleSearch();
            }


            if (notificationBlock.classList.contains('show')) {
                notificationBlock.classList.remove('show');
            } else {
                if (!searchBlock.classList.contains('show') || window.innerWidth > window.screen.width * 0.9) {
                    notificationBlock.classList.add('show');
                }
            }
        }

        window.addEventListener('resize', function() {
            const searchBlock = document.getElementById('searchBlock');
            const notificationBlock = document.getElementById('notificationBlock');

            searchBlock.classList.remove('show');
            notificationBlock.classList.remove('show');
        });
    </script>









    <div class="header_down1">
        @auth
        <div class="adminpanel">

            <button type="button" onclick="toggleSearch()">
            @include('general.elements.header.svg-search')
            </button>

        </div>
        @endauth
    </div>




</header>