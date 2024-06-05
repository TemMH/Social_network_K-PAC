<section>

<div class="notification_block_contents_wrap">

    <div class="profileuser_block_contents_second_wrap_title">
        <p>Видеоматериалы</p>
    </div>

    <div class="right_block_wrap_line"></div>


</div>

<div id="searchResultsAdmin">
@foreach ($videos as $video)


    <div class="report_content_test">

        <div class="report_block_top_open">


            <div class="report_block_top_info_left_open">



                <a href="{{ route('videouser', ['id' => $video->id]) }}" class="statement_block_top_image_open">
                    <img src="{{ asset('storage/' . $video->thumbnail_path) }}" alt="Thumbnail"
                        style="object-fit:contain;" class="videoThumbnail" style="cursor:pointer;">
                </a>

                <div class="statement_block_top_addinfo">

                    <div class="statement_block_top_addinfo_first">

                        <p> {{ $video->title }} </p>

                    </div>


                    <div class="statement_block_top_addinfo_second">

                        <div class="statement_block_top_avatar_open">
                            @if ($video->user->avatar !== null)
                                <img class="avatar_mini"
                                    src="{{ asset('storage/' . $video->user->avatar) }}"
                                    alt="Avatar">
                            @else
                                <img class="avatar_mini" src="/uploads/ProfilePhoto.png" alt="Avatar">
                            @endif
                        </div>


                        <p>{{ $video->user->name }}</p>

                    </div>

                    <div class="statement_block_top_addinfo">


                        <p>{{ $video->created_at }}</p>

                    </div>

                </div>
            </div>

            <div class="report_block_top_info_right_open">




                <div class="report_block_top_info_right_open">

                </div>


            </div>



        </div>


        <div class="report_block_down_open">


            <div class="statement_block_down_views_open">
                @if ($video->isBlocked())
                <p>Заблокирован {{ $video->bans->first()->created_at }}</p> 
                <p>пользователем {{ optional($video->bans->first()->sender)->name }}</p>
                <p>По причине: {{ optional($video->bans->first()->reason)->name }}</p>

                @else
                <p>Не заблокирован</p>    
                @endif
            </div>

            <div class="statement_block_down_description_open" style="display: flex;">
                @if ($video->isBlocked())
                <form id="sendcomplaint" action="{{ route('admin.delete.ban.video', ['video' => $video->id]) }}" method="post">
                    @csrf
                <button name="edit_status" value="rejected" class="statements_categories_btn" > Разблокировать </button>
                </form>
                @else

                <form id="sendcomplaint" action="{{ route('complaint.post.video', ['video' => $video->id]) }}" method="post">
                    @csrf
                <button name="edit_status" value="accepted" class="statements_categories_btn" > Заблокировать </button>
                </form>

                @endif


                <form onclick="confirmVideoRemove('{{ $video->title }}', event)"
                    action="{{ route('admin.video.delete', $video) }}" method="post">
                    @method('DELETE')
                    @csrf
                    <button id="removeVideoForm" class="statements_categories_btn">Удалить
                        видеоматериал</button>
                </form>
                
            </div>


        </div>

    </div>
@endforeach
</div>
<script>
function confirmVideoRemove(title, event) {
    if (!confirm('Вы уверены, что хотите удалить видео ' + title + ' ?')) {
        event.preventDefault();
    }
}
</script>

@vite(['resources/js/search-input/admin/SearchAdminVideo.js'])


</section>