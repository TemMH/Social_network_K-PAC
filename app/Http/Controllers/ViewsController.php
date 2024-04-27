<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Like;
use App\Models\Comment;
// use Illuminate\View\View;
use App\Models\View;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Complaint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;

class ViewsController extends Controller
{
    


    public function view_video(Request $request, $videoId)
    {

        $existingView = View::where('user_id', Auth::id())
        ->where('video_id', $videoId)
        ->exists();

    if ($existingView) {
        return response()->json(['message' => 'Views nonupdated successfully'], 200);
    }

        $view = new View();
        $view->user_id = Auth::id();
        $view->video_id = $videoId;
        $view->save();

        return response()->json(['message' => 'Views updated successfully'], 200);
    }

    public function view_statement(Request $request, $statementId){
        
        $existingView = View::where('user_id', Auth::id())
        ->where('statement_id', $statementId)
        ->exists();

    if ($existingView) {
        return response()->json(['message' => 'Views nonupdated successfully'], 200);
    }

        $view = new View();
        $view->user_id = Auth::id();
        $view->statement_id = $statementId;
        $view->save();

        return response()->json(['message' => 'Views updated successfully'], 200);

    }

}
