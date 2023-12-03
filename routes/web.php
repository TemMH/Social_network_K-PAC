<?php

use App\Http\Controllers\myZayavkaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ZayavkaController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\DialogController;


use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('/dashboard');
});


// News



Route::get('/newzayavka', function () {
    return view('news.newzayavka');
})->middleware(['auth', 'verified'])->name('newzayavka');

Route::get('/allzayavka', function () {
    return view('news.allzayavka');
})->middleware(['auth', 'verified'])->name('allzayavka');

Route::get('/allzayavkauser', function () {
    return view('news.allzayavkauser');
})->middleware(['auth', 'verified'])->name('allzayavkauser');

Route::get('/zayavkauser', function () {
    return view('news.zayavkauser');
})->middleware(['auth', 'verified'])->name('zayavkauser');





Route::post('/newzayavka', [ZayavkaController::class, 'store'])->name('test');

Route::get('/myzayavka', [myZayavkaController::class, 'myzayavka'])->name('myzayavka')->middleware(['auth', 'verified']);

Route::get('/allzayavka', [myZayavkaController::class, 'allzayavka'])->name('allzayavka')->middleware(['auth', 'verified']);

Route::post('/allzayavka/{id}', [myZayavkaController::class, 'update'])->name('statusedit');

Route::delete('/zayavka/delete/{id}', [ZayavkaController::class, 'delete'])->name('zayavka.delete');

Route::post('/zayavka/{id}/like', [ZayavkaController::class, 'like'])->name('zayavka.like');
Route::delete('/zayavka/{id}/unlike', [ZayavkaController::class, 'unlike'])->name('zayavka.unlike');

Route::get('/zayavkauser/{id}', [ZayavkaController::class, 'show'])->name('zayavkauser');

Route::get('/allzayavkauser', [myZayavkaController::class, 'allzayavkauser'])->name('allzayavkauser')->middleware(['auth', 'verified']);

Route::post('/zayavka/{id}/comment', [ZayavkaController::class, 'addComment'])->name('zayavka.comment');

Route::delete('/zayavka/{zayavkaId}/comment/{commentId}', [ZayavkaController::class, 'deleteComment'])->name('zayavka.comment.delete');

Route::get('/sort', [myZayavkaController::class, 'sortMethod'])->name('sort');
Route::get('/mysort', [myZayavkaController::class, 'mysortMethod'])->name('mysort');

Route::get('/zayavka/{id}/edit', [myZayavkaController::class, 'edit'])->name('zayavka.edit');

Route::put('/zayavka/{id}/updatetest', [myZayavkaController::class, 'updatetest'])->name('zayavka.updatetest');

Route::get('zayavka', [ZayavkaController::class, 'create'])->name('zayavka');



// Video

Route::get('/allvideouser', function () {
    return view('video.allvideouser');
})->middleware(['auth', 'verified'])->name('allvideouser');

Route::get('/newvideo', function () {
    return view('video.newvideo');
})->middleware(['auth', 'verified'])->name('newvideo');

Route::post('/newvideo', [VideoController::class, 'store'])->name('createvideo');


// Store

Route::get('/allstoreuser', function () {
    return view('store.allstoreuser');
})->middleware(['auth', 'verified'])->name('allstoreuser');






// Other

Route::get('/profileuser', function () {
    return view('profileuser');
})->middleware(['auth', 'verified'])->name('profileuser');

Route::get('/dialog', function () {
    return view('dialog');
})->middleware(['auth', 'verified'])->name('dialog');

Route::get('/confirmation', function () {
    return view('confirmation');
})->middleware(['auth', 'verified'])->name('confirmation');





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





Route::post('/alluser/{id}', [myZayavkaController::class, 'updatepermission'])->name('permissionedit');

Route::delete('/deleteUser/{id}', [myZayavkaController::class, 'deleteUser'])->name('deleteUser');















Route::post('/update-condition', [ProfileController::class, 'updateCondition'])->name('update-condition');


Route::get('/profileuser', [ProfileController::class, 'MyProfile'])->name('profileuser')->middleware(['auth', 'verified']);

Route::get('/profileuser/{id}', [ProfileController::class, 'UserProfile'])->name('profileuser.profile')->middleware(['auth', 'verified']);

Route::post('/send-friend-request/{user}', [FriendRequestController::class, 'sendFriendRequest'])
    ->name('send-friend-request')
    ->middleware(['auth']);

Route::get('/friend-requests', [FriendRequestController::class, 'showFriendRequests'])
    ->name('friend-requests')
    ->middleware(['auth']);




Route::middleware('auth')->group(function () {
    Route::get('/friend-requests', [FriendshipController::class, 'friendRequests'])->name('friend-requests');
    Route::post('/accept-friend-request/{id}', [FriendshipController::class, 'acceptFriendRequest'])->name('accept-friend-request');
    Route::delete('/reject-friend-request/{id}', [FriendshipController::class, 'rejectFriendRequest'])->name('reject-friend-request');
    Route::get('/friends', [FriendshipController::class, 'rejectFriendRequest'])->name('friends-list');

    Route::delete('/friend/{friend}', [FriendshipController::class, 'removeFriend'])->name('friend.remove');
});


Route::middleware('auth')->group(function () {
    Route::get('/dialog/{userId}', [DialogController::class, 'show'])->name('dialog.show');
    Route::post('/dialog/{userId}/send', [DialogController::class, 'sendMessage'])->name('dialog.send');
});


Route::get('/sendPostToFriend/{postId}/{friendId}', [DialogController::class, 'sendPostToFriend'])
    ->name('sendPostToFriend');

Route::get('/allusers', [ProfileController::class, 'getAllUsers'])->name('allUsers');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile/avatar', [ProfileController::class, 'showAvatarForm'])->name('avatar.edit');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
    Route::post('/confirmation', [ProfileController::class, 'confirmPermission'])->name('confirm.permission');


});


Route::get('/zayavka/autocomplete', [ZayavkaController::class, 'autocomplete'])->name('zayavka.autocomplete');


Route::get('/usersort', [ProfileController::class, 'usersortMethod'])->name('usersort');





require __DIR__ . '/auth.php';




//k.pac.news23@gmail.com
//Пароль приложений    swdw dlmi moue wrpy


//Проверка на какой странице сейчас находишься

//              @if(request()->is('myzayavka'))
//              <!-- Код элемента, который не нужно скрывать -->
//              @endif