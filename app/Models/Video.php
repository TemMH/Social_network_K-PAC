<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;


    protected $fillable = [
        'video_id',
        'title',
        'description',
        'category_id',
        'video_path',
        'thumbnail_path',
    ];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'video_id');
    }

    public function views()
    {
        return $this->hasMany(View::class, 'video_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function addComment($comment)
    {
        $this->comments()->create(['content' => $comment, 'user_id' => auth()->id()]);
    }


    public function isBlocked()
    {

    $videoId = $this->id;

    
    return $this->bans()->where('video_id', $videoId)->whereNotNull('created_at')->exists();
    }

    public function bans()
    {
        return $this->hasMany(Ban::class);
    }


}
