<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function home(){
        $recent_videos = Video::orderby('created_at', 'desc')->get();
        return view('home')->with('videos', $recent_videos);
    }
}
