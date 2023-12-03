<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Zayavka;
use App\Models\Friendship;
use Illuminate\Http\Request;

class myZayavkaController extends Controller
{
    //
    public function myzayavka()
    {
        $zayavkas = Zayavka::where('user_id', auth()->id())
            ->withCount('likes')
            ->get();
    
        return view('news.myzayavka', ['zayavkas' => $zayavkas]);
    }
    

    public function allzayavka(User $user)
    {

        $zayavkas = Zayavka::orderBy('created_at', 'desc')->get();
        return view('news.allzayavka', ['zayavkas' => $zayavkas]);
    }


    public function allzayavkauser(Request $request)
    {
        $sort = $request->input('sortirovka');

        $zayavkas = Zayavka::where('status', 'true')->withCount('likes');


        switch ($sort) {
            case 'old':
                $zayavkas->orderBy('created_at', 'asc');
                break;
            case 'popular':
                $zayavkas->withCount('likes')->orderByDesc('likes_count');
                break;
            case 'recent':
            default:
                $zayavkas->orderBy('created_at', 'desc');
                break;
        }

        $zayavkas = $zayavkas->get();

        return view('news.allzayavkauser', ['zayavkas' => $zayavkas]);
    }


    public function update(Request $request, $id)
    {


        $zayavka = Zayavka::find($id);
        $zayavka->status = $request->status;
        $zayavka->save();
        $zayavkas = Zayavka::orderBy('created_at', 'desc')->get();
        return view('news.allzayavka', ['zayavkas' => $zayavkas]);
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

        Zayavka::where('user_id', $id)->delete();

        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('success', 'Пользователь успешно удален');
    }




    public function sortMethod(Request $request)
    {
        $category = $request->input('category');
        $sort = $request->input('sortirovka');

        $zayavkas = Zayavka::withCount('likes')->where('status', 'true');

        if ($category && $category !== 'all') {
            $zayavkas->where('category', $category);
        }

        switch ($sort) {
            case 'old':
                $zayavkas->orderBy('created_at', 'asc');
                break;
            case 'popular':
                $zayavkas->orderByDesc('likes_count');
                break;
            case 'recent':
            default:
                $zayavkas->orderBy('created_at', 'desc');
                break;
        }

        $zayavkas = $zayavkas->get();

        return view('news.allzayavkauser', ['zayavkas' => $zayavkas, 'category' => $category]);
    }


    public function mysortMethod(Request $request)
    {

        $category = $request->input('category');
        $sort = $request->input('sortirovka');


        $zayavkas = Zayavka::where('user_id', auth()->id())
            ->withCount('likes');

        if ($category && $category !== 'all') {
            $zayavkas->where('category', $category);
        }

        switch ($sort) {
            case 'old':
                $zayavkas->orderBy('created_at', 'asc');
                break;
            case 'popular':
                $zayavkas->orderByDesc('likes_count');
                break;
            case 'recent':
            default:
                $zayavkas->orderBy('created_at', 'desc');
                break;
        }

        $zayavkas = $zayavkas->get();

        return view('news.myzayavka', ['zayavkas' => $zayavkas]);
    }




    

    public function edit($id)
    {
        $zayavka = Zayavka::findOrFail($id);
        return view('edit_zayavka', ['zayavka' => $zayavka]);
    }
    


    
    public function updatetest(Request $request, $id)
    {
        $zayavka = Zayavka::findOrFail($id);
        $zayavka->zagolovok = $request->input('zagolovok');
        $zayavka->description = $request->input('description');
        $zayavka->category = $request->input('category');
        $zayavka->save();
    
        return redirect()->route('myzayavka')->with('success', 'Заявка успешно обновлена');
    }


}
