<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatementController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\DialogController;
use App\Http\Controllers\ViewsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\AutocompleteController;
use App\Http\Controllers\FriendfeedController;
use Illuminate\Routing\ViewController;
use Illuminate\Support\Facades\Route;
use Psy\TabCompletion\AutoCompleter;

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



// AutoComplete
Route::middleware(['auth', 'verified', 'ban'])->controller(AutocompleteController::class)->group(function () {

    Route::get('/statement/autocomplete', 'autocompletestatement')->name('statement.autocompletestatement');
    Route::get('/video/autocomplete',  'autocompletevideo')->name('video.autocompletevideo');
    Route::get('/user/autocomplete', 'autocompleteuser')->name('user.autocompleteuser');

    Route::get('/dialog/autocomplete', 'autocompletedialog')->name('dialog.autocompletedialog');



});


// Statement
Route::middleware(['auth', 'verified', 'ban'])->controller(StatementController::class)->group(function () {


    Route::get('/allstatementuser/trend',   'allstatementusertrend')->name('all.statement.user.trend');

    Route::get('/allstatementuser/popular',   'allstatementuserpopular')->name('all.statement.user.popular');

    Route::get('/allstatementuser/newforuser',   'allstatementusernewforuser')->name('all.statement.user.newforuser');

    Route::get('/allstatementuser/viewed',  'allstatementuserviewed')->name('all.statement.user.viewed');

    Route::get('/allstatementuser/new', 'allstatementusernew')->name('all.statement.user.new');



    Route::post('/newstatement/create',   'store')->name('createstatement');

    Route::get('/newstatement', 'create')->name('newstatement');


    Route::post('/statement/{id}/like',   'like')->name('statement.like');

    Route::delete('/statement/{id}/unlike',   'unlike')->name('statement.unlike');

    Route::get('/statementuser/{id}',   'show')->name('statementuser')->middleware('banstatement');

    Route::post('/statement/{id}/comment',   'addComment')->name('statement.comment');


    Route::get('/statement/{id}/details',   'getStatementDetails')->name('statement.details')->middleware('banstatement');
});


// Complaint
Route::middleware(['auth', 'verified', 'ban'])->controller(ComplaintController::class)->group(function () {


    Route::post('/statement/{id}/complaint',  'storestatementcomplaint')->name('statement.complaint');

    Route::post('/video/{id}/complaint',  'storevideocomplaint')->name('video.complaint');

    Route::post('/user/{id}/complaint',  'storeusercomplaint')->name('user.complaint');

    Route::get('/reasons', 'reasons')->name('reasons');

});


// Video
Route::middleware(['auth', 'verified', 'ban'])->controller(VideoController::class)->group(function () {

    Route::post('/newvideo',  'store')->name('createvideo');

    Route::get('/allvideouser',  'allvideouser')->name('main.all.video.user');


    Route::get('/newvideo', 'create')->name('newvideo');


    Route::get('/allvideouser/trend',  'allvideousertrend')->name('all.video.user.trend');

    Route::get('/allvideouser/popular',  'allvideouserpopular')->name('all.video.user.popular');

    Route::get('/allvideouser/newforuser',  'allvideousernewforuser')->name('all.video.user.newforuser');

    Route::get('/allvideouser/viewed',  'allvideouserviewed')->name('all.video.user.viewed');

    Route::get('/allvideouser/new',  'allvideousernew')->name('all.video.user.new');



    Route::post('/allvideo/{id}',  'updatevideo')->name('statuseditvideo');


    //VideoLike
    Route::post('/video/{id}/like',  'like')->name('video.like');

    Route::delete('/video/{id}/unlike',  'unlike')->name('video.unlike');


    Route::get('/videouser/{id}',  'show')->name('videouser')->middleware('banvideo');

    Route::get('/allshortsvideouser',  'allshortsvideouser')->name('allshortsvideouser');

    Route::get('/allshortsvideouser/viewed',  'allshortsvideouserviewed')->name('all.shortsvideo.user.viewed');

    Route::get('/shortsvideouser/{id}',  'showshorts')->name('shortsvideouser');

    Route::post('/video/{id}/comment',  'addComment')->name('video.comment');
});


// FriendFeed
Route::middleware(['auth', 'verified', 'ban'])->controller(FriendfeedController::class)->group(function () {

    Route::get('/friendfeeduser',  'friendfeeduser')->name('friendfeeduser');

    Route::post('/friendfeeduserVideo/{id}/comment',  'addCommentVideo')->name('friendfeed.video.comment');

    Route::post('/friendfeeduserStatement/{id}/comment',  'addCommentStatement')->name('friendfeed.statement.comment');
});


