@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
      <div class="row mt-4">
          <div class="col-8 offset-3 mt-5">
            <div class="col-md-9">
            <a href="{{route('admin#pizza')}}">    <div class="text-dark"><i class="fas fa-angle-left">Back</i></div></a>
              <div class="card">
                <div class="card-header p-3">
                  <legend class="text-center"> Pizza Info </legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane d-flex justify-content-between" id="activity">

             <div class="mt-2 text-center py-4 pt-4">
    <img class="img-thumbnail rounded-circle" src="{{asset('upload/'.$pizza->image)}}" style="width:180px;height:180px">
             </div>

<div class="" >
    <div class="mt-3">
        <b>Name</b> : <span>{{$pizza->pizza_name}}</span>
    </div>

    <div class="mt-3">
        <b>Price</b> : <span>{{$pizza->price}} Kyats</span>
    </div>

    <div class="mt-3">
        <b>Publish Status</b> : <span>
            @if ($pizza->publish_status == 0)
            NO
            @else
            YES

            @endif
        </span>
    </div>

    <div class="mt-3">
        <b>Category_ID</b> : <span>{{$pizza->category_id}}</span>
    </div>

    <div class="mt-3">
        <b>Discount Price</b> : <span>{{$pizza->discount_price}} Kyats</span>
    </div>

    <div class="mt-3">
        <b>Buy One Get One</b> : <span>{{$pizza->buy_one_get_one}}</span>
    </div>

    <div class="mt-3">
        <b>Waiting Time</b> : <span>{{$pizza->waiting_time}}</span>
    </div>

    <div class="mt-3">
        <b>Description</b> : <span>{{$pizza->description}}</span>
    </div>




</div>




                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
