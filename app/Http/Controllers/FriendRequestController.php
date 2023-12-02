<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\zayavka;
use App\Models\Friendship;


use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    public function sendFriendRequest(Request $request, $recipientId)
    {
        $existingRequest = Friendship::where('sender_id', auth()->id())
            ->where('recipient_id', $recipientId)
            ->where('status', 'pending')
            ->first();
    
        if ($existingRequest) {

            return redirect()->back()->with('error', 'Запрос уже отправлен и ожидает ответа.');
        }

        $existingRequest = Friendship::where('sender_id', auth()->id())
        ->where('recipient_id', $recipientId)
        ->where('status', 'accepted')
        ->first();

    if ($existingRequest) {

        return redirect()->back()->with('error', 'Запрос уже отправлен и ожидает ответа.');
    }
    

        Friendship::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $recipientId,
            'status' => 'pending',
        ]);
    
        return redirect()->back()->with('success', 'Запрос в друзья успешно отправлен.');
    }


    public function acceptFriendRequest(User $user)
    {
        auth()->user()->acceptFriendRequest($user);

        return back()->with('success', 'Friend request accepted!');
    }

    public function rejectFriendRequest(User $user)
    {
        auth()->user()->rejectFriendRequest($user);

        return back()->with('success', 'Friend request rejected!');
    }



    public function showFriendRequests()
    {
        $friendRequests = Auth::user()->friendRequests;

        return view('friend-requests', compact('friendRequests'));
    }


}
