<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\myStatementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatementController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\DialogController;
use App\Http\Controllers\ViewsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FriendfeedController;
use Illuminate\Routing\ViewController;
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
    return redirect('all.statement.user.trend');
})->middleware(['auth', 'verified'])->name('allstatementuser');

Route::get('/statementuser', function () {
    return view('news.statementuser');
})->middleware(['auth', 'verified'])->name('statementuser');





Route::post('/newstatement', [StatementController::class, 'store'])->name('createstatement');

Route::get('/mystatement', [myStatementController::class, 'mystatement'])->name('mystatement')->middleware(['auth', 'verified']);



Route::post('/allstatement/{id}', [myStatementController::class, 'updatenews'])->name('statuseditnews');



Route::post('/statement/{id}/like', [StatementController::class, 'like'])->name('statement.like');

Route::delete('/statement/{id}/unlike', [StatementController::class, 'unlike'])->name('statement.unlike');

Route::post('/statement/{id}/complaint', [ComplaintController::class, 'storestatementcomplaint'])->name('statement.complaint');

Route::get('/statementuser/{id}', [StatementController::class, 'show'])->name('statementuser');




// Route::get('/allstatementuser', [myStatementController::class, 'allstatementuser'])->name('allstatementuser')->middleware(['auth', 'verified']);



Route::get('/allstatementuser/trend', [myStatementController::class, 'allstatementusertrend'])->name('all.statement.user.trend')->middleware(['auth', 'verified']);

Route::get('/allstatementuser/popular', [myStatementController::class, 'allstatementuserpopular'])->name('all.statement.user.popular')->middleware(['auth', 'verified']);

Route::get('/allstatementuser/newforuser', [myStatementController::class, 'allstatementusernewforuser'])->name('all.statement.user.newforuser')->middleware(['auth', 'verified']);

Route::get('/allstatementuser/viewed', [myStatementController::class, 'allstatementuserviewed'])->name('all.statement.user.viewed')->middleware(['auth', 'verified']);

Route::get('/allstatementuser/new', [myStatementController::class, 'allstatementusernew'])->name('all.statement.user.new')->middleware(['auth', 'verified']);



Route::post('/statement/{id}/comment', [StatementController::class, 'addComment'])->name('statement.comment');



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

Route::get('/allvideouser', [VideoController::class, 'allvideouser'])->name('main.all.video.user')->middleware(['auth', 'verified']);



Route::get('/allvideouser/trend', [VideoController::class, 'allvideousertrend'])->name('all.video.user.trend')->middleware(['auth', 'verified']);

Route::get('/allvideouser/popular', [VideoController::class, 'allvideouserpopular'])->name('all.video.user.popular')->middleware(['auth', 'verified']);

Route::get('/allvideouser/newforuser', [VideoController::class, 'allvideousernewforuser'])->name('all.video.user.newforuser')->middleware(['auth', 'verified']);

Route::get('/allvideouser/viewed', [VideoController::class, 'allvideouserviewed'])->name('all.video.user.viewed')->middleware(['auth', 'verified']);

Route::get('/allvideouser/new', [VideoController::class, 'allvideousernew'])->name('all.video.user.new')->middleware(['auth', 'verified']);






Route::post('/allvideo/{id}', [VideoController::class, 'updatevideo'])->name('statuseditvideo');

Route::post('/video/{id}/like', [VideoController::class, 'like'])->name('video.like');

Route::delete('/video/{id}/unlike', [VideoController::class, 'unlike'])->name('video.unlike');

Route::post('/video/{id}/complaint', [ComplaintController::class, 'storevideocomplaint'])->name('video.complaint');

Route::get('/myvideo', [VideoController::class, 'myvideo'])->name('myvideo')->middleware(['auth', 'verified']);


Route::get('/videouser/{id}', [VideoController::class, 'show'])->name('videouser');

Route::get('/allshortsvideouser', [VideoController::class, 'allshortsvideouser'])->name('allshortsvideouser')->middleware(['auth', 'verified']);

Route::get('/allshortsvideouser/viewed', [VideoController::class, 'allshortsvideouserviewed'])->name('all.shortsvideo.user.viewed')->middleware(['auth', 'verified']);

Route::get('/shortsvideouser/{id}', [VideoController::class, 'showshorts'])->name('shortsvideouser');

Route::post('/video/{id}/comment', [VideoController::class, 'addComment'])->name('video.comment');







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

