<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Statement;
use App\Models\User;
use App\Models\Ban;
use App\Models\Complaint;
use App\Models\Comment;

use Illuminate\Support\Facades\DB;


class ManagerController extends Controller
{


    public function index()
    {
        
        // От 3-х по 1 причине

        $videoComplaint = Complaint::whereNotNull('video_id')
        ->where('status','pending')
        ->select('video_id', DB::raw('count(*) as total'))
        ->leftJoin('reasons', 'complaints.reason_id', '=', 'reasons.id')
        ->select('video_id', DB::raw('count(*) as total'), 'reasons.id as reason_id')
        ->groupBy('video_id', 'reason_id')
        ->having('total', '>=', 3)
        ->orderByDesc('total')
        ->with('video')
        ->first();
    
    

        // dd($videoComplaint);
    
        $statementComplaint = Complaint::whereNotNull('statement_id')
        ->where('status','pending')
        ->select('statement_id', DB::raw('count(*) as total'))
        ->leftJoin('reasons', 'complaints.reason_id', '=', 'reasons.id')
        ->select('statement_id', DB::raw('count(*) as total'), 'reasons.id as reason_id')
        ->groupBy('statement_id', 'reason_id')
        ->having('total', '>=', 3)
        ->orderByDesc('total')
        ->with('statement')
        ->first();





    
        $userComplaint = Complaint::whereNotNull('user_id')
        ->where('status','pending')
        ->select('user_id', DB::raw('count(*) as total'))
        ->leftJoin('reasons', 'complaints.reason_id', '=', 'reasons.id')
        ->select('user_id', DB::raw('count(*) as total'), 'reasons.id as reason_id')
        ->groupBy('user_id', 'reason_id')
        ->having('total', '>=', 3)
        ->orderByDesc('total')
        ->with('user')
        ->first();
    
        $reports = [
            'video_complaint' => $videoComplaint,
            'statement_complaint' => $statementComplaint,
            'user_complaint' => $userComplaint,
        ];

    
        return view('admin.reports', compact('reports','videoComplaint','statementComplaint','userComplaint'));
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
    


}
