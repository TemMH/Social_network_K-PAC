<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Like;
use App\Models\Category;
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
use Laracasts\Flash\Flash;
use getID3;


class VideoController extends Controller
{

    public function create(Request $request){
        $categories = Category::all();

        return view('video.newvideo',compact('categories'));
        
    }

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
                'category_id' => $request->category,
                'video_path' => 'videos/' . $videoName,
                'thumbnail_path' => 'thumbnails/' . $thumbnailName,
            ]);

            $videos = $user->videos()->get();


            Flash::success('
            
            <div class="flash-success">
            <div class="flsh-title">
                K-PAC
            </div>
            <div class="flash-message">
            Видеоматериал успешно загружено!
            </div>
            </div>'
        
        );


            return back();
        }

    Flash::error('Ошибка при загрузке видео или превью');

        return back();
    }





    public function addComment(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $video->addComment($request->input('comment'));

        return redirect()->back();
    }







    public function allvideouser(Request $request)
    {
        $categories = Category::all();
        $category = $request->input('category');
        $userId = Auth::id();
    
        $trendvideos = Video::query()
            ->withCount('likes', 'comments', 'views')
            ->with(['likes', 'views'])
            ->whereDoesntHave('bans')
            ->when($category, function ($query, $category) {
                return $query->where('videos.category_id', $category);
            })
            ->get()
            ->sortByDesc(function ($video) {
                if ($video->views_count == 0) {
                    return -1;
                }
                return $video->likes_count / $video->views_count;
            })
            ->take(4);
    
        $popularvideos = Video::query()
            ->withCount('likes', 'comments', 'views')
            ->whereDoesntHave('bans')
            ->when($category, function ($query, $category) {
                return $query->where('videos.category_id', $category);
            })
            ->orderByDesc('views_count')
            ->limit(4)
            ->get();
    
        $newforuservideos = Video::select('videos.*')
            ->leftJoin('views', function ($join) use ($userId) {
                $join->on('videos.id', '=', 'views.video_id')
                    ->where('views.user_id', '=', $userId);
            })
            ->whereNull('views.id')
            ->whereDoesntHave('bans')
            ->when($category, function ($query, $category) {
                return $query->where('videos.category_id', $category);
            })
            ->withCount('likes', 'comments', 'views')
            ->limit(4)
            ->get();
    
        $newvideos = Video::query()
            ->withCount('likes', 'comments', 'views')
            ->whereDoesntHave('bans')
            ->when($category, function ($query, $category) {
                return $query->where('videos.category_id', $category);
            })
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();
    
        $viewedrvideos = Video::select('videos.*')
            ->join('views', function ($join) use ($userId) {
                $join->on('videos.id', '=', 'views.video_id')
                    ->where('views.user_id', '=', $userId);
            })
            ->whereDoesntHave('bans')
            ->when($category, function ($query, $category) {
                return $query->where('videos.category_id', $category);
            })
            ->withCount('likes', 'comments', 'views')
            ->orderBy('views.created_at', 'desc')
            ->limit(4)
            ->get();
    
        return view('video.mainallvideouser', compact('trendvideos', 'popularvideos', 'newforuservideos', 'newvideos', 'viewedrvideos', 'categories'));
    }
    


    

    public function allvideouserviewed(Request $request)
    {
        $categories = Category::all();



        $category = $request->input('category');

        $userId = Auth::id();

        $videos = Video::select('videos.*') //выбор всех столбцов
        ->join('views', function ($join) use ($userId) { // анонимная функция $join  для установления связи между таблицами + при объединении передаем $userId внутрь анонимной функции
            $join->on('videos.id', '=', 'views.video_id') // объединить id с video_id 
                 ->where('views.user_id', '=', $userId);
        })
        ->whereDoesntHave('bans')
        ->withCount('likes', 'comments', 'views');


        if ($category) {
            $videos->where('videos.category_id', $category);
        }
    
        $videos = $videos->orderBy('views.created_at', 'desc')
            ->get();

        return view('video.allvideouser', compact('videos', 'categories'));
    }

    public function allvideousernewforuser(Request $request)
    {
        $categories = Category::all();



        $category = $request->input('category');
        $userId = Auth::id();


        $videos = Video::select('videos.*') //выбор всех столбцов
            ->leftJoin('views', function ($join) use ($userId) {  // анонимная функция $join  для установления связи между таблицами + при объединении передаем $userId внутрь анонимной функции
                $join->on('videos.id', '=', 'views.video_id') // объединить id с video_id 
                    ->where('views.user_id', '=', $userId);
            })
            ->whereDoesntHave('bans')
            ->whereNull('views.id');
    
        if ($category) {
            $videos->where('videos.category_id', $category);
        }
    
        $videos = $videos->withCount('likes', 'comments', 'views')
            ->get();
        return view('video.allvideouser', compact('videos', 'categories'));
    }

    public function allvideouserpopular(Request $request)
    {
        $categories = Category::all();



        $category = $request->input('category');


        $videos = Video::query()
        ->whereDoesntHave('bans')
        ->withCount('likes', 'comments', 'views');
    
        if ($category) {
            $videos->where('videos.category_id', $category);
        }
    
        $videos = $videos->orderByDesc('views_count')
            ->get();
        return view('video.allvideouser', compact('videos', 'categories'));
    }

    public function allvideousertrend(Request $request)
    {
        $categories = Category::all();


        $category = $request->input('category');

        $videos = Video::query()
        ->whereDoesntHave('bans')
            ->withCount('likes', 'comments', 'views')
            ->with(['likes', 'views']);
    
        if ($category) {
            $videos->where('videos.category_id', $category);
        }
    
        $videos = $videos->get()
            ->sortByDesc(function ($videos) {
                // Если просмотры = 0 отнести этот фотоматериал вниз
                if ($videos->views_count == 0) {
                    return -1;
                }
    
                return $videos->likes_count / $videos->views_count;
            });

        return view('video.allvideouser', compact('videos', 'categories'));

    }

    public function allvideousernew(Request $request)
    {
        $categories = Category::all();



        $category = $request->input('category');

        $videos = Video::query()
        ->whereDoesntHave('bans')
            ->withCount('likes', 'comments', 'views')
            ->orderByDesc('created_at');


            if ($category) {
                $videos->where('videos.category_id', $category);
            }

        $videos = $videos->get();
        return view('video.allvideouser', compact('videos', 'categories'));
    }



    

    public function show($id)
    {
        $trendvideos = Video::query()
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


    public function allshortsvideouser(Request $request)
    {
        $userId = Auth::id();

        $videos = Video::select('videos.*')
            ->leftJoin('views', function ($join) use ($userId) {
                $join->on('videos.id', '=', 'views.video_id')
                    ->where('views.user_id', '=', $userId);
            })
            ->whereDoesntHave('bans')
            ->whereNull('views.id');



        // Получение длительности видео и фильтрация только тех, которые равны <= 30 секундам
        $videos = $videos->get()->filter(function ($video) {
            $videoPath = Storage::disk('public')->path($video->video_path); // Путь к видеофайлу в хранилище
            $duration = $this->getVideoDuration($videoPath);
            return $duration <= 30;
        });


        return view('video.shortsvideouser', ['videos' => $videos]);
    }


    public function allshortsvideouserviewed(Request $request)
    {

        $userId = Auth::id();

        $viewedVideoIds = View::where('user_id', $userId)->pluck('video_id')->all();

        $videos = Video::query()
            ->whereIn('id', $viewedVideoIds)
            ->whereDoesntHave('bans')
            ->withCount('likes');

                // Получение длительности видео и фильтрация только тех, которые равны <= 30 секундам
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

    return response()->json(['success' => true]);
}

public function unlike(Request $request, $id)
{
    $video = Video::findOrFail($id);
    $video->likes()->where('user_id', auth()->id())->delete();

    return response()->json(['success' => true]);
}

}
