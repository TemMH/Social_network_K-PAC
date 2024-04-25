<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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


    public function storevideocomplaint(Request $request, $id)
    {
        $user = auth()->user();
    
        $complaint = new Complaint([
            'reason' => 'test',
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
            'reason' => 'test',
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
