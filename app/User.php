<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * videos that the user uploaded
     */
    public function videos(){
        return $this->hasMany('App\Video');
    }
    /**
     * subscriptions by the user
     */
    public function subscriptions(){
        return $this->hasMany('App\Subscription');
    }

    /**
     * videos subscribed to
     */
    public function subscribed_videos(){
        $videos = collect([]);
        foreach ($this->subscriptions as $subscription) {
            $videos->push($subscription->video);
        }
        return $videos;
    }
}
