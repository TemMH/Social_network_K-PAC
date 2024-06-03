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
        $statements = Statement::where('user_id', $id)->get();
        $videos = Video::where('user_id', $id)->get();

        return view('profile.profileuser', ['categories' => $categories,'user' => $user, 'videos' => $videos, 'statements' => $statements, 'users' => [$user]]);
    }

    public function ProfileUserStatements(Request $request, $id)
    {
        $categories = Category::all();

        $category = $request->input('category');

        $user = User::findOrFail($id);
        $statements = Statement::where('user_id', $id)
        ->whereDoesntHave('bans')
        ->withCount('likes','comments','views');

        
        if ($category) {
            $statements->where('statements.category', $category);
        }

        $statements = $statements->get();

        return view('profile.profileuserstatements', compact('user','statements', 'categories'));
    }


    public function ProfileUserVideos($id)
    {
        $user = User::findOrFail($id);
        $videos = Video::where('user_id', $id)
        ->whereDoesntHave('bans')
        ->withCount('likes','comments','views')->get();

        return view('profile.profileuservideos', ['user' => $user, 'videos' => $videos, 'users' => [$user]]);
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
