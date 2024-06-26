<?php

namespace App\Models;

use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;


class User extends Authenticatable implements MustVerifyEmail

{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'number',
        'role',
        'avatar',
        'condition',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function sendFriendRequest(User $recipient)
    {
        $this->friendships()->create([
            'recipient_id' => $recipient->id,
            'status' => 'pending',
        ]);
    }

    public function acceptFriendRequest(User $sender)
    {
        $friendship = $this->friendships()->where('sender_id', $sender->id)->first();
        $friendship->update(['status' => 'accepted']);
    }

    public function rejectFriendRequest(User $sender)
    {
        $this->friendships()->where('sender_id', $sender->id)->delete();
    }

    public function friendships()
    {
        return $this->hasMany(Friendship::class, 'sender_id');
    }

    public function friendRequests()
    {
        return $this->hasMany(Friendship::class, 'recipient_id')->where('status', 'pending');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'sender_id', 'recipient_id')
            ->wherePivot('status', 'accepted')
            ->withTimestamps();
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }



    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function statements()
    {
        return $this->hasMany(Statement::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'user_id');
    }

    public function views()
    {
        return $this->hasMany(View::class, 'user_id');
    }


    public function isBlocked()
    {

    $userId = $this->id;

    
    return $this->bans()->where('user_id', $userId)->whereNotNull('created_at')->exists();
    }

    public function bans()
    {
        return $this->hasMany(Ban::class);
    }

    //Friends

    public function areFriends($userId)
{
    return $this->checkFriendshipStatus($userId, 'accepted');
}

public function arePending($userId)
{
    return $this->checkFriendshipStatus($userId, 'pending');
}

public function areSubscriber($userId)
{
    return $this->checkFriendshipStatus($userId, 'rejected');
}

private function checkFriendshipStatus($userId, $status)
{
    return Friendship::where(function ($query) use ($userId, $status) {
        $query->where('sender_id', $this->id)
              ->where('recipient_id', $userId)
              ->where('status', $status);
    })->orWhere(function ($query) use ($userId, $status) {
        $query->where('sender_id', $userId)
              ->where('recipient_id', $this->id)
              ->where('status', $status);
    })->exists();
}

public function isRequesting($userId)
{
    return Friendship::where('sender_id', $this->id )
                     ->where('recipient_id', $userId)
                     ->where('status', 'pending')
                     ->exists();
}

public function isSender($userId)
{
    return Friendship::where('sender_id', $this->id)
                     ->where('recipient_id', $userId)
                     ->where('status', 'rejected')
                     ->exists();
}

public function isRecipient($userId)
{
    return Friendship::where('sender_id', $userId)
                     ->where('recipient_id', $this->id)
                     ->where('status', 'rejected')
                     ->exists();
}

public function sendEmailVerificationNotification()
{
    $this->notify(new VerifyEmail);
}
}
