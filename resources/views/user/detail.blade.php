@extends('user.layout.style')

@section('content')
<div class="row mt-5 d-flex justify-content-center">

    <div class="col-5 ">

        <img src="{{asset('upload/'.$pizza->image)}}"  width="100%"  height="500px">            <br>
      <a href="{{route('user#order')}}">  <button class="btn btn-primary float-end mt-2 col-12"><i class="fas fa-shopping-cart"></i> Buy</button></a>

        <a href="{{route('user#profile')}}">
            <button class="btn bg-dark text-white" style="margin-top: 20px;">
                Back
            </button>
        </a>
    </div>
    <div class="col-5">
       <h5>Name</h5>
       <span>{{$pizza->pizza_name}}</span> <hr>

       <h5>Price</h5>
       <span>{{$pizza->price}} MMK</span> <hr>

       <h5>Discount Price</h5>
       <span>{{$pizza->discount_price}} MMK</span> <hr>

       <h5>Buy One Get One</h5>
       <span>
        @if ($pizza->buy_one_get_one == 0)
       NO
          @else
        YES
        @endif</span> <hr>

       <h5>Waiting Time</h5>
       <span>{{$pizza->waiting_time}}</span> <hr>

       <h5>Description</h5>
       <span class="">{{$pizza->description}}</span> <hr>


<br>
<div class="">
    <h5 class="text-danger">Total Price</h5>
    <h3 class="text-primary">    <span class="">{{$pizza->price - $pizza->discount_price}} MMK</span></h3> <hr>

</div>


    </div>
</div>


@endsection
