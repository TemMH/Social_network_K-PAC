<?php

namespace App\Livewire;

use App\Events\MessageSendEvent;
use Livewire\Component;
use App\Models\Statement;
use App\Models\User;
use App\Models\Message;
use Livewire\Attributes\On;

class RepostStatementComponent extends Component
{

    public $user;
    public $showFriendsList = false;
    public $sender_id;
    public $recipient_id;
    public $statementId;
    public $friends;
    public $user_id;
    public $sentFriends = [];
    public $message = '';
    public $messages = [];

    public function mount($statementId)
    {
        $this->statementId = $statementId;
        $this->friends = User::where('id', '!=', auth()->id())->get();
        $this->sender_id = auth()->user()->id;
    }

    public function sendStatementToFriend()
    {
        $statement = Statement::findOrFail($this->statementId);
        $recipient = User::findOrFail($this->user_id);

        $messageContent = '<a href="' . route('statementuser', ['id' => $statement->id]) . '">Видео для тебя: ' . $statement->title . '</a>';

        $message = new Message();
        $message->sender_id = $this->sender_id;
        $message->recipient_id = $recipient->id;
        $message->message = $messageContent;
        $message->type = 'repost';
        $message->save();

        broadcast(new MessageSendEvent($message))->toOthers();

        $this->sentFriends[] = $recipient->id;
        $this->reset('user_id');
    }

    #[On('echo-private:chat-channel.{sender_id},MessageSendEvent')]
    public function listenForMessage($event)
    {
        $chatMessage = Message::whereId($event['message']['id'])
            ->with('sender:id,name', 'recipient:id,name')
            ->first();

        $this->emit('messageReceived', $chatMessage);
    }


    public function render()
    {
        return view('livewire.repost-statement-component');
    }
}
