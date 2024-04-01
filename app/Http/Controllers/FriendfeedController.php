<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Like;
use App\Models\Comment;
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
    
        $videos = Video::where('status', 'true')->withCount('likes');
    
        if ($category) {
            $videos->where('category', $category);
        }
    
        switch ($sort) {
            case 'old':
                $videos->orderBy('created_at', 'asc');
                break;
            case 'popular':
                $videos->withCount('likes')->orderByDesc('likes_count');
                break;
            case 'recent':
            default:
                $videos->orderBy('created_at', 'desc');
                break;
        }
    
        $videos = $videos->get();
    
        return view('friendfeed.friendfeeduser', ['videos' => $videos]);
    }

}
