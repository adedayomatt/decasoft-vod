<?php

namespace App\Http\Controllers;

use Auth;
use App\Video;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function myVideos(){
        return view('user.videos')->with('videos', Auth::user()->videos);
    }
}
