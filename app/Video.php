<?php

namespace App;

use Auth;
use App\Video;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['cover', 'video', 'src'];

    /**
     * The user that uploaded the video
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
    /**
     * Subscriptions to the video
     */
    public function subscriptions(){
        return $this->hasMany('App\Subscription');
    }
    /**
     * Related videos to this one, only returning other videos because there is no category yet
     */
    public function other_videos(){
        return Video::where('id', '!=', $this->id)->get();
    }
    /**
     * The cover source file
     */
    public function getCoverAttribute(){
        return [
            'src' => file_exists('storage/videos/'.$this->cover_file) ? asset('storage/videos/'.$this->cover_file) : asset('assets/vod.png'),
            'alt' => $this->title
        ];
    }

    public function getSrcAttribute(){
        return $this->fromYoutube() ? 'Youtube' : ($this->locallyUploaded() ? 'Upload' : 'Unknown Source');
    }
    /**
     * The video source file
     */
    public function getVideoAttribute(){
        return asset('storage/videos/'.$this->video_file);
    }
    /**
     * Determine if the video belongs to the current authenticated user
     */
    public function is_mine(){
        return $this->user->id == Auth::id() ? true : false;
    }

    /**
     * Determine if the current authenticateed user is subscribed to the video to watch
     */
    public function can_watch(){
        return $this->subscriptions()->where('user_id', Auth::id())->count() > 0 || $this->is_mine() ? true : false;
    }

    /**
     * Determine if the video was imported from youtube
     */
    public function fromYoutube(){
        return $this->source == 'youtube' ? true : false;
    }

    /**
     * Determine if the video was uploaded
     */
    public function locallyUploaded(){
        return $this->source == 'local' ? true : false;
    }

}
