<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Statement;
use App\Models\Friendship;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class myStatementController extends Controller
{
    //
    public function mystatement(Request $request)
    {
        $category = $request->input('category');
        $sort = $request->input('sortirovka');

        $statements = Statement::where('user_id', auth()->id())
            ->withCount('likes');

        if ($category) {
            $statements->where('category', $category);
        }

        switch ($sort) {
            case 'old':
                $statements->orderBy('created_at', 'asc');
                break;
            case 'popular':
                $statements->withCount('likes')->orderByDesc('likes_count');
                break;
            case 'recent':
            default:
                $statements->orderBy('created_at', 'desc');
                break;
        }

        $statements = $statements->get();

        return view('news.mystatement', ['statements' => $statements]);
    }


    public function allstatement(User $user)
    {

        $statements = Statement::orderBy('created_at', 'desc')->get();
        return view('news.allstatement', ['statements' => $statements]);
    }


    public function allstatementuser(Request $request)
    {
        $category = $request->input('category');
        $sort = $request->input('sortirovka');
        $userId = Auth::id();


        $statements = Statement::select('statements.*') //выбор всех столбцов
            ->leftJoin('views', function ($join) use ($userId) {  // анонимная функция $join  для установления связи между таблицами + при объединении передаем $userId внутрь анонимной функции
                $join->on('statements.id', '=', 'views.statement_id') // объединить id с video_id 
                    ->where('views.user_id', '=', $userId);
            })
            ->whereNull('views.id')
            ->where('statements.status', 'true')
            ->withCount('likes', 'comments', 'views');
            

        if ($category) {
            $statements->where('statements.category', $category);
        }

        switch ($sort) {
            case 'old':
                $statements->orderBy('statements.created_at', 'asc');
                break;
            case 'popular':
                $statements->withCount('likes')->orderByDesc('likes_count');
                break;
            case 'recent':
            default:
                $statements->orderBy('statements.created_at', 'desc');
                break;
        }

        $statements = $statements->get();
        return view('news.allstatementuser', ['statements' => $statements]);
    }



    public function allstatementuserviewed(Request $request)
    {
        $category = $request->input('category');
        $sort = $request->input('sortirovka');
        $userId = Auth::id();

        $viewedStatementIds = View::where('user_id', $userId)->pluck('statement_id')->all();

        $statements = Statement::where('status', 'true')
            ->whereIn('id', $viewedStatementIds)
            ->withCount('likes', 'comments', 'views');

        if ($category) {
            $statements->where('category', $category);
        }

        switch ($sort) {
            case 'old':
                $statements->orderBy('created_at', 'asc');
                break;
            case 'popular':
                $statements->withCount('likes')->orderByDesc('likes_count');
                break;
            case 'recent':
            default:
                $statements->orderBy('created_at', 'desc');
                break;
        }

        $statements = $statements->get();

        return view('news.allstatementuser', ['statements' => $statements]);
    }

    public function updatenews(Request $request, $id)
    {


        $statement = Statement::find($id);
        $statement->status = $request->status;
        $statement->save();
        $statements = Statement::orderBy('created_at', 'desc')->get();
        return view('news.allstatement', ['statements' => $statements]);
    }


    public function updatepermission(Request $request, $id)
    {


        $user = User::find($id);
        $user->permission = $request->permission;
        $user->save();
        $user = User::orderBy('created_at', 'desc')->get();
        return view('news.alluser', ['users' => $user]);
    }

    public function deleteUser($id)
    {

        Friendship::where('sender_id', $id)->delete();

        Statement::where('user_id', $id)->delete();

        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('success', 'Пользователь успешно удален');
    }




    // public function sortMethod(Request $request)
    // {
    //     $category = $request->input('category');
    //     $sort = $request->input('sortirovka');

    //     $statements = Statement::withCount('likes')->where('status', 'true');

    //     if ($category && $category !== 'all') {
    //         $statements->where('category', $category);
    //     }

    //     switch ($sort) {
    //         case 'old':
    //             $statements->orderBy('created_at', 'asc');
    //             break;
    //         case 'popular':
    //             $statements->orderByDesc('likes_count');
    //             break;
    //         case 'recent':
    //         default:
    //             $statements->orderBy('created_at', 'desc');
    //             break;
    //     }

    //     $statements = $statements->get();

    //     return view('news.allstatementuser', ['statements' => $statements, 'category' => $category]);
    // }


    // public function mysortMethod(Request $request)
    // {

    //     $category = $request->input('category');
    //     $sort = $request->input('sortirovka');


    //     $statements = Statement::where('user_id', auth()->id())
    //         ->withCount('likes');

    //     if ($category && $category !== 'all') {
    //         $statements->where('category', $category);
    //     }

    //     switch ($sort) {
    //         case 'old':
    //             $statements->orderBy('created_at', 'asc');
    //             break;
    //         case 'popular':
    //             $statements->orderByDesc('likes_count');
    //             break;
    //         case 'recent':
    //         default:
    //             $statements->orderBy('created_at', 'desc');
    //             break;
    //     }

    //     $statements = $statements->get();

    //     return view('news.mystatement', ['statements' => $statements]);
    // }






    public function edit($id)
    {
        $statement = Statement::findOrFail($id);
        return view('edit_statement', ['statement' => $statement]);
    }




    public function updatetest(Request $request, $id)
    {
        $statement = Statement::findOrFail($id);
        $statement->title = $request->input('title');
        $statement->description = $request->input('description');
        $statement->category = $request->input('category');
        $statement->save();

        return redirect()->route('mystatement')->with('success', 'Заявка успешно обновлена');
    }
}
