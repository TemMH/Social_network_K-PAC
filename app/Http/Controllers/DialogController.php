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
        $authUser = auth()->user();
        $user = User::findOrFail($id);
    
        $dialogs = Message::select('sender_id', 'recipient_id')
            ->where('sender_id', $authUser->id)
            ->orWhere('recipient_id', $authUser->id)
            ->get()
            ->groupBy(function ($item) {
                return $item->sender_id < $item->recipient_id
                    ? $item->sender_id . '-' . $item->recipient_id
                    : $item->recipient_id . '-' . $item->sender_id;
            });
    
        $dialogs = $dialogs->map(function ($item) {
            return $item->first();
        });
    
        // Создание пустого объекта для диалога с самим собой
        $selfDialog = (object) [
            'sender_id' => $authUser->id,
            'recipient_id' => $authUser->id,
            'lastMessage' => null,
            'user' => $authUser
        ];
    
        $lastMessage = Message::where('sender_id', $authUser->id)
            ->where('recipient_id', $authUser->id)
            ->orderByDesc('created_at')
            ->first();
    
        $selfDialog->lastMessage = $lastMessage;
    
        //в список диалогов
        $dialogs->push($selfDialog);
    

        foreach ($dialogs as $dialog) {
            if (!$dialog->lastMessage) {
                $lastMessage = Message::where(function ($query) use ($dialog) {
                    $query->where('sender_id', $dialog->sender_id)
                        ->where('recipient_id', $dialog->recipient_id);
                })->orWhere(function ($query) use ($dialog) {
                    $query->where('sender_id', $dialog->recipient_id)
                        ->where('recipient_id', $dialog->sender_id);
                })->orderByDesc('created_at')->first();
    
                $dialog->lastMessage = $lastMessage;
            }
    
            if (!isset($dialog->user)) {
                $dialog->user = User::find($dialog->sender_id == $authUser->id ? $dialog->recipient_id : $dialog->sender_id);
            }
        }
    
        return view('messenger.messenger', compact('id', 'dialogs', 'user', 'selfDialog'));
    }
    
    

    public function showMessenger()
    {
        $user = Auth::user();
        
        $dialogs = Message::select('sender_id', 'recipient_id')
            ->where('sender_id', auth()->id())
            ->orWhere('recipient_id', auth()->id())
            ->get()
            ->groupBy(function ($item) {
                return $item->sender_id < $item->recipient_id
                    ? $item->sender_id . '-' . $item->recipient_id
                    : $item->recipient_id . '-' . $item->sender_id;
            });
    
        $dialogs = $dialogs->map(function ($item) {
            return $item->first();
        });
    
        // Создание пустого объекта для диалога с самим собой
        $selfDialog = (object) [
            'sender_id' => auth()->id(),
            'recipient_id' => auth()->id(),
            'lastMessage' => null,
            'user' => $user
        ];
    
        $lastMessage = Message::where('sender_id', auth()->id())
            ->where('recipient_id', auth()->id())
            ->orderByDesc('created_at')
            ->first();
    
        $selfDialog->lastMessage = $lastMessage;
    
        //в список диалогов
        $dialogs->push($selfDialog);
    
        foreach ($dialogs as $dialog) {
            if (!$dialog->lastMessage) {
                $lastMessage = Message::where(function ($query) use ($dialog) {
                    $query->where('sender_id', $dialog->sender_id)
                        ->where('recipient_id', $dialog->recipient_id);
                })->orWhere(function ($query) use ($dialog) {
                    $query->where('sender_id', $dialog->recipient_id)
                        ->where('recipient_id', $dialog->sender_id);
                })->orderByDesc('created_at')->first();
    
                $dialog->lastMessage = $lastMessage;
            }
    
            if (!isset($dialog->user)) {
                $dialog->user = User::find($dialog->sender_id == auth()->id() ? $dialog->recipient_id : $dialog->sender_id);
            }
        }
    
        return view('messenger.messenger', compact('dialogs', 'user', 'selfDialog'));
    }
    
    


    
}
