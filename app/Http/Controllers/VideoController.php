<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class VideoController extends Controller
{
    

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:255',
        ]);


        Video::create([

            'title' => $request->title,
            'description' => $request->description,
            'status' => 'new',
            'category'=> $request->category,
        ]);

        return view('video.myvideo', ['videos' => $videos]);
    }



}
