<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Statement;
use App\Models\Like;
use App\Models\Comment;
use App\Models\User;
use App\Models\View;
use App\Models\Complaint;
use App\Models\Friendship;
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

    

    public function update_video(Request $request, $videoId)
    {
        $video = Video::findOrFail($videoId);
    
        $video->complaints()->update(['status' => $request->edit_status]);
    
        return redirect()->route('reports')->with('success', 'Статус жалоб успешно обновлен');
    }

    public function update_statement(Request $request, $statementId)
    {
        $statement = Statement::findOrFail($statementId);
    
        $statement->complaints()->update(['status' => $request->edit_status]);
    
        return redirect()->route('reports')->with('success', 'Статус жалоб успешно обновлен');
    }

    public function update_user(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
    
        $user->complaints()->update(['status' => $request->edit_status]);
    
        return redirect()->route('reports')->with('success', 'Статус жалоб успешно обновлен');
    }




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
            abort(403, 'Этот комментарий не принадлежит указанной заявке.');
        }


        $comment->delete();

        return redirect()->back();
    }
    



    public function deleteStatement(Request $request, Statement $statement)
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'У вас нет прав на удаление этой записи');
        }

        $statement->delete();

        return back();
    }

    public function deleteVideo(Request $request, Video $video)
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'У вас нет прав на удаление этого видео');
        }

        $video->delete();

        return back();
    }

    public function deleteUser(Request $request, User $user)
    {

        if (auth()->user()->role !== 'Admin') {
            abort(403, 'У вас нет прав на удаление этого видео');
        }


        $user->delete();

        return back();
    }



}
