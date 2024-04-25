<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    use HasFactory;


    protected $fillable = [
        'statement_id',
        'title',
        'description',
        'status',
        'category',
        'photo_path',
    ];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function complaiments()
    {
        return $this->hasMany(Complaiment::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addComment($comment)
    {
        $this->comments()->create(['content' => $comment, 'user_id' => auth()->id()]);
    }
}
