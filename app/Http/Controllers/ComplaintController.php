<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Statement;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Friendship;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Complaint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;


class ComplaintController extends Controller
{

    public function index()
    {
        $videoComplaint = Complaint::whereNotNull('video_id')
            ->where('status', 'new')
            ->select('video_id', DB::raw('count(*) as total'), 'reason')
            ->having('total', '>=', 3)
            ->groupBy('video_id', 'reason')
            ->orderByDesc('total')
            ->with('video')
            ->first();
    
        $statementComplaint = Complaint::whereNotNull('statement_id')
            ->where('status', 'new')
            ->select('statement_id', DB::raw('count(*) as total'), 'reason')
            ->having('total', '>=', 3)
            ->groupBy('statement_id', 'reason')
            ->orderByDesc('total')
            ->with('statement')
            ->first();
    
        $userComplaint = Complaint::whereNotNull('user_id')
            ->where('status', 'new')
            ->select('user_id', DB::raw('count(*) as total'), 'reason')
            ->having('total', '>=', 3)
            ->groupBy('user_id', 'reason')
            ->orderByDesc('total')
            ->with('user')
            ->first();
    
        $reports = [
            'video_complaint' => $videoComplaint,
            'statement_complaint' => $statementComplaint,
            'user_complaint' => $userComplaint,
        ];
    
        return view('admin.reports', compact('reports'));
    }

    public function storevideocomplaint(Request $request, $id)
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

    public function storeusercomplaint(Request $request, $id)
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

    public function storestatementcomplaint(Request $request, $id)
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

}
