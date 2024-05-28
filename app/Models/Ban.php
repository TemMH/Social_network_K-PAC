<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'statement_id',
        'video_id',
        'reason_id',
        'sender_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statement()
    {
        return $this->belongsTo(Statement::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }



    public function complaints()
    {
        return $this->belongsToMany(Complaint::class, 'complaint_ban', 'ban_id', 'complaint_id');
    }
    
}