// Profileuser
Route::middleware(['auth', 'verified', 'ban', 'ban'])->controller(ProfileController::class)->group(function () {

    // Route::get('/profileuser', 'MyProfile'])->name('profileuser')->middleware(['auth', 'verified']);

    Route::get('/profileuser/{id}',  'UserProfile')->name('profile.profileuser');

    Route::get('/profileuserstatements/{id}', 'ProfileUserStatements')->name('profile.profileuserstatements');

    Route::get('/profileuservideos/{id}', 'ProfileUserVideos')->name('profile.profileuservideos');

    Route::get('/profile',  'edit')->name('profile.edit');
    Route::patch('/profile',  'update')->name('profile.update');
    Route::delete('/profile',  'destroy')->name('profile.destroy');


    // Route::post('/update-condition', 'updateCondition')->name('update-condition');


    Route::post('/profile/avatar',  'updateAvatar')->name('avatar.update');
    Route::post('/confirmation',  'confirmPermission')->name('confirm.permission');
});





// View
Route::middleware(['auth', 'verified', 'ban'])->controller(ViewsController::class)->group(function () {

    Route::post('/view/statement/{statementId}',  'view_statement')->name('view.statement');

    Route::post('/view/video/{videoId}',  'view_video')->name('view.video');
});


//FriendRequest
Route::middleware(['auth', 'verified', 'ban'])->controller(FriendshipController::class)->group(function () {


    Route::get('/friend-requests', 'friendRequests')->name('friend-requests');
    Route::post('/accept-friend-request/{id}',  'acceptFriendRequest')->name('accept-friend-request');
    Route::post('/reject-friend-request/{id}',  'rejectFriendRequest')->name('reject-friend-request');
    Route::get('/friends', 'rejectFriendRequest')->name('friends-list');



    Route::post('/send-friend-request/{user}', 'sendFriendRequest')->name('send-friend-request');
    Route::get('/friend-requests', 'showFriendRequests')->name('friend-requests');


    Route::delete('/friend/{friend}', 'removeFriend')->name('friend.remove');
});


// Messenger
Route::middleware(['auth', 'verified', 'ban'])->controller(DialogController::class)->group(function () {

    Route::get('/messenger', 'showMessenger')->name('messenger');
    Route::get('/messenger/{id}', 'chat')->name('messenger.chat');
    Route::post('/messenger/{userId}/send', 'sendMessage')->name('message.send');
    Route::get('/messages/{userId}', 'getMessages')->name('messages.get');



    Route::get('/sendVideoToFriend/{postId}/{friendId}', 'sendVideoToFriend')->name('sendVideoToFriend');

    Route::get('/sendPostToFriend/{postId}/{friendId}', 'sendPostToFriend')->name('sendPostToFriend');
});



// Admin
Route::middleware(['auth', 'verified', 'admin', 'ban'])->controller(AdminController::class)->group(function () {

    //AdminNavigation

    Route::get('/adminnavigation/users', 'index')->name('admin.navigation.users');

    Route::get('/adminnavigation/videos', 'index')->name('admin.navigation.videos');

    Route::get('/adminnavigation/statements', 'index')->name('admin.navigation.statements');

    Route::get('/adminnavigation/create', 'create')->name('admin.navigation.create');


    //AdminNavigationBlocked
    Route::get('/adminnavigation/users/blocked', 'blockedUsers')->name('admin.navigation.users.blocked');
    Route::get('/adminnavigation/statements/blocked', 'blockedStatements')->name('admin.navigation.statements.blocked');
    Route::get('/adminnavigation/videos/blocked', 'blockedVideos')->name('admin.navigation.videos.blocked');

    //AdminNavigationUnblocked
    Route::get('/adminnavigation/users/unblocked', 'unblockedUsers')->name('admin.navigation.users.unblocked');
    Route::get('/adminnavigation/statements/unblocked', 'unblockedStatements')->name('admin.navigation.statements.unblocked');
    Route::get('/adminnavigation/videos/unblocked', 'unblockedVideos')->name('admin.navigation.videos.unblocked');

    //AdminCreate

    Route::post('/adminnavigation/create/category', 'createCategory')->name('admin.navigation.create.category');
    Route::post('/adminnavigation/create/reason', 'createReason')->name('admin.navigation.create.reason');

    //AdminBan
    Route::post('/adminnavigation/statement/{statement}', 'post_statement_complaint')->name('complaint.post.statement');
    Route::post('/adminnavigation/video/{video}', 'post_video_complaint')->name('complaint.post.video');
    Route::post('/adminnavigation/user/{user}', 'post_user_complaint')->name('complaint.post.user');



    //AdminDeleteBan
    Route::post('/adminnavigation/user/deleteban/{user}', 'delete_ban_user')->name('admin.delete.ban.user');
    Route::post('/adminnavigation/video/deleteban/{video}', 'delete_ban_video')->name('admin.delete.ban.video');
    Route::post('/adminnavigation/statement/deleteban/{statement}', 'delete_ban_statement')->name('admin.delete.ban.statement');


    // AdminDelete
    Route::delete('/statement/delete/{statement}', 'deleteStatement')->name('admin.statement.delete');



    Route::delete('/video/delete/{video}', 'deleteVideo')->name('admin.video.delete');



    Route::delete('/profileuser/delete/{user}', 'deleteUser')->name('admin.user.delete');

        //AdminSearch
        Route::get('/admin/autocomplete/user', 'autocomplete_admin_users')->name('admin.autocomplete.user');
        Route::get('/admin/autocomplete/statement', 'autocomplete_admin_statements')->name('admin.autocomplete.statement');
        Route::get('/admin/autocomplete/video', 'autocomplete_admin_videos')->name('admin.autocomplete.video');


    // Route::get('/adminnavigation' , 'index'])->name('admin.navigation')->middleware(['auth', 'verified']);


    Route::post('/adminnavigation/user/updaterole/{user}', 'update_user_role')->name('admin.update.role.user');


});


