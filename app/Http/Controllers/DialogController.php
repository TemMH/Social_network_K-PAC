<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Statement;
use App\Models\Message;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Mail;

class DialogController extends Controller
{

    public function chat($id)
    {

        $user = User::findOrFail($id);

        if (auth()->user()->role !== 'Admin') {
            // Если текущий пользователь не администратор, проверяем, являются ли они друзьями
            if (!auth()->user()->areFriends($id)) {
                abort(403, 'Вы не являетесь друзьями для доступа к диалогу.');
            }
        }
        $dialogs = Message::select('sender_id', 'recipient_id')
            ->where('sender_id', auth()->id())
            ->orWhere('recipient_id', auth()->id())
            ->groupBy('sender_id', 'recipient_id')
            ->get();


        $dialogs = $dialogs->filter(function ($dialog) {
            return $dialog->sender_id != $dialog->recipient_id;
        });

        foreach ($dialogs as $dialog) {
            $lastMessage = Message::where(function ($query) use ($dialog) {
                $query->where('sender_id', $dialog->sender_id)
                    ->where('recipient_id', $dialog->recipient_id);
            })->orWhere(function ($query) use ($dialog) {
                $query->where('sender_id', $dialog->recipient_id)
                    ->where('recipient_id', $dialog->sender_id);
            })->orderByDesc('created_at')->first();

            $dialog->lastMessage = $lastMessage;
            $dialog->user = User::find($dialog->sender_id);
        }

        return view('messenger.messenger', compact('id', 'dialogs', 'user'));
    }

    public function showMessenger()
    {

        $user = Auth::user();


        $dialogs = Message::select('sender_id', 'recipient_id')
            ->where('sender_id', auth()->id())
            ->orWhere('recipient_id', auth()->id())
            ->groupBy('sender_id', 'recipient_id')
            ->get();


        $dialogs = $dialogs->filter(function ($dialog) {
            return $dialog->sender_id != $dialog->recipient_id;
        });


        foreach ($dialogs as $dialog) {
            $lastMessage = Message::where(function ($query) use ($dialog) {
                $query->where('sender_id', $dialog->sender_id)
                    ->where('recipient_id', $dialog->recipient_id);
            })->orWhere(function ($query) use ($dialog) {
                $query->where('sender_id', $dialog->recipient_id)
                    ->where('recipient_id', $dialog->sender_id);
            })->orderByDesc('created_at')->first();

            $dialog->lastMessage = $lastMessage;
            $dialog->user = User::find($dialog->sender_id);
        }

        return view('messenger.messenger', compact('dialogs', 'user'));
    }


    


    public function sendPostToFriend(Request $request, $statementId, $friendId)
    {

        $statement = Statement::findOrFail($statementId);
        $friend = User::findOrFail($friendId);


        $messageContent = '<a href="' . route('statementuser', ['id' => $statement->id]) . '">Пост для тебя: ' . $statement->description . '</a>';



        $message = Message::create([
            'message' => $messageContent,
            'type' => 'repost',
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
            'message' => $messageContent,
            'sender_id' => auth()->id(),
            'recipient_id' => $friend->id,
        ]);

        return redirect()->back()->with('success', 'Видео отправлено пользователю ' . $friend->name);
    }
}
