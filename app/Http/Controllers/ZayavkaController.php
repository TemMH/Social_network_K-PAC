<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\zayavka;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class ZayavkaController extends Controller
{
    public function create(): View
    {
        return view('/allzayavkauser');
    }
    public function store(Request $request)
    {
        $request->validate([
            'zagolovok' => 'required|string|max:50',
            'description' => 'required|string|max:255',
        ]);


        Zayavka::create([

            'name' => auth()->user()->name,
            'zagolovok' => $request->zagolovok,
            'user_id' =>  auth()->id(),
            'description' => $request->description,
            'status' => 'new',
            'category'=> $request->category,
        ]);

        $zayavkas = Zayavka::where('user_id', auth()->id())->get();

        return view('news.myzayavka', ['zayavkas' => $zayavkas]);
    }


    public function like(Request $request, $id)
    {
        $zayavka = Zayavka::findOrFail($id);

        if (!$zayavka->likes()->where('user_id', auth()->id())->exists()) {
            $like = new Like(['user_id' => auth()->id()]);
            $zayavka->likes()->save($like);
        }

        return redirect()->back();
    }

    public function unlike(Request $request, $id)
    {
        $zayavka = Zayavka::findOrFail($id);
        $zayavka->likes()->where('user_id', auth()->id())->delete();

        return redirect()->back();
    }


    public function show($id)
    {
        
        $zayavka = Zayavka::with('comments.user')->findOrFail($id);
    
        return view('news.zayavkauser', ['zayavka' => $zayavka]);
    }

    
    public function addComment(Request $request, $id)
    {
        $zayavka = Zayavka::findOrFail($id);
        $zayavka->addComment($request->input('comment'));
    
        return redirect()->back();
    }

    public function deleteComment($zayavkaId, $commentId)
{
    $zayavka = Zayavka::findOrFail($zayavkaId);
    $comment = Comment::findOrFail($commentId);


    if ($comment->zayavka_id !== $zayavka->id) {
        abort(403, 'Этот комментарий не принадлежит указанной заявке.');
    }


    $comment->delete();

    return redirect()->back();
}


    public function delete($id)
    {
        $zayavka = Zayavka::find($id);
    
    
        if (auth()->user()->role !== 'Admin') {
            Session::flash('error', 'У вас нет прав на удаление этой записи');
            return redirect()->back();
        }
    
        $zayavka->delete();
    

        return redirect()->back();
    }

    public function autocomplete(Request $request)
    {
        $searchTerm = $request->input('search');
    
        $zayavkas = Zayavka::where('status', 'true')
            ->where('zagolovok', 'LIKE', '%' . $searchTerm . '%')
            ->select('id', 'zagolovok')
            ->limit(5)
            ->get();
    
        return response()->json(['zayavkas' => $zayavkas]);
    }
    
    


}

