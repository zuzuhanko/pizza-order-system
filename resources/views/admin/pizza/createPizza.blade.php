@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">




        <div class="row mt-4">
          <div class="col-8 offset-3 mt-5">
            <div class="col-md-9">
            <a href="{{route('admin#category')}}">    <div class="text-dark"><i class="fas fa-angle-left">Back</i></div></a>
              <div class="card">
                <div class="card-header p-3">
                  <legend class="text-center">Add Pizza</legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <form class="form-horizontal" method="POST" action="{{route('admin#insertPizza')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-3 col-form-label">Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control"  name="name" placeholder="Name">
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
                      <input type="number" class="form-control"  name="price" placeholder="Price">
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
                    <option value="1">Publish</option>
                    <option value="0">UnPublish</option>
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
                    <option value="">Choose Category</option>
               @foreach ($category as $item )
               <option value="{{$item->category_id}}">{{$item->category_name}}</option>

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
          <input type="number" class="form-control"  name="discount" placeholder="Discount">
          @if ($errors->has('discount'))
          <p class="text-danger">{{$errors->first('discount')}}</p>

          @endif
      </div>
  </div>

  <div class="form-group row">
    <label for="inputName" class="col-sm-3 col-form-label">Buy 1 Get 1</label>
    <div class="col-sm-10">
        <input type="radio" name="BuyOneGetOne" value="0" >Yes
        <input type="radio" name="BuyOneGetOne" value="1">No
      @if ($errors->has('BuyOneGetOne'))
      <p class="text-danger">{{$errors->first('BuyOneGetOne')}}</p>

      @endif
  </div>
</div>

<div class="form-group row">
    <label for="inputName" class="col-sm-3 col-form-label">Waiting Time</label>
    <div class="col-sm-10">
      <input type="number" class="form-control"  name="waitingtime" placeholder="waiting time">
      @if ($errors->has('waitingtime'))
      <p class="text-danger">{{$errors->first('waitingtime')}}</p>

      @endif
  </div>
</div>



<div class="form-group row">
    <label for="inputName" class="col-sm-3 col-form-label">Description</label>
    <div class="col-sm-10">
        <textarea class="form-control" placeholder="write your description" name="description"></textarea>
      @if ($errors->has('description'))
      <p class="text-danger">{{$errors->first('description')}}</p>

      @endif
  </div>
</div>
<div class="form-group row">
<div class="offset-sm-start col-sm-10">
<button type="submit" class="btn bg-dark text-white">Add</button>
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
