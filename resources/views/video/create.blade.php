@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="py-2 text-center">
                        <h4>New Video</h4>
                    </div>
                    <hr>
                    <form action="{{route('video.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{old('title')}}" placeholder="Video title" required>
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" placeholder="About this video..." required>{{old('title')}}</textarea>
                        </div>
                        <div class="form-group preview-image">
                            <label for="">Cover</label>
                            <div class="image-preview-container text-center" preview-width="100%"></div>
                            <input type="file" name="cover_image"  class="form-control {{ $errors->has('cover_image') ? ' is-invalid' : '' }}">
                        </div>

                        <div class="form-group">
                            <label for="">Video</label>
                            <input type="file" name="video_file"  class="form-control {{ $errors->has('video_file') ? ' is-invalid' : '' }}">
                        </div>

                        <div class="form-group">
                            <label for="">Price</label>
                            <input type="number" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{old('price')}}" placeholder="Price to watch this video" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Publish video</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>My recent videos</h5>
                    <hr>
                    @php
                        $videos = Auth::user()->videos
                    @endphp
                    @if ($videos->count() > 0)
                        @foreach ($videos as $video)
                            @include('widgets.mini-video')
                        @endforeach
                    @else
                        <div class="alert alert-danger">
                            You have not uploaded any video yet
                        </div>
                    @endif
                </div>
               
            </div>
        </div>
    </div>
</div>
@endsection
