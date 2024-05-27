<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Statement;
use App\Models\Comment;
use App\Models\User;
use App\Models\Complaint;
use App\Models\Category;
use App\Models\Reason;
use App\Models\Ban;


use Laracasts\Flash\Flash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $status = $request->input('status');
    
        $usersQuery = User::query();
        $videosQuery = Video::query();
        $statementsQuery = Statement::query();
    
        if ($status) {
            $usersQuery->whereHas('complaints', function ($query) use ($status) {
                $query->where('status', $status);
            });
            $videosQuery->whereHas('complaints', function ($query) use ($status) {
                $query->where('status', $status);
            });
            $statementsQuery->whereHas('complaints', function ($query) use ($status) {
                $query->where('status', $status);
            });
        }
    
        $users = $usersQuery->get();
        $videos = $videosQuery->get();
        $statements = $statementsQuery->get();

    
        return view('admin.adminnavigation', compact('users', 'videos', 'statements'));
    }


    //SEND COMPLAINT

    public function blockvideo(Request $request, $id)
    {
        $user = auth()->user();

        $complaint = new Complaint([
            'reason' => $request->reason,
            'status' => 'new',
            'video_id' => $id,
            'statement_id' => null,
            'user_id' => null,
        ]);

        $complaint->sender_id = $user->id;

        $complaint->save();

        return redirect()->back();
    }

    public function blockuser(Request $request, $id)
    {
        $user = auth()->user();

        $complaint = new Complaint([
            'reason' => $request->reason,
            'status' => 'new',
            'video_id' => null,
            'statement_id' => null,
            'user_id' => $id,
        ]);

        $complaint->sender_id = $user->id;

        $complaint->save();

        return redirect()->back();
    }

    public function blockstatement(Request $request, $id)
    {
        $user = auth()->user();

        $complaint = new Complaint([
            'reason' => $request->reason,
            'status' => 'new',
            'video_id' => null,
            'statement_id' => $id,
            'user_id' => null,
        ]);

        $complaint->sender_id = $user->id;

        $complaint->save();

        return redirect()->back();
    }

    

    // UPDATE STATUS BAN

    public function update_video_complaint(Request $request, $videoId)
    {
        $video = Video::findOrFail($videoId);


        $ban = new Ban([
            'sender_id' => auth()->user()->id,
            'reason_id' => $request->reason_id,
            'video_id' => $videoId,
            'statement_id' => null,
            'user_id' => null,
        ]);

        $ban -> save();

    
        $video->complaints()->update(['status' => $request->edit_status]);
    
        return redirect()->route('reports')->with('success', 'Статус жалоб успешно обновлен');
    }

    public function update_statement_complaint(Request $request, $statementId)
    {
        $statement = Statement::findOrFail($statementId);


        $ban = new Ban([
            'sender_id' => auth()->user()->id,
            'reason_id' => $request->reason_id,
            'video_id' => null,
            'statement_id' => $statementId,
            'user_id' => null,
        ]);

        $ban -> save();


    
        $statement->complaints()->update(['status' => $request->edit_status]);
    
        return redirect()->route('reports')->with('success', 'Статус жалоб успешно обновлен');
    }

    public function update_user_complaint(Request $request, $userId)
    {
        $user = User::findOrFail($userId);


        $ban = new Ban([
            'sender_id' => auth()->user()->id,
            'reason_id' => $request->reason_id,
            'video_id' => null,
            'statement_id' => null,
            'user_id' => $userId,
        ]);

        $ban -> save();
    
        $user->complaints()->update(['status' => $request->edit_status]);
    
        return redirect()->route('reports')->with('success', 'Статус жалоб успешно обновлен');
    }



// ADMIN BAN BLOCK


    public function post_statement_complaint(Request $request, Statement $statement){



        $ban = new Ban([
            'sender_id' => auth()->user()->id,
            'reason_id' => 1,
            'video_id' => null,
            'statement_id' => $statement->id,
            'user_id' => null,
        ]);

        $statement->complaints()->update(['status' => $request->edit_status]);


        $ban -> save();

        return redirect()->back();
    }


    public function post_video_complaint(Request $request, Video $video){

        $ban = new Ban([
            'sender_id' => auth()->user()->id,
            'reason_id' => 1,
            'video_id' => $video->id,
            'statement_id' => null,
            'user_id' => null,
        ]);


        $video->complaints()->update(['status' => $request->edit_status]);

        $ban -> save();

        return redirect()->back();
    }

public function post_user_complaint(Request $request, User $user){
    $ban = new Ban([
        'sender_id' => auth()->user()->id,
        'reason_id' => 1,
        'video_id' => null,
        'statement_id' => null,
        'user_id' => $user->id,
    ]);

    $user->complaints()->update(['status' => $request->edit_status]);

    $ban->save();

    return redirect()->back();
}




//DELETE COMMENT


    public function deleteStatementComment($statementId, $commentId)
    {
        $statement = Statement::findOrFail($statementId);
        $comment = Comment::findOrFail($commentId);


        if ($comment->statement_id !== $statement->id) {
            abort(403, 'Этот комментарий не принадлежит указанной заявке.');
        }


        $comment->delete();

        return redirect()->back();
    }

    public function deleteVideoComment($videoId, $commentId)
    {
        $video = Video::findOrFail($videoId);
        $comment = Comment::findOrFail($commentId);


        if ($comment->video_id !== $video->id) {
            abort(403, 'Этот комментарий не принадлежит указанному видео.');
        }


        $comment->delete();

        return redirect()->back();
    }
    





    //DELETE BLOCK

    public function deleteStatement(Request $request, Statement $statement)
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'У вас нет прав на удаление этого фотоматериала');
        }

        $statement->delete();

        return back();
    }

    public function deleteVideo(Request $request, Video $video)
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'У вас нет прав на удаление этого видеоматериала');
        }

        $video->delete();

        return back();
    }

    public function deleteUser(Request $request, User $user)
    {

        if (auth()->user()->role !== 'Admin') {
            abort(403, 'У вас нет прав на удаление этого пользователя');
        }


        $user->delete();

        return back();
    }



    //Create NEW


    
    public function create(){

        return view('admin.adminadd');

    }


    public function createCategory(Request $request){

        Category::create($request->all());


        Flash::success('
            
        <div class="flash-success">
        <div class="flsh-title">
            K-PAC
        </div>
        <div class="flash-message">
        Категория успешно создана!
        </div>
        </div>');

        return back();
    }

    
    public function createReason(Request $request){

        Reason::create($request->all());


        Flash::success('
            
        <div class="flash-success">
        <div class="flsh-title">
            K-PAC
        </div>
        <div class="flash-message">
        Причина успешно создана!
        </div>
        </div>');

        return back();
    }




}
