<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['content', 'user_id', 'statement_id', 'video_id'];

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
}