<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = ['id'];

    /**
     * The user that made the subscription
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
    /**
     * The video that was subscribed to
     */
    public function video(){
        return $this->belongsTo('App\Video');
    }
}
