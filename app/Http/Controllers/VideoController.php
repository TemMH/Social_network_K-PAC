<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
// use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\View;
use App\Models\Complaint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use getID3;


class VideoController extends Controller
{


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'video' => 'required|file|mimes:mp4|max:500000',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048|aspect_ratio',
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
                'status' => 'true',
                'category' => $request->category,
                'video_path' => 'videos/' . $videoName,
                'thumbnail_path' => 'thumbnails/' . $thumbnailName,
            ]);

            $videos = $user->videos()->get();

            return back()->with('success', 'Видео успешно загружено!');
        }

        return back()->with('error', 'Ошибка при загрузке видео или превью');
    }





    public function addComment(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $video->addComment($request->input('comment'));

        return redirect()->back();
    }




    public function allvideouser(Request $request)
    {
        $category = $request->input('category');
        $userId = Auth::id();

        $trendvideos = Video::where('status', 'true')
        ->withCount('likes', 'comments', 'views')
        ->with(['likes', 'views'])
        ->when($category, function ($query, $category) {
            return $query->where('category', $category);
        })
        ->get()
        ->sortByDesc(function ($video) {
            if ($video->views_count == 0) {
                return -1;
            }
            return $video->likes_count / $video->views_count;
        })
        ->take(4);

    $popularvideos = Video::where('status', 'true')
        ->withCount('likes', 'comments', 'views')
        ->when($category, function ($query, $category) {
            return $query->where('category', $category);
        })
        ->limit(4)
        ->orderByDesc('views_count')
        ->get();
    
    $newforuservideos = Video::select('videos.*') 
        ->leftJoin('views', function ($join) use ($userId) {  
            $join->on('videos.id', '=', 'views.video_id') 
                 ->where('views.user_id', '=', $userId);
        })
        ->whereNull('views.id')
        ->where('videos.status', 'true')
        ->when($category, function ($query, $category) {
            return $query->where('category', $category);
        })
        ->withCount('likes', 'comments', 'views')
        ->limit(4)
        ->get();
    
    $newvideos = Video::where('status', 'true')
        ->withCount('likes', 'comments', 'views')
        ->when($category, function ($query, $category) {
            return $query->where('category', $category);
        })
        ->limit(4)
        ->orderByDesc('created_at')
        ->get();
    
    $viewedrvideos = Video::select('videos.*') 
        ->join('views', function ($join) use ($userId) { 
            $join->on('videos.id', '=', 'views.video_id')
                 ->where('views.user_id', '=', $userId);
        })
        ->where('videos.status', 'true')
        ->when($category, function ($query, $category) {
            return $query->where('category', $category);
        })
        ->withCount('likes', 'comments', 'views')
        ->limit(4)
        ->orderBy('views.created_at', 'desc')
        ->get();
    
        return view('video.mainallvideouser', compact('trendvideos', 'popularvideos', 'newforuservideos', 'newvideos', 'viewedrvideos'));
    }


    

    public function allvideouserviewed(Request $request)
    {
        $category = $request->input('category');
        $userId = Auth::id();

        $videos = Video::select('videos.*') //выбор всех столбцов
        ->join('views', function ($join) use ($userId) { // анонимная функция $join  для установления связи между таблицами + при объединении передаем $userId внутрь анонимной функции
            $join->on('videos.id', '=', 'views.statement_id') // объединить id с video_id 
                 ->where('views.user_id', '=', $userId);
        })
        ->where('videos.status', 'true')
        ->withCount('likes', 'comments', 'views')
        ->orderBy('views.created_at', 'desc');
    
    

        if ($category) {
            $videos->where('category', $category);
        }


        $videos = $videos->get();

        return view('video.allvideouser', ['videos' => $videos]);
    }

    public function allvideousernewforuser(Request $request)
    {
        $category = $request->input('category');
        $userId = Auth::id();


        $videos = Video::select('videos.*') //выбор всех столбцов
            ->leftJoin('views', function ($join) use ($userId) {  // анонимная функция $join  для установления связи между таблицами + при объединении передаем $userId внутрь анонимной функции
                $join->on('videos.id', '=', 'views.statement_id') // объединить id с video_id 
                    ->where('views.user_id', '=', $userId);
            })
            ->whereNull('views.id')
            ->where('videos.status', 'true')
            ->withCount('likes', 'comments', 'views');


        if ($category) {
            $videos->where('videos.category', $category);
        }


        $videos = $videos->get();
        return view('video.allvideouser', ['videos' => $videos]);
    }

    public function allvideouserpopular(Request $request)
    {
        $category = $request->input('category');


        $videos = Video::where('status', 'true')
            ->withCount('likes', 'comments', 'views')
            ->orderByDesc('views_count');



        if ($category) {
            $videos->where('videos.category', $category);
        }



        $videos = $videos->get();
        return view('video.allvideouser', ['videos' => $videos]);
    }

    public function allvideousertrend(Request $request)
    {
        $category = $request->input('category');

        $videos = Video::where('status', 'true')
            ->withCount('likes', 'comments', 'views')
            ->with(['likes', 'views'])
            ->get()
            ->sortByDesc(function ($video) {
                // Если просмотры = 0 отнести это заявление вниз
                if ($video->views_count == 0) {
                    return -1;
                }

                return $video->likes_count / $video->views_count;
            });

        if ($category) {
            $videos = $videos->where('category', $category);
        }

        return view('video.allvideouser', ['videos' => $videos]);
    }

    public function allvideousernew(Request $request)
    {
        $category = $request->input('category');

        $videos = Video::where('status', 'true')
            ->withCount('likes', 'comments', 'views')
            ->orderByDesc('created_at');


        if ($category) {
            $videos->where('videos.category', $category);
        }

        $videos = $videos->get();
        return view('video.allvideouser', ['videos' => $videos]);
    }



    

    public function show($id)
    {
        $trendvideos = Video::where('status', 'true')
        ->withCount('likes', 'comments', 'views')
        ->with(['likes', 'views'])
        ->get()
        ->sortByDesc(function ($video) {
            if ($video->views_count == 0) {
                return -1;
            }
            return $video->likes_count / $video->views_count;
        })
        ->take(6);


        $video = Video::with('comments.user')
            ->with('complaints')
            ->withCount('views','likes','comments')
            ->findOrFail($id);


        $existingView = View::where('user_id', Auth::id())
            ->where('video_id', $video->id)
            ->exists();

        if ($existingView) {
            return view('video.videouser', compact('video', 'trendvideos'));
        }

        $view = new View();
        $view->user_id = Auth::id();
        $view->video_id = $video->id;
        $view->save();

        return view('video.videouser', compact('video', 'trendvideos'));
    }

    public function showshorts($id)
    {

        $video = Video::with('comments.user')->findOrFail($id);

        return view('video.shortsvideouser', ['video' => $video]);
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



    public function allshortsvideouser(Request $request)
    {
        $userId = Auth::id();

        $videos = Video::select('videos.*')
            ->leftJoin('views', function ($join) use ($userId) {
                $join->on('videos.id', '=', 'views.video_id')
                    ->where('views.user_id', '=', $userId);
            })
            ->whereNull('views.id')
            ->where('videos.status', 'true');


        // Получение длительности видео и фильтрация только тех, которые равны 30 секундам
        $videos = $videos->get()->filter(function ($video) {
            $videoPath = Storage::disk('public')->path($video->video_path); // Путь к видеофайлу в хранилище (может потребоваться подправить в соответствии с вашей структурой хранения)
            $duration = $this->getVideoDuration($videoPath);
            return $duration <= 30;
        });


        return view('video.shortsvideouser', ['videos' => $videos]);
    }


    public function allshortsvideouserviewed(Request $request)
    {

        $userId = Auth::id();

        $viewedVideoIds = View::where('user_id', $userId)->pluck('video_id')->all();

        $videos = Video::where('status', 'true')
            ->whereIn('id', $viewedVideoIds)
            ->withCount('likes');

                // Получение длительности видео и фильтрация только тех, которые больше или равны 30 секундам
                $videos = $videos->get()->filter(function ($video) {
                    $videoPath = Storage::disk('public')->path($video->video_path);
                    $duration = $this->getVideoDuration($videoPath);
                    return $duration <= 30;
                });

        return view('video.shortsvideouser', ['videos' => $videos]);
    }
        private function getVideoDuration($videoPath)
        {
            $getID3 = new getID3;
            $fileInfo = $getID3->analyze($videoPath);
            return $fileInfo['playtime_seconds'];
        }




    public function like(Request $request, $id)
    {
        $video = Video::findOrFail($id);

        if (!$video->likes()->where('user_id', auth()->id())->exists()) {
            $like = new Like([
                'user_id' => auth()->id(),
                'statement_id' => null,
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
