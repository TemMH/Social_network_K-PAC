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
            ->where('status', 'unlock')
            ->select('video_id', DB::raw('count(*) as total'), 'reason')
            ->groupBy('video_id', 'reason')
            ->orderByDesc('total')
            ->with('video')
            ->first();
    
        $statementComplaint = Complaint::whereNotNull('statement_id')
            ->where('status', 'unlock')
            ->select('statement_id', DB::raw('count(*) as total'), 'reason')
            ->groupBy('statement_id', 'reason')
            ->orderByDesc('total')
            ->with('statement')
            ->first();
    
        $userComplaint = Complaint::whereNotNull('user_id')
            ->where('status', 'unlock')
            ->select('user_id', DB::raw('count(*) as total'), 'reason')
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
            'status' => 'unlock',
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
            'status' => 'unlock',
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
            'status' => 'unlock',
            'video_id' => null,
            'statement_id' => $id,
            'user_id' => null,
        ]);

        $complaint->sender_id = $user->id;

        $complaint->save();

        return redirect()->back();
    }
}
