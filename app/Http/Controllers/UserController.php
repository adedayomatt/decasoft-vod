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

    public function my_videos(){
        return view('user.videos')->with('videos', Auth::user()->videos);
    }

    public function subscribed_videos(){
        // get all the Ids of the videos that the user is subscribed to
        $subscribedVideoIDs =  Auth::user()->subscribed_videos()->pluck('id')->toArray();
        // suggest other videos that are not subscribed or uploaded by the user
        $suggestions = Video::Where('user_id', '!=', Auth::id())->WhereNotIn('id', $subscribedVideoIDs)->orderby('created_at', 'desc')->get();

        return view('user.subscribed-videos')->with([
            'subscriptions' => Auth::user()->subscriptions,
            'suggestions' => $suggestions
            ]);
    }
}
