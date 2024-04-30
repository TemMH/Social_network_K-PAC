<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Statement;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Video;
use Illuminate\Http\Request;
// use Illuminate\View\View;
use App\Models\View;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;

class StatementController extends Controller
{
    // public function create(): View
    // {
    //     return view('/allstatementuser');
    // }


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
                'status' => 'true',
                'category' => $request->category,
                'photo_path' => 'photos/' . $photoName,
            ]);

            $statements = $user->statements()->get();

            return view('news.mystatement', ['statements' => $statements])->with('success', 'Статья успешно загружена!');
        }

        return back()->with('error', 'Ошибка при загрузке фото');
    }






    public function like(Request $request, $id)
    {
        $statement = Statement::findOrFail($id);

        if (!$statement->likes()->where('user_id', auth()->id())->exists()) {
            $like = new Like(['user_id' => auth()->id()]);
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
            ->withCount('views','likes')
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

    public function deleteComment($statementId, $commentId)
    {
        $statement = Statement::findOrFail($statementId);
        $comment = Comment::findOrFail($commentId);


        if ($comment->statement_id !== $statement->id) {
            abort(403, 'Этот комментарий не принадлежит указанной заявке.');
        }


        $comment->delete();

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
            <button type="submit">♡</button>
        <?php
        } else {
        ?>
            <button type="submit">
                <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M19.3 5.71002C18.841 5.24601 18.2943 4.87797 17.6917 4.62731C17.0891 4.37666 16.4426 4.2484 15.79 4.25002C15.1373 4.2484 14.4909 4.37666 13.8883 4.62731C13.2857 4.87797 12.739 5.24601 12.28 5.71002L12 6.00002L11.72 5.72001C10.7917 4.79182 9.53273 4.27037 8.22 4.27037C6.90726 4.27037 5.64829 4.79182 4.72 5.72001C3.80386 6.65466 3.29071 7.91125 3.29071 9.22002C3.29071 10.5288 3.80386 11.7854 4.72 12.72L11.49 19.51C11.6306 19.6505 11.8212 19.7294 12.02 19.7294C12.2187 19.7294 12.4094 19.6505 12.55 19.51L19.32 12.72C20.2365 11.7823 20.7479 10.5221 20.7442 9.21092C20.7405 7.89973 20.2218 6.64248 19.3 5.71002Z" fill="#777777"></path>
                    </g>
                </svg>
            </button>
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



    public function delete($id)
    {
        $statement = Statement::find($id);


        if (auth()->user()->role !== 'Admin') {
            Session::flash('error', 'У вас нет прав на удаление этой записи');
            return redirect()->back();
        }

        $statement->delete();


        return redirect()->back();
    }

    public function autocompletestatement(Request $request)
    {
        $searchTerm = $request->input('search');

        $statements = Statement::where('status', 'true')
            ->where('title', 'LIKE', '%' . $searchTerm . '%')
            ->with('user')
            ->withCount('likes','views','comments')
            ->limit(3)
            ->get();


        $base_url = url('/storage/');

        return response()->json([
            'statements' => $statements,

            // 'videos' => $videos, 'users' => $users , 

            'base_url' => $base_url
        ]);
    }


    public function autocompletevideo(Request $request)
    {
        $searchTerm = $request->input('search');

        $videos = Video::where('status', 'true')
            ->where('title', 'LIKE', '%' . $searchTerm . '%')
            ->with('user')
            ->withCount('likes','views','comments')
            ->limit(3)
            ->get();

        $base_url = url('/storage/');

        return response()->json(['videos' => $videos,  'base_url' => $base_url]);
    }

    public function autocompleteuser(Request $request)
    {
        $searchTerm = $request->input('search');

        $users = User::where('permission', 'new')
            ->where('name', 'LIKE', '%' . $searchTerm . '%')
            ->limit(3)
            ->get();

        $base_url = url('/storage/');

        return response()->json(['users' => $users, 'base_url' => $base_url]);
    }
}
