@extends('user.layout.style')

@section('content')
<div class="row mt-5 d-flex justify-content-center">


    <div class="col-5 ">

        <img src="{{asset('upload/'.$pizza->image)}}"  width="100%" height="500px">            <br>

        <a href="{{route('user#detail',$pizza->pizza_id)}}">
            <button class="btn bg-dark text-white" style="margin-top: 20px;">
                Back
            </button>
        </a>
    </div>
    <div class="col-5">

        @if (Session::has('totalTime'))

        <div class="alert alert-primary alert-dismissible fade show" role="alert">
          Your Order Success .... Please wait   {{Session::get('totalTime')}} minutes..
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

       <h5>Name</h5>
       <span>{{$pizza->pizza_name}}</span> <hr>

       <h5>Price</h5>
       <span class="">{{$pizza->price - $pizza->discount_price}} MMK</span><hr>


       <h5>Waiting Time</h5>
       <span>{{$pizza->waiting_time}} Minutes</span> <hr>

       <form action="" method="post">
        @csrf
        <h5>Pizza Count</h5>
       <input type="number" name="pizzaCount" id="" class="form-control"   placeholder="Type the number of pizzas you want"><hr>
       @if ($errors->has('pizzaCount'))
       <p class="text-danger">{{$errors->first('pizzaCount')}}</p>

       @endif

       <h5>Payment Method</h5>
       <div class="form-check">
        <input class="form-check-input" type="radio" name="paymentType" value="1">
        <label class="form-check-label" for="flexRadioDefault1">
      Credit Card
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="paymentType" value="2" >
        <label class="form-check-label" for="flexRadioDefault2">
      Cash
        </label>
      </div>
      @if ($errors->has('paymentType'))
      <p class="text-danger">{{$errors->first('paymentType')}}</p>

      @endif
<br>
<a href="{{route('user#payment')}}"><button class="btn btn-primary float-start mt-2 " type="submit"><i class="fas fa-shopping-cart"></i> Place Order</button></a>


       </form>


    </div>
</div>


@endsection
