<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Statement;
use App\Models\Message;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Mail;

class DialogController extends Controller
{
public function show($userId)
{
    $user = User::findOrFail($userId);

    if (!auth()->user()->areFriends($userId)) {
        abort(403, 'Вы не являетесь друзьями для доступа к диалогу.');
    }

    $messages = Message::where(function ($query) use ($userId) {
        $query->where('sender_id', auth()->id())
            ->where('recipient_id', $userId);
    })->orWhere(function ($query) use ($userId) {
        $query->where('sender_id', $userId)
            ->where('recipient_id', auth()->id());
    })->get();

    $lastMessage = $messages->last();

    return view('messenger.messenger', compact('user', 'messages', 'lastMessage'));
}


    public function sendMessage(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $userId,
            'content' => $request->input('message'),
        ]);

        return redirect()->route('messenger.show', $userId);
    }

    public function sendPostToFriend(Request $request, $postId, $friendId)
    {

        $post = Statement::findOrFail($postId);
        $friend = User::findOrFail($friendId);


        $messageContent = '<a href="' . route('statementuser', ['id' => $post->id]) . '">Пост для тебя: ' . $post->description . '</a>';

        

        $message = Message::create([
            'content' => $messageContent,
            'sender_id' => auth()->id(), 
            'recipient_id' => $friend->id, 
        ]);
    

    
        return redirect()->back()->with('success', 'Пост отправлен пользователю ' . $friend->name);
    }
    
    public function sendVideoToFriend(Request $request, $videoId, $friendId)
{
    $video = Video::findOrFail($videoId);
    $friend = User::findOrFail($friendId);



    $messageContent = '<a href="' . route('videouser', ['id' => $video->id]) . '">Видео для тебя: ' . $video->title . '</a>';

    $message = Message::create([
        'content' => $messageContent,
        'sender_id' => auth()->id(),
        'recipient_id' => $friend->id,
    ]);

    return redirect()->back()->with('success', 'Видео отправлено пользователю ' . $friend->name);
}



}
