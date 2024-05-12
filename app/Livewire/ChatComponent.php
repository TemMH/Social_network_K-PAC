<?php

namespace App\Livewire;

use App\Events\MessageSendEvent;
use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\On; 

class ChatComponent extends Component
{

    public $user;

    public $sender_id;

    public $recipient_id;

    public $message = '';

    public $messages = [];


    public function render()
    {
        return view('livewire.chat-component');
    }

    public function mount($user_id)
    {
        $this->sender_id = auth()->user()->id;
        $this->recipient_id = $user_id;

        $messages = Message::where(function($query){
            $query->where('sender_id', $this->sender_id)
            ->where('recipient_id', $this->recipient_id);
        })->orWhere(function($query){
            $query->where('sender_id', $this->recipient_id)
            ->where('recipient_id', $this->sender_id);
        })->with('sender:id,name', 'recipient:id,name')->orderBy('created_at')->get();

        foreach($messages as $message){
        
            $this->chatMessage($message);

        }

        $this->user = User::find($user_id);
    }

    public function sendMessage()
    {

        $message = new Message();
        $message->sender_id = $this->sender_id;
        $message->recipient_id = $this->recipient_id;
        $message->message = $this->message;
        $message->save();
        $this->chatMessage($message);

        broadcast(new MessageSendEvent($message))->toOthers();

        $this->message = '';

    }

    #[On('echo-private:chat-channel.{sender_id},MessageSendEvent')]
    public function listenForMessage($event){

    $chatMessage = Message::whereId($event['message']['id'])->with('sender:id,name', 'recipient:id,name')->first();
        $this->chatMessage($chatMessage);

    }

    public function chatMessage($message){
    
        $this->messages[]= [

            'id' => $message->id,
            'message' => $message->message,
            'sender' => $message->sender->name,
            'recipient' => $message->recipient->name,

        ];

    }

}
