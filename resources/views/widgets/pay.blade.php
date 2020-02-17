@auth
    <form action="{{route('video.subscribe')}}" method="post">
        @csrf
        <input type="hidden" name="email" value="{{Auth::user()->email}}">
        <input type="hidden" name="amount" value="{{$video->price * 100}}}"> 
        <input type="hidden" name="quantity" value="1">
        <input type="hidden" name="metadata" value="{{ json_encode($array = ['video_id' => $video->id]) }}" >
        <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> 
        <input type="hidden" name="key" value="{{ config('paystack.secretKey') }}"> 
        <button type="submit" class="btn btn-primary">Pay N {{number_format($video->price)}} Now</button>
    </form>
@endauth

@guest
    <p>Login first, and then pay</p> 
    <a href="{{route('login')}}">Login</a> or <a href="{{route('register')}}">Sign up</a>
@endguest
