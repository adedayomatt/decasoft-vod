<div>
    <img src="{{$video->cover['src']}}" alt="{{$video->cover['alt']}}" style="width: 100%" class="mb-1">
    <h5><a href="{{route('video.show', $video->id)}}">{{$video->title}}</a></h5>
    <div class="text-muted">
       <p>By {{$video->user->name}}</p> 
       <small>uploaded {{$video->created_at->diffForHumans()}}, {{number_format($video->subscriptions->count())}} subscriptions</small>
    </div>
    @if ($video->can_watch())
        <span class="badge badge-success">Subscribed</span>
    @else
        <span class="badge badge-danger">Not subscribed</span>
    @endif
</div>