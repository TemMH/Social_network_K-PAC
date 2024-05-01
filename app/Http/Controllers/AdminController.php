<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Like;
use App\Models\Comment;
use App\Models\User;
use App\Models\View;
use App\Models\Complaint;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index(Request $request)
    {


        return view('admin.adminnavigation');
    }

}
