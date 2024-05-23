<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friendship;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function friendRequests()
    {
        $friendRequests = Friendship::where('recipient_id', auth()->id())
            ->where('status', 'pending')
            ->with('sender') 
            ->get();
    
        return view('friend-requests', compact('friendRequests'));
    }

    public function acceptFriendRequest($id)
    {
        $friendRequest = Friendship::findOrFail($id);
        $friendRequest->status = 'accepted';
        $friendRequest->save();

        return redirect()->back();
    }

    public function rejectFriendRequest($id)
    {
        $friendRequest = Friendship::findOrFail($id);
        $friendRequest->status = 'rejected';
        $friendRequest->save();

        return redirect()->back();
    }


    public function removeFriend(Request $request, User $friend)
    {

        Friendship::where(function ($query) use ($friend) {
            $query->where('sender_id', auth()->id())->where('recipient_id', $friend->id);
        })
        ->orWhere(function ($query) use ($friend) {
            $query->where('sender_id', $friend->id)->where('recipient_id', auth()->id());
        })
        ->delete();

        return redirect()->back();
    }


    
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

    public function showFriendRequests()
    {
        $friendRequests = Auth::user()->friendRequests;

        return view('friend-requests', compact('friendRequests'));
    }

}
