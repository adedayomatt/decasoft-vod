@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mb-2">
                    @if ($video->can_watch())
                        @if ($video->fromYoutube())
                            <iframe width="100%" height="500px" src="https://youtube.com/embed/{{$video->video_file}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @elseif($video->locallyUploaded())
                            <video src="{{$video->video}}" poster="{{$video->cover['src']}}" preload="metadata"  style="width: 100%" controls></video>
                        @endif
                    @else
                        <img src="{{$video->cover['src']}}" alt="{{$video->cover['alt']}}" style="width: 100%; filter: gray(100)" class="mb-1">
                    @endif
                </div>
                <h4>{{$video->title}}</h4>
                @if ($video->is_mine())
                    <div class="d-flex text-right">
                        <div class="mx-1">
                            <a href="{{route('video.edit', $video->id)}}" class="btn btn-sm btn-primary">Edit video</a>
                        </div>
                        <form action="{{route('video.destroy', $video->id)}}" method="post" class="mx">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger ">Delete video</button>
                        </form>
                    </div>
                @endif

                <ul>
                    <li>By {{$video->user->name}}</li>
                    <li> Added {{$video->created_at->format('d F, Y h:i')}}, {{$video->created_at->diffForHumans()}}</li>
                    <li>Source: {{$video->src}}</li>
                    <li>{{number_format($video->subscriptions->count())}} subscriptions</li>
                </ul>
                @if (!$video->can_watch())
                    <div class="alert alert-info">You need to subscribe to this video to be able to watch. It's just N {{number_format($video->price)}}</div>
                    <div class="card">
                        <div class="card-body">
                            @include('widgets.pay')
                        </div>
                    </div>
                @endif
                <p>{{$video->description}}</p>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="p-2 text-center">
                            <h4>Other Videos</h4>
                        </div>
                        @if($video->other_videos()->count() > 0)
                           @foreach ($video->other_videos() as $_video)
                            @include('widgets.mini-video', ['video' => $_video])
                            <hr>
                           @endforeach 
                        @else
                            <div class="alert alert-danger">
                                There are no other videos
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection