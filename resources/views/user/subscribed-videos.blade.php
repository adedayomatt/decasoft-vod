@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h4 class="text-center">Subscribed Videos</h4>
                @if ($subscriptions->count() > 0)
                    @foreach ($subscriptions as $subscription)
                        <div class="col-md-4">
                            @include('widgets.video', ['video' => $subscription->video])
                            <div class="text-muted">
                                subscribed: {{$subscription->created_at->diffForHumans()}}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-danger">
                        No video yet
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="p-2">
                            <h4>Discover More...</h4>
                        </div>
                        @if ($suggestions->count() > 0)
                            @foreach ($suggestions as $suggested_video)
                                @include('widgets.mini-video', ['video' => $suggested_video ])
                                <hr>
                            @endforeach
                        @else
                            <div class="alert alert-danger">
                                No suggested video
                            </div>
                        @endif

                    </div>

                </div>
            </div>
           
        </div>
   
</div>
@endsection
