<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id','user_id', 'statement_id', 'video_id', 'status', 'reason', 'dateunlock'];


    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function statement()
    {
        return $this->belongsTo(Statement::class);
    }

}
