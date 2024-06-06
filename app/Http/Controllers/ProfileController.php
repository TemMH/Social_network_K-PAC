<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Category;
use App\Models\User;
use App\Models\Statement;
use App\Models\Video;
use App\Models\Comment;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function UserProfile($id)
    {
        $categories = Category::all();

        $user = User::findOrFail($id);
        $statements = Statement::where('user_id', $id)->whereDoesntHave('bans')->orderByDesc('created_at')->get();
        $videos = Video::where('user_id', $id)->whereDoesntHave('bans')->orderByDesc('created_at')->get();

        return view('profile.profileuser', ['categories' => $categories,'user' => $user, 'videos' => $videos, 'statements' => $statements, 'users' => [$user]]);
    }


    // STATEMENTS
    public function allstatementuserviewed(Request $request, $id)
    {
        $categories = Category::all();
        $user = User::findOrFail($id);


        $category = $request->input('category');
        $userId = Auth::id();

        $statements = Statement::where('statements.user_id', $id)
        ->select('statements.*') //выбор всех столбцов
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


        return view('news.allstatementuser', compact('user','statements', 'categories'));

    }

    public function allstatementusernewforuser(Request $request, $id)
    {
        $categories = Category::all();
        $category = $request->input('category');
        $userId = Auth::id();
        $user = User::findOrFail($id);
    
        $statements = Statement::where('statements.user_id', $id)
        ->select('statements.*')
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
    
        return view('news.allstatementuser', compact('user','statements', 'categories'));
    }
    

    public function allstatementuserpopular(Request $request, $id)
    {
        $categories = Category::all();
        $category = $request->input('category');
        $user = User::findOrFail($id);
    
        $statements = Statement::where('user_id', $id)
        ->whereDoesntHave('bans')
            ->withCount('likes', 'comments', 'views');
    
        if ($category) {
            $statements->where('statements.category_id', $category);
        }
    
        $statements = $statements->orderByDesc('views_count')
            ->get();
    
        return view('news.allstatementuser', compact('user','statements', 'categories'));
    }
    

    public function allstatementusertrend(Request $request, $id)
    {

        $categories = Category::all();
        $category = $request->input('category');
        $user = User::findOrFail($id);
    
        $statements = Statement::where('user_id', $id)
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
    
        return view('news.allstatementuser', compact('user','statements', 'categories'));
    }
    

    public function allstatementusernew(Request $request, $id)
    {

        $categories = Category::all();

        $category = $request->input('category');
        $user = User::findOrFail($id);

        $statements = Statement::where('user_id', $id)
        ->whereDoesntHave('bans')
            ->withCount('likes', 'comments', 'views')
            ->orderByDesc('created_at');


            if ($category) {
                $statements->where('statements.category_id', $category);
            }

        $statements = $statements->get();
        return view('news.allstatementuser', compact('user','statements', 'categories'));

    }


//VIDEOS
    public function ProfileUserVideos($id)
    {
        $user = User::findOrFail($id);
        $videos = Video::where('user_id', $id)
        ->whereDoesntHave('bans')
        ->withCount('likes','comments','views')->get();

        return view('profile.profileuservideos', ['user' => $user, 'videos' => $videos, 'users' => [$user]]);
    }



    public function allvideouserviewed(Request $request, $id)
    {
        $categories = Category::all();

        $user = User::findOrFail($id);


        $category = $request->input('category');

        $userId = Auth::id();

        $videos = Video::where('videos.user_id', $id)
        ->select('videos.*') //выбор всех столбцов
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

        return view('video.allvideouser', compact('user', 'videos', 'categories'));
    }

    public function allvideousernewforuser(Request $request, $id)
    {
        $categories = Category::all();



        $category = $request->input('category');
        $userId = Auth::id();
        $user = User::findOrFail($id);


        $videos = Video::where('videos.user_id', $id)
        ->select('videos.*') //выбор всех столбцов
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
        return view('video.allvideouser', compact('user', 'videos', 'categories'));
    }

    public function allvideouserpopular(Request $request, $id)
    {
        $categories = Category::all();



        $category = $request->input('category');
        $user = User::findOrFail($id);


        $videos = Video::where('user_id', $id)
        ->whereDoesntHave('bans')
        ->withCount('likes', 'comments', 'views');
    
        if ($category) {
            $videos->where('videos.category_id', $category);
        }
    
        $videos = $videos->orderByDesc('views_count')
            ->get();
        return view('video.allvideouser', compact('user', 'videos', 'categories'));
    }

    public function allvideousertrend(Request $request, $id)
    {
        $categories = Category::all();
        $user = User::findOrFail($id);


        $category = $request->input('category');

        $videos = Video::where('user_id', $id)
        ->whereDoesntHave('bans')
            ->withCount('likes', 'comments', 'views')
            ->with(['likes', 'views']);
    
        if ($category) {
            $videos->where('videos.category_id', $category);
        }
    
        $videos = $videos->get()
            ->sortByDesc(function ($videos) {
                // Если просмотры = 0 отнести этот видеоматериал вниз
                if ($videos->views_count == 0) {
                    return -1;
                }
    
                return $videos->likes_count / $videos->views_count;
            });

        return view('video.allvideouser', compact('user', 'videos', 'categories'));

    }

    public function allvideousernew(Request $request, $id)
    {
        $categories = Category::all();



        $category = $request->input('category');
        $user = User::findOrFail($id);

        $videos = Video::where('user_id', $id)
        ->whereDoesntHave('bans')
            ->withCount('likes', 'comments', 'views')
            ->orderByDesc('created_at');


            if ($category) {
                $videos->where('videos.category_id', $category);
            }

        $videos = $videos->get();
        return view('video.allvideouser', compact('user', 'videos', 'categories'));
    }






    public function getAllUsers()
    {
        $users = User::where('id', '!=', auth()->user()->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
    
        return view('alluser', compact('users'));
    }
    


    public function showAvatarForm()
    {
        return view('profileuser'); 
    }

    public function confirmPermission()
    {

        $user = auth()->user();


        if ($user) {

            $user->permission = 'enabled';
            $user->save();


            return view('/dashboard');
        }


        return redirect()->back()->with('error', 'User not found');
    }


    public function updateAvatar(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    
        $user = auth()->user();
    
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = 'avatar_' . time() . '.' . $avatar->getClientOriginalExtension();
            $path = $avatar->storeAs('avatars', $avatarName, 'public'); 
            
            $user->avatar = 'avatars/' . $avatarName;         
            $user->save();
    
            return redirect()->back()->with('success', 'Аватар успешно обновлен!');
        }
    
        return redirect()->back()->with('error', 'Не удалось обновить аватар!');
    }
    
    
    

    public function updateCondition(Request $request)
    {
        $user = auth()->user();

        $user->condition = $request->input('condition');
        $user->save();

        return back()->with('success', 'Условие профиля успешно обновлено');
    }
    
    

    
    

}
