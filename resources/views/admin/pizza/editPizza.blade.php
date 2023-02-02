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
                  <legend class="text-center">Edit Pizza</legend>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{asset('upload/'.$pizza->image)}}" class="img-thumbnail" width="150px">
                    </div>
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <form class="form-horizontal" method="POST" action="{{route('admin#updatePizza',$pizza->pizza_id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-3 col-form-label">Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control"  name="name" placeholder="Name" value="{{old('name',$pizza->pizza_name)}}">
                            @if ($errors->has('name'))
                            <p class="text-danger">{{$errors->first('name')}}</p>

                            @endif
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Image</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control"  name="image" placeholder="Image">
                          @if ($errors->has('image'))
                          <p class="text-danger">{{$errors->first('image')}}</p>

                          @endif
                      </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputName" class="col-sm-3 col-form-label">Price</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control"  name="price" placeholder="Price" value="{{old('price',$pizza->price)}}">
                      @if ($errors->has('price'))
                      <p class="text-danger">{{$errors->first('price')}}</p>

                      @endif
                  </div>
              </div>


              <div class="form-group row">
                <label for="inputName" class="col-sm-3 col-form-label">Publish Status</label>
                <div class="col-sm-10">
                  <select name="publish" class="form-control">
                    <option value="">Choose Option</option>

                    @if ($pizza->publish_status == 1)
                    <option value="1" selected>Publish</option>
                    <option value="0">UnPublish</option>

                    @else
                    <option value="1">Publish</option>
                    <option value="0" selected>UnPublish</option>
                    @endif
                  </select>
                  @if ($errors->has('publish'))
                  <p class="text-danger">{{$errors->first('publish')}}</p>

                  @endif
              </div>
          </div>


          <div class="form-group row">
            <label for="inputName" class="col-sm-3 col-form-label">Category</label>
            <div class="col-sm-10">
                <select name="category" class="form-control">
                    <option value="{{$pizza->category_id}}">{{$pizza->category_name}}</option>
                @foreach ($category as $item )
               @if ($item->category_id != $pizza->category_id)
               <option value="{{$item->category_id}}">{{ $item->category_name}}</option>
               @endif
                @endforeach
                  </select>
              @if ($errors->has('category'))
              <p class="text-danger">{{$errors->first('category')}}</p>

              @endif
          </div>
      </div>


      <div class="form-group row">
        <label for="inputName" class="col-sm-3 col-form-label">Discount</label>
        <div class="col-sm-10">
          <input type="number" class="form-control"  name="discount" placeholder="Discount" value="{{old('discount',$pizza->discount_price)}}">
          @if ($errors->has('discount'))
          <p class="text-danger">{{$errors->first('discount')}}</p>

          @endif
      </div>
  </div>

  <div class="form-group row">
    <label for="inputName" class="col-sm-3 col-form-label">Buy 1 Get 1</label>
    <div class="col-sm-10">

        @if ($pizza->buy_one_get_one == 0)
        <input type="radio" name="BuyOneGetOne" value="0" checked >Yes
        <input type="radio" name="BuyOneGetOne" value="1">No

        @else
        <input type="radio" name="BuyOneGetOne" value="0" >Yes
        <input type="radio" name="BuyOneGetOne" value="1" checked>No
        @endif
      @if ($errors->has('BuyOneGetOne'))
      <p class="text-danger">{{$errors->first('BuyOneGetOne')}}</p>

      @endif
  </div>
</div>

<div class="form-group row">
    <label for="inputName" class="col-sm-3 col-form-label">Waiting Time</label>
    <div class="col-sm-10">
      <input type="number" class="form-control"  name="waitingtime" placeholder="waiting time" value="{{old('waitingtime',$pizza->waiting_time)}}">
      @if ($errors->has('waitingtime'))
      <p class="text-danger">{{$errors->first('waitingtime')}}</p>

      @endif
  </div>
</div>



<div class="form-group row">
    <label for="inputName" class="col-sm-3 col-form-label">Description</label>
    <div class="col-sm-10">
        <textarea class="form-control" placeholder="write your description" name="description">{{old('description',$pizza->description)}}</textarea>
      @if ($errors->has('description'))
      <p class="text-danger">{{$errors->first('description')}}</p>

      @endif
  </div>
</div>
<div class="form-group row">
<div class="offset-sm-start col-sm-10">
<button type="submit" class="btn bg-dark text-white">Upload</button>
</div>
</div>
 </form>

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
