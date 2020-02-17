@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($video->fromYoutube())
                <iframe width="100%" height="500px" src="https://youtube.com/embed/{{$video->video_file}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            @elseif($video->locallyUploaded())
                <video src="{{$video->video}}" poster="{{$video->cover['src']}}" preload="metadata"  style="width: 100%" controls></video>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="py-2 text-center">
                        <h4>Edit Video</h4>
                    </div>
                    <hr>
                    <form action="{{route('video.update', $video->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{$video->title}}" placeholder="Video title" required>
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" placeholder="About this video..." required>{{$video->description}}</textarea>
                        </div>
                        <div class="form-group preview-image">
                            <label for="">Video</label>
                            <div class="image-preview-container text-center" replace="#prev-cover">
                                <img id="prev-cover" src="{{$video->cover['src']}}" alt="{{$video->cover['alt']}}" width="100%">
                            </div>
                            <input type="file" name="cover_image"  class="form-control {{ $errors->has('cover_image') ? ' is-invalid' : '' }}">
                        </div>

                        <div class="form-group">
                            <label for="">Price</label>
                            <input type="number" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{$video->price}}" placeholder="Price to watch this video" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update video</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom-scripts')
    <script src="{{asset('js/image-preview.js')}}"></script>
@endsection
