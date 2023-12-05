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

class VideoController extends Controller
{
    

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:255',
        ]);
    
        $user = auth()->user(); // Получение текущего пользователя
    
        $video = $user->videos()->create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'new',
            'category'=> $request->category,
        ]);
    
        $videos = $user->videos()->get();
    
        return view('video.myvideo', ['videos' => $videos]);
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

    public function myvideo()
    {
        $user = auth()->user();
    
        $videos = $user->videos()
            ->withCount('likes')
            ->get();
    
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