// MANAGER
Route::middleware(['auth', 'verified', 'manager', 'ban'])->controller(ManagerController::class)->group(function () {

    // MangerIndex
    Route::get('/adminnavigation/reports',  'index')->name('reports');


    // MangerComplaint
    Route::put('/complaint/video/{video}', 'update_video_complaint')->name('complaint.update.video');

    Route::put('/complaint/statement/{statement}', 'update_statement_complaint')->name('complaint.update.statement');

    Route::put('/complaint/user/{user}', 'update_user_complaint')->name('complaint.update.user');


    //ManagerDeleteComment
    Route::delete('/video/{videoId}/comment/{commentId}', 'deleteVideoComment')->name('admin.video.comment.delete');

    Route::delete('/statement/{statementId}/comment/{commentId}', 'deleteStatementComment')->name('admin.statement.comment.delete');


});




// Other


// Route::get('/dialog', function () {
//     return view('dialog');
// })->middleware(['auth', 'verified'])->name('dialog');

// Route::get('/confirmation', function () {
//     return view('confirmation');
// })->middleware(['auth', 'verified'])->name('confirmation');

// Route::get('/messages', function () {
//     return view('messages');
// })->middleware(['auth', 'verified'])->name('messages');

// Route::get('/allvideouser', function () {
//     return view('video.allvideouser');
// })->middleware(['auth', 'verified'])->name('allvideouser');

// Route::get('/allvideo', function () {
//     return view('video.allvideo');
// })->middleware(['auth', 'verified'])->name('allvideo');

// Route::get('/myvideo', function () {
//     return view('video.myvideo');
// })->middleware(['auth', 'verified'])->name('myvideo');

// Route::get('/videouser', function () {
//     return view('video.videouser');
// })->middleware(['auth', 'verified'])->name('videouser');

// Route::get('/allshortsvideouser', function () {
//     return view('video.allshortsvideouser');
// })->middleware(['auth', 'verified'])->name('allshortsvideouser');

// Route::get('/profileuser', function () {
//     return view('profile.profileuser');
// })->middleware(['auth', 'verified'])->name('profileuser');

// Route::get('/profileuserstatements', function () {
//     return view('profile.profileuserstatements');
// })->middleware(['auth', 'verified'])->name('profileuserstatements');

// Route::get('/friendfeeduser', function () {
//     return view('friendfeed.friendfeeduser');
// })->middleware(['auth', 'verified'])->name('friendfeeduser');

// Route::get('/allstatement', function () {
//     return view('news.allstatement');
// })->middleware(['auth', 'verified'])->name('allstatement');

// Route::get('/allstatementuser', function () {
//     return redirect('all.statement.user.trend');
// })->middleware(['auth', 'verified'])->name('allstatementuser');

// Route::get('/statementuser', function () {
//     return view('news.statementuser');
// })->middleware(['auth', 'verified'])->name('statementuser');



require __DIR__ . '/auth.php';




//k.pac.news23@gmail.com
//Пароль приложений    swdw dlmi moue wrpy
