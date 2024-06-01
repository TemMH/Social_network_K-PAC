<div>
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
    <div>

        <button wire:click="$toggle('showFriendsList')">Отправить видео другу</button>
    

        @if($showFriendsList)
            <div class="friendsList_repost">
                @foreach ($friends as $friend)
                    <button wire:click="$set('user_id', {{ $friend->id }})">
                        {{ $friend->name }}
                    </button>
                @endforeach
                <button wire:click="$set('showFriendsList', false)">Закрыть</button>
            </div>
        @endif
    

        @if($user_id)
            <form wire:submit.prevent="sendVideoToFriend">
                <input type="hidden" wire:model="videoId" value="{{ $videoId }}" />
                <button type="submit">Отправить видео другу</button>
            </form>
        @endif
    </div>

    
    <script>
        function toggleFriendsList(postId) {
            const friendsList = document.getElementById(`friendsList${postId}`);
            friendsList.style.display = friendsList.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</div>
