<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friendship;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class FriendshipController extends Controller
{
//Все лрузья


    //принятие в друзья


    //Отказ от дружбы


//Удалить из друзей



    //Отправить запрос в друзья



    // public function showFriendRequests()
    // {
    //     $friendRequests = Auth::user()->friendRequests;

    //     return view('friend-requests', compact('friendRequests'));
    // }



public function acceptFriendRequest($userId)
{
    $friendRequest = Friendship::where('sender_id', $userId)
                               ->where('recipient_id', auth()->id())
                               ->firstOrFail();
    $friendRequest->status = 'accepted';
    $friendRequest->save();


        Flash::success('
    <div class="flash-success">
    <div class="flsh-title">
        K-PAC
    </div>
    <div class="flash-message">
    Запрос в друзья принят
    </div>
    </div>');

    return redirect()->back();
}

public function rejectFriendRequest($userId)
{
    $friendRequest = Friendship::where('sender_id', $userId)
                               ->where('recipient_id', auth()->id())

                               ->firstOrFail();
    $friendRequest->status = 'rejected';
    $friendRequest->save();

    Flash::success('
            
    <div class="flash-success">
    <div class="flsh-title">
        K-PAC
    </div>
    <div class="flash-message">
    Запрос в друзья откнонён
    </div>
    </div>'

);

    return redirect()->back()->with('success', 'Запрос в друзья отклонён.');
}

public function removeFriend(Request $request, User $friend){  
    Friendship::where(function ($query) use ($friend) {
        $query->where('sender_id', auth()->id())->where('recipient_id', $friend->id);
    })
    ->orWhere(function ($query) use ($friend) {
        $query->where('sender_id', $friend->id)->where('recipient_id', auth()->id());
    })
    ->delete();
    
    Flash::success('
    <div class="flash-success">
    <div class="flsh-title">
        K-PAC
    </div>
    <div class="flash-message">
    Вы отписались от пользователя
    </div>
    </div>');


    return redirect()->back()->with('success', 'Пользователь удалён из друзей.');
}


public function sendFriendRequest(Request $request, $recipientId)
{
    $existingRequest = Friendship::where(function ($query) use ($recipientId) {
        $query->where('sender_id', auth()->id())->where('recipient_id', $recipientId)
              ->orWhere('sender_id', $recipientId)->where('recipient_id', auth()->id());
    })->whereIn('status', ['pending', 'accepted'])->first();

    if ($existingRequest) {
        return redirect()->back()->with('error', 'Запрос уже отправлен или вы уже друзья.');
    }

    Friendship::create([
        'sender_id' => auth()->id(),
        'recipient_id' => $recipientId,
        'status' => 'pending',
    ]);

    Flash::success('
    <div class="flash-success">
    <div class="flsh-title">
        K-PAC
    </div>
    <div class="flash-message">
    Запрос в друзья отправлен
    </div>
    </div>');

    return redirect()->back()->with('success', 'Запрос в друзья успешно отправлен.');
}


}
