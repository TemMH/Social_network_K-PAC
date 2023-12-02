<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zayavka extends Model
{
    use HasFactory;


    protected $fillable = [
        'zayavka_id',
        'name',
        'zagolovok',
        'description',
        'user_id',
        'status',
        'category',
    ];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

    public function addComment($comment)
    {
        $this->comments()->create(['content' => $comment, 'user_id' => auth()->id()]);
    }
}
