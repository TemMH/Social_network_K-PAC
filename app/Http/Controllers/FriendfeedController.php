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
        $category = $request->input('category');
        $sort = $request->input('sortirovka');
    
        $friendIdsAsSender = Friendship::where('sender_id', auth()->id())
            ->where('status', 'accepted')
            ->pluck('recipient_id')
            ->all();
    
        $friendIdsAsRecipient = Friendship::where('recipient_id', auth()->id())
            ->where('status', 'accepted')
            ->pluck('sender_id')
            ->all();
    
        $friendIds = array_merge($friendIdsAsSender, $friendIdsAsRecipient);
    

        $videos = Video::whereIn('user_id', $friendIds)
            ->where('status', 'true')
            ->withCount('likes', 'comments');
    

        $statements = Statement::whereIn('user_id', $friendIds)
            ->where('status', 'true')
            ->withCount('likes', 'comments');
    
        
        $feedItems = $videos->get()->merge($statements->get());
    

        if ($category) {
            $feedItems->where('category', $category);
        }
    
        switch ($sort) {
            case 'old':
                $feedItems->orderBy('created_at', 'asc');
                break;
            case 'popular':
                $feedItems->withCount('likes')->orderByDesc('likes_count');
                break;
            case 'recent':
            default:
            $feedItems = $feedItems->sortByDesc('created_at');

                break;
        }
    

    

        return view('friendfeed.friendfeeduser', compact('feedItems'));
    }
    
    
    
    

}
