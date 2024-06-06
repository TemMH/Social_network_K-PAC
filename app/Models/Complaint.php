<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id','user_id', 'statement_id', 'video_id', 'reason_id', 'status',];


    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function reason()
    {
        return $this->belongsTo(Reason::class, 'reason_id');
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function statement()
    {
        return $this->belongsTo(Statement::class);
    }



    public function bans()
    {
        return $this->belongsToMany(Ban::class, 'complaint_ban', 'complaint_id', 'ban_id');
    }

    public static function hasComplaintVideo($videoId, $userId)
    {
        return self::where('video_id', $videoId)
            ->where('sender_id', $userId)
            ->exists();
    }

    
    public static function hasComplaintStatement($videoId, $userId)
    {
        return self::where('statement_id', $videoId)
            ->where('sender_id', $userId)
            ->exists();
    }

    
    public static function hasComplaintUser($videoId, $userId)
    {
        return self::where('user_id', $videoId)
            ->where('sender_id', $userId)
            ->exists();
    }

}
