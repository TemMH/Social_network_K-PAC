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

class StatementController extends Controller
{
    public function create(): View
    {
        return view('/allstatementuser');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:255',
        ]);


        Statement::create([

            'name' => auth()->user()->name,
            'title' => $request->title,
            'user_id' =>  auth()->id(),
            'description' => $request->description,
            'status' => 'new',
            'category'=> $request->category,
        ]);

        $statements = Statement::where('user_id', auth()->id())->get();

        return view('news.mystatement', ['statements' => $statements]);
    }


    public function like(Request $request, $id)
    {
        $statement = Statement::findOrFail($id);

        if (!$statement->likes()->where('user_id', auth()->id())->exists()) {
            $like = new Like(['user_id' => auth()->id()]);
            $statement->likes()->save($like);
        }

        return redirect()->back();
    }

    public function unlike(Request $request, $id)
    {
        $statement = Statement::findOrFail($id);
        $statement->likes()->where('user_id', auth()->id())->delete();

        return redirect()->back();
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

