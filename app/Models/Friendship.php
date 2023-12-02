<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Friendship extends Model
{
    protected $fillable = ['sender_id', 'recipient_id', 'status'];


    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

}
