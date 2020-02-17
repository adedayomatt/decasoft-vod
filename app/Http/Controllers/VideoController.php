<?php

namespace App\Http\Controllers;

use Auth;
use Storage;
use App\Video;
use Illuminate\Http\Request;
use App\Http\Requests\VideoRequest;

class VideoController extends Controller
{

    public function __construct(){
        $this->middleware('auth')
              ->except(['show', 'index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home')->with('videos', Video::orderby('created_at', 'desc')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('video.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoRequest $request)
    {

        $video = Video::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'source' => $request->source,
            'cover_file' => $request->uploaded_cover,
            'video_file' => $request->source == 'youtube' ? $request->youtube_id : $request->uploaded_video,
            'price' => $request->price,
        ]);
        
        return redirect()->route('video.show', [$video->id])->with('success', 'New video added successsfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('video.show')->with('video', Video::findorfail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('video.edit')->with('video', Video::findorfail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VideoRequest $request, $id)
    {
        $video = Video::findorfail($id);
        $video->title = $request->title;
        $video->description = $request->description;
        $video->price = $request->price;
        if($request->uploaded_cover){
            $video->cover_file = $request->uploaded_cover;
        }
        $video->save();

        return redirect()->route('video.show', [$video->id])->with('success', 'Video updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = Video::findorfail($id);
        $video->delete();
        Storage::disk('public')->delete('videos/'.$video->cover_file);
        /**
         * If the video was uploaded, delete the video file
         */
        if($video->locallyUploaded()){
            Storage::disk('public')->delete('videos/'.$video->video_file);
        }

        return redirect()->route('user.videos')->with('success', 'video deleted');

    }
}
