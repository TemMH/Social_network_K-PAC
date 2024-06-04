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

use function Laravel\Prompts\select;

class DialogController extends Controller
{

    public function chat($id)
    {

        $user = User::findOrFail($id);

        if (auth()->user()->role !== 'Admin') {
            // Если текущий пользователь не администратор, проверяем, являются ли они друзьями
            if (!auth()->user()->areFriends($id) && !auth()->user() == ($id)) {
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


    $selfDialog = Message::where('sender_id', auth()->id())
        ->where('recipient_id', auth()->id())
        ->first();

    if ($selfDialog) {
        $dialogs->push($selfDialog);
    }
    
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

        return view('messenger.messenger', compact('id', 'dialogs', 'user','selfDialog'));
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


    $selfDialog = Message::where('sender_id', auth()->id())
    ->where('recipient_id', auth()->id())
    ->first();

if ($selfDialog) {
    $dialogs->push($selfDialog);
}


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

        return view('messenger.messenger', compact('dialogs', 'user','selfDialog'));
    }


    
}
