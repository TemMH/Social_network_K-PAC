<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Statement;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Video;
use App\Models\Message;
use Illuminate\Http\Request;
// use Illuminate\View\View;
use App\Models\View;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;

class StatementController extends Controller
{
    
    public function create(Request $request){
        $categories = Category::all();

        return view('news.newstatement', compact('categories'));
        
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $user = auth()->user();

        if ($request->hasFile('photo')) {
            $uploadedPhoto = $request->file('photo');
            $photoName = 'photo_' . time() . '.' . $uploadedPhoto->getClientOriginalExtension();
            $photoPath = $uploadedPhoto->storeAs('public/photos', $photoName);

            $statement = $user->statements()->create([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category,
                'photo_path' => 'photos/' . $photoName,
            ]);

            $statements = $user->statements()->get();

            return back()->with('success', 'Фотоматериал успешно загружен!');
        }

        return back()->with('error', 'Ошибка при загрузке фотоматериала');
    }






    public function like(Request $request, $id)
    {
        $statement = Statement::findOrFail($id);

        if (!$statement->likes()->where('user_id', auth()->id())->exists()) {
            $like = new Like([
                'user_id' => auth()->id(),
                'video_id' => null,
            ]);
            $statement->likes()->save($like);
        }

        return response()->json(['message' => 'Liked successfully', 'likes_count' => $statement->likes()->count()]);
    }


    public function unlike(Request $request, $id)
    {
        $statement = Statement::findOrFail($id);
        $statement->likes()->where('user_id', auth()->id())->delete();

        return response()->json(['message' => 'Unliked successfully', 'likes_count' => $statement->likes()->count()]);
    }




    public function show($id)
    {

        $statement = Statement::with('comments.user')
            ->with('complaints')
            
            ->withCount('views', 'likes')
            ->findOrFail($id);

        $existingView = View::where('user_id', Auth::id())
            ->where('statement_id', $statement->id)
            ->exists();

        if ($existingView) {
            return view('news.statementuser', compact('statement'));
        }

        $view = new View();
        $view->user_id = Auth::id();
        $view->statement_id = $statement->id;
        $view->save();

        return view('news.statementuser', compact('statement'));
    }


    public function addComment(Request $request, $id)
    {
        $statement = Statement::findOrFail($id);
        $statement->addComment($request->input('comment'));

        return redirect()->back();
    }



    public function getStatementDetails($id)
    {
        $statement = Statement::with('user')->findOrFail($id);
        $photoUrl = asset('storage/' . $statement->photo_path);
        $comments = Comment::with('user')->where('statement_id', $id)->get();
        $statementurl = route('statementuser', ['id' => $statement->id]);
        $user = Auth::user();

        $likeUrl = route('statement.like', ['id' => $statement->id]);
        $unlikeUrl = route('statement.unlike', ['id' => $statement->id]);

        $createcomment = route('statement.comment', ['id' => $statement->id]);
        $profileUrl = route('profile.profileuser', ['id' => $statement->user_id]);

        ob_start();
        if (!$statement->likes()->where('user_id', auth()->id())->exists()) {
            ?>
            <button type="submit" class="like-button" data-id="<?= $statement->id ?>"><svg class="like-icon" width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#777777"> <g id="SVGRepo_bgCarrier" stroke-width="0"></g> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g> <g id="SVGRepo_iconCarrier"> <path d="M12 19.7501C11.8012 19.7499 11.6105 19.6708 11.47 19.5301L4.70001 12.7401C3.78387 11.8054 3.27072 10.5488 3.27072 9.24006C3.27072 7.9313 3.78387 6.6747 4.70001 5.74006C5.6283 4.81186 6.88727 4.29042 8.20001 4.29042C9.51274 4.29042 10.7717 4.81186 11.7 5.74006L12 6.00006L12.28 5.72006C12.739 5.25606 13.2857 4.88801 13.8883 4.63736C14.4909 4.3867 15.1374 4.25845 15.79 4.26006C16.442 4.25714 17.088 4.38382 17.6906 4.63274C18.2931 4.88167 18.8402 5.24786 19.3 5.71006C20.2161 6.6447 20.7293 7.9013 20.7293 9.21006C20.7293 10.5188 20.2161 11.7754 19.3 12.7101L12.53 19.5001C12.463 19.5752 12.3815 19.636 12.2904 19.679C12.1994 19.7219 12.1006 19.7461 12 19.7501ZM8.21001 5.75006C7.75584 5.74675 7.30551 5.83342 6.885 6.00505C6.4645 6.17669 6.08215 6.42989 5.76001 6.75006C5.11088 7.40221 4.74646 8.28491 4.74646 9.20506C4.74646 10.1252 5.11088 11.0079 5.76001 11.6601L12 17.9401L18.23 11.6801C18.5526 11.3578 18.8086 10.9751 18.9832 10.5538C19.1578 10.1326 19.2477 9.68107 19.2477 9.22506C19.2477 8.76905 19.1578 8.31752 18.9832 7.89627C18.8086 7.47503 18.5526 7.09233 18.23 6.77006C17.9104 6.44929 17.5299 6.1956 17.1109 6.02387C16.6919 5.85215 16.2428 5.76586 15.79 5.77006C15.3358 5.76675 14.8855 5.85342 14.465 6.02505C14.0445 6.19669 13.6621 6.44989 13.34 6.77006L12.53 7.58006C12.3869 7.71581 12.1972 7.79149 12 7.79149C11.8028 7.79149 11.6131 7.71581 11.47 7.58006L10.66 6.77006C10.3395 6.44628 9.95791 6.18939 9.53733 6.01429C9.11675 5.83919 8.66558 5.74937 8.21001 5.75006Z" fill="#777777"></path> </g> </svg></button>
            <?php
        } else {
            ?>
            <button type="submit" class="unlike-button" data-id="<?= $statement->id ?>"><svg class="unlike-icon" width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <g id="SVGRepo_bgCarrier" stroke-width="0"></g> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g> <g id="SVGRepo_iconCarrier"> <path d="M19.3 5.71002C18.841 5.24601 18.2943 4.87797 17.6917 4.62731C17.0891 4.37666 16.4426 4.2484 15.79 4.25002C15.1373 4.2484 14.4909 4.37666 13.8883 4.62731C13.2857 4.87797 12.739 5.24601 12.28 5.71002L12 6.00002L11.72 5.72001C10.7917 4.79182 9.53273 4.27037 8.22 4.27037C6.90726 4.27037 5.64829 4.79182 4.72 5.72001C3.80386 6.65466 3.29071 7.91125 3.29071 9.22002C3.29071 10.5288 3.80386 11.7854 4.72 12.72L11.49 19.51C11.6306 19.6505 11.8212 19.7294 12.02 19.7294C12.2187 19.7294 12.4094 19.6505 12.55 19.51L19.32 12.72C20.2365 11.7823 20.7479 10.5221 20.7442 9.21092C20.7405 7.89973 20.2218 6.64248 19.3 5.71002Z" fill="#777777"></path> </g> </svg></button>
            <?php
        }
        $likeButtonHtml = ob_get_clean();


        return response()->json([
            'statement' => $statement,
            'user' => $user,
            'photo_url' => $photoUrl,
            'like_button_html' => $likeButtonHtml,
            'like_url' => $likeUrl,
            'unlike_url' => $unlikeUrl,
            'comments' => $comments,
            'createcomment' => $createcomment,
            'statementurl' => $statementurl,
            'profileUrl' => $profileUrl,
        ]);
    }











    
    public function allstatementuserviewed(Request $request)
    {
        $categories = Category::all();


        $category = $request->input('category');
        $userId = Auth::id();

        $statements = Statement::select('statements.*') //выбор всех столбцов
        ->join('views', function ($join) use ($userId) { // анонимная функция $join  для установления связи между таблицами + при объединении передаем $userId внутрь анонимной функции
            $join->on('statements.id', '=', 'views.statement_id') // объединить id с video_id 
                 ->where('views.user_id', '=', $userId);
        })
        ->whereDoesntHave('bans')
        ->withCount('likes', 'comments', 'views');


        if ($category) {
            $statements->where('statements.category_id', $category);
        }
    
        $statements = $statements->orderBy('views.created_at', 'desc')
            ->get();


        return view('news.allstatementuser', compact('statements', 'categories'));

    }

