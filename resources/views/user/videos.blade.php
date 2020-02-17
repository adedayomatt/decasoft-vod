@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="text-center">My uploaded Videos</h4>
    @if ($videos->count() > 0)
        <div class="row justify-content-center">
            @foreach ($videos as $video)
                <div class="col-md-4">
                    @include('widgets.video')
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-danger">
            No video yet
        </div>
        <a href="{{route('video.create')}}" class="btn btn-primary">upload video</a>
    @endif
</div>
@endsection
