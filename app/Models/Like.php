<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['user_id', 'zayavka_id', 'video_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function zayavka()
    {
        return $this->belongsTo(Zayavka::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
