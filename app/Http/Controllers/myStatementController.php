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



        $statements = $statements->get();
        return view('news.allstatementuser', ['statements' => $statements]);
    }





    public function allstatementuserviewed(Request $request)
    {
        $category = $request->input('category');
        $userId = Auth::id();

        $statements = Statement::select('statements.*') //выбор всех столбцов
        ->join('views', function ($join) use ($userId) { // анонимная функция $join  для установления связи между таблицами + при объединении передаем $userId внутрь анонимной функции
            $join->on('statements.id', '=', 'views.statement_id') // объединить id с video_id 
                 ->where('views.user_id', '=', $userId);
        })
        ->where('statements.status', 'true')
        ->withCount('likes', 'comments', 'views')
        ->orderBy('views.created_at', 'desc');
    
    

        if ($category) {
            $statements->where('category', $category);
        }


        $statements = $statements->get();

        return view('news.allstatementuser', ['statements' => $statements]);
    }

    public function allstatementusernewforuser(Request $request)
    {
        $category = $request->input('category');
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


        $statements = $statements->get();
        return view('news.allstatementuser', ['statements' => $statements]);
    }

    public function allstatementuserpopular(Request $request)
    {
        $category = $request->input('category');


        $statements = Statement::where('status', 'true')
            ->withCount('likes', 'comments', 'views')
            ->orderByDesc('views_count');



        if ($category) {
            $statements->where('statements.category', $category);
        }



        $statements = $statements->get();
        return view('news.allstatementuser', ['statements' => $statements]);
    }

    public function allstatementusertrend(Request $request)
    {
        $category = $request->input('category');

        $statements = Statement::where('status', 'true')
            ->withCount('likes', 'comments', 'views')
            ->with(['likes', 'views'])
            ->get()
            ->sortByDesc(function ($statement) {
                // Если просмотры = 0 отнести это заявление вниз
                if ($statement->views_count == 0) {
                    return -1;
                }

                return $statement->likes_count / $statement->views_count;
            });

        if ($category) {
            $statements = $statements->where('category', $category);
        }

        return view('news.allstatementuser', ['statements' => $statements]);
    }

    public function allstatementusernew(Request $request)
    {
        $category = $request->input('category');

        $statements = Statement::where('status', 'true')
            ->withCount('likes', 'comments', 'views')
            ->orderByDesc('created_at');


        if ($category) {
            $statements->where('statements.category', $category);
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