    public function allstatementusernewforuser(Request $request)
    {
        $categories = Category::all();
        $category = $request->input('category');
        $userId = Auth::id();
    
        $statements = Statement::select('statements.*') //выбор всех столбцов
            ->leftJoin('views', function ($join) use ($userId) {  
                $join->on('statements.id', '=', 'views.statement_id') 
                    ->where('views.user_id', '=', $userId);
            })
            ->whereDoesntHave('bans')
            ->whereNull('views.id');
    
        if ($category) {
            $statements->where('statements.category_id', $category);
        }
    
        $statements = $statements->withCount('likes', 'comments', 'views')
            ->get();
    
        return view('news.allstatementuser', compact('statements', 'categories'));
    }
    

    public function allstatementuserpopular(Request $request)
    {
        $categories = Category::all();
        $category = $request->input('category');
    
        $statements = Statement::query()
        ->whereDoesntHave('bans')
            ->withCount('likes', 'comments', 'views');
    
        if ($category) {
            $statements->where('statements.category_id', $category);
        }
    
        $statements = $statements->orderByDesc('views_count')
            ->get();
    
        return view('news.allstatementuser', compact('statements', 'categories'));
    }
    

    public function allstatementusertrend(Request $request)
    {
        $categories = Category::all();
        $category = $request->input('category');
    
        $statements = Statement::query()
        ->whereDoesntHave('bans')
            ->withCount('likes', 'comments', 'views')
            ->with(['likes', 'views']);
    
        if ($category) {
            $statements->where('statements.category_id', $category);
        }
    
        $statements = $statements->get()
            ->sortByDesc(function ($statement) {
                // Если просмотры = 0 отнести этот фотоматериал вниз
                if ($statement->views_count == 0) {
                    return -1;
                }
    
                return $statement->likes_count / $statement->views_count;
            });
    
        return view('news.allstatementuser', compact('statements', 'categories'));
    }
    

    public function allstatementusernew(Request $request)
    {

        $categories = Category::all();

        $category = $request->input('category');

        $statements = Statement::query()
        ->whereDoesntHave('bans')
            ->withCount('likes', 'comments', 'views')
            ->orderByDesc('created_at');


            if ($category) {
                $statements->where('statements.category_id', $category);
            }

        $statements = $statements->get();
        return view('news.allstatementuser', compact('statements', 'categories'));

    }
}
