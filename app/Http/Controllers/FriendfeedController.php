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
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class FriendfeedController extends Controller
{
    
    public function friendfeeduser(Request $request)
    {
        $friendIdsAsSender = Friendship::where('sender_id', auth()->id())
            ->where('status', 'accepted')  //pending
            ->pluck('recipient_id')
            ->all();
    
        $friendIdsAsRecipient = Friendship::where('recipient_id', auth()->id())
            ->where('status', 'accepted')
            ->pluck('sender_id')
            ->all();
    
        $friendIds = array_merge($friendIdsAsSender, $friendIdsAsRecipient);
    
        $feedItems = collect([]);
    
        $videos = Video::whereIn('user_id', $friendIds)
            ->where('status', 'true')
            ->withCount('likes', 'comments','views')
            ->get();
    
        $statements = Statement::whereIn('user_id', $friendIds)
            ->where('status', 'true')
            ->withCount('likes', 'comments','views')
            ->get();
    

        $feedItems = $feedItems->merge($videos)->merge($statements);
    
        $feedItems = $feedItems->sortByDesc('created_at');
    
        return view('friendfeed.friendfeeduser', compact('feedItems'));
    }
    
    
    
    public function addCommentVideo(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $video->addComment($request->input('comment'));

        return redirect()->back();
    }

    public function addCommentStatement(Request $request, $id)
    {
        $video = Statement::findOrFail($id);
        $video->addComment($request->input('comment'));

        return redirect()->back();
    }
    

}
