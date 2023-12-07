<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class VideoController extends Controller
{
    

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'video' => 'required|file|mimes:mp4|max:500000',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048|aspect_ratio',
        ]);
    
        $user = auth()->user();
    
        if ($request->hasFile('video') && $request->hasFile('thumbnail')) {
            $uploadedVideo = $request->file('video');
            $videoName = 'video_' . time() . '.' . $uploadedVideo->getClientOriginalExtension();
            $videoPath = $uploadedVideo->storeAs('public/videos', $videoName);
    
            $uploadedThumbnail = $request->file('thumbnail');
            $thumbnailName = 'thumbnail_' . time() . '.' . $uploadedThumbnail->getClientOriginalExtension();
            $thumbnailPath = $uploadedThumbnail->storeAs('public/thumbnails', $thumbnailName);
    
            $video = $user->videos()->create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => 'new',
                'category' => $request->category,
                'video_path' => 'videos/' . $videoName,
                'thumbnail_path' => 'thumbnails/' . $thumbnailName,
            ]);
    
            $videos = $user->videos()->get();
    
            return view('video.myvideo', ['videos' => $videos])->with('success', 'Видео успешно загружено!');
        }
    
        return back()->with('error', 'Ошибка при загрузке видео или превью');
    }
    
    
    
    

    public function addComment(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $video->addComment($request->input('comment'));
    
        return redirect()->back();
    }
    
    public function deleteComment($videoId, $commentId)
{
    $video = Video::findOrFail($videoId);
    $comment = Comment::findOrFail($commentId);


    if ($comment->video_id !== $video->id) {
        abort(403, 'Этот комментарий не принадлежит указанной заявке.');
    }


    $comment->delete();

    return redirect()->back();
}


    public function allvideouser(Request $request)
    {
        $category = $request->input('category');
        $sort = $request->input('sortirovka');
    
        $videos = Video::where('status', 'true')->withCount('likes');
    
        if ($category) {
            $videos->where('category', $category);
        }
    
        switch ($sort) {
            case 'old':
                $videos->orderBy('created_at', 'asc');
                break;
            case 'popular':
                $videos->withCount('likes')->orderByDesc('likes_count');
                break;
            case 'recent':
            default:
                $videos->orderBy('created_at', 'desc');
                break;
        }
    
        $videos = $videos->get();
    
        return view('video.allvideouser', ['videos' => $videos]);
    }
    
    public function show($id)
    {
        
        $video = Video::with('comments.user')->findOrFail($id);
    
        return view('video.videouser', ['video' => $video]);
    }

    public function allvideo(User $user)
    {

        $videos = Video::orderBy('created_at', 'desc')->get();
        return view('video.allvideo', ['videos' => $videos]);

    }

    public function updatevideo(Request $request, $id)
    {

        $video = Video::find($id);
        $video->status = $request->status;
        $video->save();

        return redirect()->back()->with('success', 'Статус успешно обновлён');
    }

    public function myvideo(Request $request)
    {
        $category = $request->input('category');
        $sort = $request->input('sortirovka');
    
        $videos = Video::where('user_id', auth()->id())
            ->withCount('likes');
    
        if ($category) {
            $videos->where('category', $category);
        }
    
        switch ($sort) {
            case 'old':
                $videos->orderBy('created_at', 'asc');
                break;
            case 'popular':
                $videos->withCount('likes')->orderByDesc('likes_count');
                break;
            case 'recent':
            default:
                $videos->orderBy('created_at', 'desc');
                break;
        }
    
        $videos = $videos->get();
    
        return view('video.myvideo', ['videos' => $videos]);
    }
    

    

    public function like(Request $request, $id)
    {
        $video = Video::findOrFail($id);
    
        if (!$video->likes()->where('user_id', auth()->id())->exists()) {
            $like = new Like([
                'user_id' => auth()->id(),
                'zayavka_id' => null,
            ]);
            $video->likes()->save($like);
        }
    
        return redirect()->back();
    }
    

    public function unlike(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $video->likes()->where('user_id', auth()->id())->delete();

        return redirect()->back();
    }

}
