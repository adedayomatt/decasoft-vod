<?php

namespace App\Http\Controllers;

use Auth;
use Paystack;
use App\Video;
use App\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function subscribe(){
       return Paystack::getAuthorizationUrl()->redirectNow();
    }

    public function callback(){
        $payment = Paystack::getPaymentData();
        $video = Video::findorfail($payment['data']['metadata']['video_id']);

        $subscription = Subscription::create([
            'user_id' => Auth::id(),
            'video_id' => $video->id,
            'amount_paid' => $payment['data']['amount']/100
        ]);

        return redirect()->route('video.show', $video->id)->with('success', 'Successfully subscribed to '.$video->title);
    }
}
