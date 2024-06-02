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


        <button wire:click="$toggle('showFriendsList')" class="mini_button">

            @include('general.elements.svg-repost')

        </button>


        @if ($showFriendsList)
        <div class="statement_field_open opened">
            <div class="modal_block_open">
                <div class="modal-content">
                    <div class="friendsList_repost">
                        <p>Выберите друга для отправки</p>
                        <div class='radio-group' id="reasons-container">
                            @foreach ($friends as $friend)
                                <div class="friend-item">
                                    <label class='radio-label'>
                                        <input wire:click="$set('user_id', {{ $friend->id }})" type='radio' name='friend' value="{{ $friend->id }}" wire:model="user_id">
                                        <span class='inner-label'>
                                            @if ($friend->id == auth()->user()->id)
                                                Избранное
                                            @endif
                                            {{ $friend->name }}
                                        </span>
                                    </label>
                                    @if (in_array($friend->id, $sentFriends))
                                        <button disabled class="long_button">Отправлено</button>
                                    @elseif ($user_id === $friend->id)
                                        <button wire:click="sendStatementToFriend" class="long_button">Отправить</button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
    
            <button wire:click="$set('showFriendsList', false)" class="statement_block_btn_close">
                @include('general.elements.svg-close-modal')
            </button>
        </div>
    @endif
    
    
    


    


    </div>



</div>
