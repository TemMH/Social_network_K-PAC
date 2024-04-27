<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\myStatementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatementController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\DialogController;
use App\Http\Controllers\FriendfeedController;
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



Route::get('/newstatement', function () {
    return view('news.newstatement');
})->middleware(['auth', 'verified'])->name('newstatement');

Route::get('/allstatement', function () {
    return view('news.allstatement');
})->middleware(['auth', 'verified'])->name('allstatement');

Route::get('/allstatementuser', function () {
    return view('news.allstatementuser');
})->middleware(['auth', 'verified'])->name('allstatementuser');

Route::get('/statementuser', function () {
    return view('news.statementuser');
})->middleware(['auth', 'verified'])->name('statementuser');





Route::post('/newstatement', [StatementController::class, 'store'])->name('createstatement');

Route::get('/mystatement', [myStatementController::class, 'mystatement'])->name('mystatement')->middleware(['auth', 'verified']);

Route::get('/allstatement', [myStatementController::class, 'allstatement'])->name('allstatement')->middleware(['auth', 'verified']);

Route::post('/allstatement/{id}', [myStatementController::class, 'updatenews'])->name('statuseditnews');

Route::delete('/statement/delete/{id}', [StatementController::class, 'delete'])->name('statement.delete');

Route::post('/statement/{id}/like', [StatementController::class, 'like'])->name('statement.like');

Route::delete('/statement/{id}/unlike', [StatementController::class, 'unlike'])->name('statement.unlike');

Route::post('/statement/{id}/complaint', [ComplaintController::class, 'storestatementcomplaint'])->name('statement.complaint');

Route::get('/statementuser/{id}', [StatementController::class, 'show'])->name('statementuser');

Route::get('/allstatementuser', [myStatementController::class, 'allstatementuser'])->name('allstatementuser')->middleware(['auth', 'verified']);

Route::post('/statement/{id}/comment', [StatementController::class, 'addComment'])->name('statement.comment');

Route::delete('/statement/{statementId}/comment/{commentId}', [StatementController::class, 'deleteComment'])->name('statement.comment.delete');

// Route::get('/sort', [myStatementController::class, 'sortMethod'])->name('sort');
// Route::get('/mysort', [myStatementController::class, 'mysortMethod'])->name('mysort');

Route::get('/statement/{id}/edit', [myStatementController::class, 'edit'])->name('statement.edit');

Route::put('/statement/{id}/updatetest', [myStatementController::class, 'updatetest'])->name('statement.updatetest');

// Route::get('statement', [StatementController::class, 'create'])->name('statement');



Route::get('/statement/{id}/details', [StatementController::class, 'getStatementDetails'])->name('statement.details');




// Video

Route::get('/allvideouser', function () {
    return view('video.allvideouser');
})->middleware(['auth', 'verified'])->name('allvideouser');


Route::get('/allvideo', function () {
    return view('video.allvideo');
})->middleware(['auth', 'verified'])->name('allvideo');

Route::get('/newvideo', function () {
    return view('video.newvideo');
})->middleware(['auth', 'verified'])->name('newvideo');

Route::get('/myvideo', function () {
    return view('video.myvideo');
})->middleware(['auth', 'verified'])->name('myvideo');

Route::get('/videouser', function () {
    return view('video.videouser');
})->middleware(['auth', 'verified'])->name('videouser');

Route::get('/allshortsvideouser', function () {
    return view('video.allshortsvideouser');
})->middleware(['auth', 'verified'])->name('allshortsvideouser');

Route::post('/newvideo', [VideoController::class, 'store'])->name('createvideo');

Route::get('/allvideouser', [VideoController::class, 'allvideouser'])->name('allvideouser')->middleware(['auth', 'verified']);

Route::get('/allvideo', [VideoController::class, 'allvideo'])->name('allvideo')->middleware(['auth', 'verified']);
Route::post('/allvideo/{id}', [VideoController::class, 'updatevideo'])->name('statuseditvideo');

Route::post('/video/{id}/like', [VideoController::class, 'like'])->name('video.like');

Route::post('/video/{id}/complaint', [ComplaintController::class, 'storevideocomplaint'])->name('video.complaint');

Route::delete('/video/{id}/unlike', [VideoController::class, 'unlike'])->name('video.unlike');

Route::get('/myvideo', [VideoController::class, 'myvideo'])->name('myvideo')->middleware(['auth', 'verified']);

Route::delete('/video/delete/{id}', [VideoController::class, 'delete'])->name('video.delete');

Route::get('/videouser/{id}', [VideoController::class, 'show'])->name('videouser');

Route::get('/shortsvideouser', [VideoController::class, 'allshortsvideouser'])->name('allshortsvideouser')->middleware(['auth', 'verified']);

Route::get('/shortsvideouser/{id}', [VideoController::class, 'showshorts'])->name('shortsvideouser');

Route::post('/video/{id}/comment', [VideoController::class, 'addComment'])->name('video.comment');

Route::delete('/video/{videoId}/comment/{commentId}', [VideoController::class, 'deleteComment'])->name('video.comment.delete');

Route::delete('/video/delete/{id}', [VideoController::class, 'delete'])->name('video.delete');

Route::get('/sendVideoToFriend/{postId}/{friendId}', [DialogController::class, 'sendVideoToFriend'])
    ->name('sendVideoToFriend');


    Route::get('/sendPostToFriend/{postId}/{friendId}', [DialogController::class, 'sendPostToFriend'])->name('sendPostToFriend');

// Store

Route::get('/allstoreuser', function () {
    return view('store.allstoreuser');
})->middleware(['auth', 'verified'])->name('allstoreuser');

