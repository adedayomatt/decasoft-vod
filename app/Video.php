<?php

namespace App;

use Auth;
use App\Video;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $guarded = ['id'];
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
    public function relatedVideos(){
        return Video::where('id', '!=', $this->id)->get();
    }
    /**
     * Determine if the video belongs to the current authenticated user
     */
    public function isMine(){
        return $this->user->id == Auth::id() ? true : false;
    }
}
