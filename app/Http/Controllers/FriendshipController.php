<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friendship;

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


    
    

}