Route::get('/messenger', function () {
    return view('messenger.messenger');
})->middleware(['auth', 'verified'])->name('messenger');


// FriendFeed

Route::get('/friendfeeduser', function () {
    return view('friendfeed.friendfeeduser');
})->middleware(['auth', 'verified'])->name('friendfeeduser');


Route::get('/friendfeeduser', [FriendfeedController::class, 'friendfeeduser'])->name('friendfeeduser')->middleware(['auth', 'verified']);



// Profileuser

Route::get('/profileuser', function () {
    return view('profile.profileuser');
})->middleware(['auth', 'verified'])->name('profileuser');

Route::get('/profileuserstatements', function () {
    return view('profile.profileuserstatements');
})->middleware(['auth', 'verified'])->name('profileuserstatements');

Route::get('/profileuservideos', function () {
    return view('profile.profileuservideos');
})->middleware(['auth', 'verified'])->name('profileuservideos');



// Route::get('/profileuser', [ProfileController::class, 'MyProfile'])->name('profileuser')->middleware(['auth', 'verified']);

Route::get('/profileuser/{id}', [ProfileController::class, 'UserProfile'])->name('profile.profileuser')->middleware(['auth', 'verified']);

Route::get('/profileuserstatements/{id}', [ProfileController::class, 'ProfileUserStatements'])->name('profile.profileuserstatements')->middleware(['auth', 'verified']);

Route::get('/profileuservideos/{id}', [ProfileController::class, 'ProfileUserVideos'])->name('profile.profileuservideos')->middleware(['auth', 'verified']);

Route::post('/user/{id}/complaint', [ComplaintController::class, 'storeusercomplaint'])->name('user.complaint');


// Admin

Route::get('/reports', function () {
    return view('admin.reports');
})->middleware(['auth', 'verified'])->name('reports');


//Complaint

Route::get('/reports', [ComplaintController::class, 'index'])->name('reports');

Route::put('/complaiment/{complaiment}', [ComplaintController::class, 'edit'])->name('complaiment.edit');


// Other


Route::get('/dialog', function () {
    return view('dialog');
})->middleware(['auth', 'verified'])->name('dialog');

Route::get('/confirmation', function () {
    return view('confirmation');
})->middleware(['auth', 'verified'])->name('confirmation');

Route::get('/messages', function () {
    return view('messages');
})->middleware(['auth', 'verified'])->name('messages');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





Route::post('/alluser/{id}', [myStatementController::class, 'updatepermission'])->name('permissionedit');

Route::delete('/deleteUser/{id}', [myStatementController::class, 'deleteUser'])->name('deleteUser');















Route::post('/update-condition', [ProfileController::class, 'updateCondition'])->name('update-condition');




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







Route::get('/allusers', [ProfileController::class, 'getAllUsers'])->name('allUsers');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile/avatar', [ProfileController::class, 'showAvatarForm'])->name('avatar.edit');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
    Route::post('/confirmation', [ProfileController::class, 'confirmPermission'])->name('confirm.permission');


});


Route::get('/statement/autocomplete', [StatementController::class, 'autocompletestatement'])->name('statement.autocompletestatement');
Route::get('/video/autocomplete', [StatementController::class, 'autocompletevideo'])->name('video.autocompletevideo');
Route::get('/user/autocomplete', [StatementController::class, 'autocompleteuser'])->name('user.autocompleteuser');


Route::get('/usersort', [ProfileController::class, 'usersortMethod'])->name('usersort');


Route::middleware('auth')->group(function () {
    Route::get('/messenger', [DialogController::class, 'showMessenger'])->name('messenger');
    Route::get('/messenger/{userId}', [DialogController::class, 'show'])->name('messenger.show');
    Route::post('/messenger/{userId}/send', [DialogController::class, 'sendMessage'])->name('message.send');
    Route::get('/messages/{userId}',[DialogController::class, 'getMessages'])->name('messages.get');
});




require __DIR__ . '/auth.php';




//k.pac.news23@gmail.com
//Пароль приложений    swdw dlmi moue wrpy




// Проверка погоды и валюты доллар/евро

//  <div class="Weather">

//     @php
        
//         $apiKey = '8523a49e9e99f6888cc6d56ee02f0214';

        
//         $city = 'Иркутске';

       
//         $url = 'https://api.openweathermap.org/data/2.5/weather?q=Irkutsk,ru&APPID=8523a49e9e99f6888cc6d56ee02f0214';

        
//         $response = file_get_contents($url);

       
//         $weatherData = json_decode($response, true);


//         $temperatureKelvin = $weatherData['main']['temp'];

//         $temperatureCelsius = $temperatureKelvin - 273.15;
//     @endphp

//     <p class="txt_2">{{ $temperatureCelsius }} &#8451; В {{ $city }}</p>
// </div>

// <div class="money">
//     <div class="test1">
//         @php
         
//             $url = 'https://api.exchangerate-api.com/v4/latest/USD';

          
//             $response = file_get_contents($url);

     
//             $exchangeRates = json_decode($response, true);

         
//             $rubRate = $exchangeRates['rates']['RUB'];

//         @endphp


//         <p class="txt_2">$ {{ $rubRate }}</p>

//     </div>
//     <div class="test2">
//         <p class="txt_2">ㅤ|ㅤ</p>
//     </div>
//     <div class="test3">
//         @php
       
//             $url = 'https://api.exchangerate-api.com/v4/latest/EUR';


//             $response = file_get_contents($url);

//             $exchangeRates = json_decode($response, true);


//             $rubRate = $exchangeRates['rates']['RUB'];

//         @endphp


//         <p class="txt_2">€ {{ $rubRate }}</p>
//     </div>

// </div> 