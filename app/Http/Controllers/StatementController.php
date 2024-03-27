<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Statement;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\View\View;
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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        $statement = Statement::with('comments.user')->findOrFail($id);

        return view('news.statementuser', ['statement' => $statement]);
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
        $comments = Comment::where('statement_id', $id)->get();
        $user = Auth::user();
        $likeUrl = route('statement.like', ['id' => $statement->id]);
        $unlikeUrl = route('statement.unlike', ['id' => $statement->id]);
        $createcomment = route('statement.comment', ['id' => $statement->id]) ;
    
        ob_start();
        if (!$statement->likes()->where('user_id', auth()->id())->exists()) {
            ?>
            <button type="submit" class="novost_down_func_news">♡</button>
            <?php
        } else {
            ?>
            <button type="submit" class="novost_down_func_news">❤</button>
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

    public function autocomplete(Request $request)
    {
        $searchTerm = $request->input('search');

        $statements = Statement::where('status', 'true')
            ->where('title', 'LIKE', '%' . $searchTerm . '%')
            ->select('id', 'title')
            ->limit(5)
            ->get();

        return response()->json(['statements' => $statements]);
    }
}