Route::post('/friendfeeduserVideo/{id}/comment', [FriendfeedController::class, 'addCommentVideo'])->name('friendfeed.video.comment');

Route::post('/friendfeeduserStatement/{id}/comment', [FriendfeedController::class, 'addCommentStatement'])->name('friendfeed.statement.comment');


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
    return redirect('/adminnavigation/reports'); //Убрать
})->middleware(['auth', 'verified']);

// Route::get('/adminnavigation', [AdminController::class, 'index'])->name('admin.navigation')->middleware(['auth', 'verified']);

Route::get('/adminnavigation/reports', [ComplaintController::class, 'index'])->name('reports');

Route::get('/adminnavigation/users', [AdminController::class, 'index'])->name('admin.navigation.users')->middleware(['auth', 'verified']);

Route::get('/adminnavigation/videos', [AdminController::class, 'index'])->name('admin.navigation.videos')->middleware(['auth', 'verified']);

Route::get('/adminnavigation/statements', [AdminController::class, 'index'])->name('admin.navigation.statements')->middleware(['auth', 'verified']);

// AdminComplaint

Route::post('/adminnavigation/statement/{statement}', [AdminController::class, 'post_statement_complaint'])->name('complaint.post.statement');
Route::post('/adminnavigation/video/{video}', [AdminController::class, 'post_video_complaint'])->name('complaint.post.video');
Route::post('/adminnavigation/user/{user}', [AdminController::class, 'post_user_complaint'])->name('complaint.post.user');




Route::put('/complaint/video/{video}', [AdminController::class, 'update_video_complaint'])->name('complaint.update.video');

Route::put('/complaint/statement/{statement}', [AdminController::class, 'update_statement_complaint'])->name('complaint.update.statement');

Route::put('/complaint/user/{user}', [AdminController::class, 'update_user_complaint'])->name('complaint.update.user');


// AdminDelete

Route::delete('/statement/delete/{statement}', [AdminController::class, 'deleteStatement'])->name('admin.statement.delete');

Route::delete('/statement/{statementId}/comment/{commentId}', [AdminController::class, 'deleteStatementComment'])->name('admin.statement.comment.delete');


Route::delete('/video/delete/{video}', [AdminController::class, 'deleteVideo'])->name('admin.video.delete');

Route::delete('/video/{videoId}/comment/{commentId}', [AdminController::class, 'deleteVideoComment'])->name('admin.video.comment.delete');


Route::delete('/profileuser/delete/{user}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');

//Complaint

Route::put('/complaint/video/{video}', [AdminController::class, 'update_video_complaint'])->name('complaint.update.video');

Route::put('/complaint/statement/{statement}', [AdminController::class, 'update_statement_complaint'])->name('complaint.update.statement');

Route::put('/complaint/user/{user}', [AdminController::class, 'update_user_complaint'])->name('complaint.update.user');


// View


Route::post('/view/statement/{statementId}', [ViewsController::class, 'view_statement'])->name('view.statement');

Route::post('/view/video/{videoId}', [ViewsController::class, 'view_video'])->name('view.video');

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
    Route::post('/reject-friend-request/{id}', [FriendshipController::class, 'rejectFriendRequest'])->name('reject-friend-request');
    Route::get('/friends', [FriendshipController::class, 'rejectFriendRequest'])->name('friends-list');

    Route::delete('/friend/{friend}', [FriendshipController::class, 'removeFriend'])->name('friend.remove');
});










Route::middleware(['auth'])->group(function () {
    Route::get('/profile/avatar', [ProfileController::class, 'showAvatarForm'])->name('avatar.edit');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
    Route::post('/confirmation', [ProfileController::class, 'confirmPermission'])->name('confirm.permission');


});


Route::get('/statement/autocomplete', [StatementController::class, 'autocompletestatement'])->name('statement.autocompletestatement');
Route::get('/video/autocomplete', [StatementController::class, 'autocompletevideo'])->name('video.autocompletevideo');
Route::get('/user/autocomplete', [StatementController::class, 'autocompleteuser'])->name('user.autocompleteuser');


Route::get('/usersort', [ProfileController::class, 'usersortMethod'])->name('usersort');


// Send message

Route::get('/sendVideoToFriend/{postId}/{friendId}', [DialogController::class, 'sendVideoToFriend'])->name('sendVideoToFriend');


Route::get('/sendPostToFriend/{postId}/{friendId}', [DialogController::class, 'sendPostToFriend'])->name('sendPostToFriend');

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