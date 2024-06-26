<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statement;
use App\Models\Video;
use App\Models\User;
use App\Models\Message;


class AutocompleteController extends Controller
{

    
    public function autocompletestatement(Request $request)
    {
        $searchTerm = $request->input('search');

        $statements = Statement::query()
            ->where('title', 'LIKE', '%' . $searchTerm . '%')
            ->whereDoesntHave('bans')
            ->with('user')
            ->withCount('likes', 'views', 'comments')
            ->limit(3)
            ->get();


        $base_url = url('/storage/');

        return response()->json([
            'statements' => $statements,

            // 'videos' => $videos, 'users' => $users , 

            'base_url' => $base_url
        ]);
    }


    public function autocompletevideo(Request $request)
    {
        $searchTerm = $request->input('search');

        $videos = Video::query()
            ->where('title', 'LIKE', '%' . $searchTerm . '%')
            ->whereDoesntHave('bans')
            ->with('user')
            ->withCount('likes', 'views', 'comments')
            ->limit(3)
            ->get();

        $base_url = url('/storage/');

        return response()->json(['videos' => $videos,  'base_url' => $base_url]);
    }

    public function autocompleteuser(Request $request)
    {
        $searchTerm = $request->input('search');

        $users = User::query()
            ->where('name', 'LIKE', '%' . $searchTerm . '%')
            ->whereDoesntHave('bans')
            ->limit(3)
            ->get();

        $base_url = url('/storage/');

        return response()->json(['users' => $users, 'base_url' => $base_url]);
    }

    public function autocompletedialog(Request $request)
    {
        $searchTerm = $request->input('search');


        $dialogsFromSender = Message::select('sender_id', 'recipient_id')
            ->leftJoin('users as sender', 'messages.sender_id', '=', 'sender.id')
            ->leftJoin('users as recipient', 'messages.recipient_id', '=', 'recipient.id')
            ->where('sender.name', 'LIKE', '%' . $searchTerm . '%')
            ->whereNotIn('messages.sender_id', [auth()->id()])
            ->groupBy('sender_id', 'recipient_id')
            ->get();

        $dialogsFromRecipient = Message::select('sender_id', 'recipient_id')
            ->leftJoin('users as sender', 'messages.sender_id', '=', 'sender.id')
            ->leftJoin('users as recipient', 'messages.recipient_id', '=', 'recipient.id')
            ->where('recipient.name', 'LIKE', '%' . $searchTerm . '%')
            ->whereNotIn('messages.recipient_id', [auth()->id()])
            ->groupBy('sender_id', 'recipient_id')
            ->get();

        $dialogs = $dialogsFromSender->concat($dialogsFromRecipient);

        // $dialogs = $dialogs->filter(function ($dialog) {
        //     return $dialog->sender_id != $dialog->recipient_id;
        // });

        foreach ($dialogs as $dialog) {
            $lastMessage = Message::where(function ($query) use ($dialog) {
                $query->where('sender_id', $dialog->sender_id)
                    ->where('recipient_id', $dialog->recipient_id);
            })->orWhere(function ($query) use ($dialog) {
                $query->where('sender_id', $dialog->recipient_id)
                    ->where('recipient_id', $dialog->sender_id);
            })->orderByDesc('created_at')->first();

            $dialog->lastMessage = $lastMessage;

            if ($dialog->sender_id == auth()->id()) {
                $dialog->user = User::find($dialog->recipient_id);
            } else {
                $dialog->user = User::find($dialog->sender_id);
            }
        }

        $dialogs = $dialogs->unique(function ($item) {
            return min($item->sender_id, $item->recipient_id) . '-' . max($item->sender_id, $item->recipient_id);
        });

        $base_url = url('/storage/');

        return response()->json(['dialogs' => $dialogs, 'base_url' => $base_url]);
    }














    



}
