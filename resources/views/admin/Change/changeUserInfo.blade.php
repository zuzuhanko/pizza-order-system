@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-8 offset-3 mt-5">
            <div class="col-md-9">

                <a href="{{route('admin#userList')}}">    <div class="text-dark"><i class="fas fa-angle-left">Back</i></div></a>
              <div class="card">
                <div class="card-header p-2 text-black bg-info">
                  <legend class="text-center">Edit User Infomation</legend>
                </div>
                <div class="card-body">

@if (Session::has('updateSuccess'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{Session::get('updateSuccess')}}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif



                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <form class="form-horizontal" action="{{route('admin#updateUserInfo',$info->id)}}" method='post'>
                        @csrf
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputName" name='name' value="{{old('name',$info->name)}}" placeholder="Name">
                            @if ($errors->has('name'))
                            <p class="text-danger mt-2">{{$errors->first('name')}}</p>

                            @endif
                        </div>

                        </div>

                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail" name="email" value="{{old('email',$info->email)}}" placeholder="Email">
                            @if ($errors->has('email'))
                            <p class="text-danger mt-2">{{$errors->first('email')}}</p>

                            @endif
                        </div>
                        </div>


                        <div class="form-group row">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                <input type="number" class="form-control" id="inputEmail" name="phone" value="{{old('phone',$info->phone)}}" placeholder="phone">
                @if ($errors->has('phone'))
                <p class="text-danger mt-2">{{$errors->first('phone')}}</p>

                @endif

               </div>
                </div>

                          <div class="form-group row">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-10">

                    <input type="text" class="form-control" id="inputEmail" name="address" value="{{old('address',$info->address)}}" placeholder="address">
                       @if ($errors->has('address'))
                           <p class="text-danger mt-2">{{$errors->first('address')}}</p>
                       @endif
                </div>
                 </div>


                 <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Role</label>
                    <div class="col-sm-10">

            <input type="text" class="form-control" id="inputEmail" name="roll" value="{{old('roll',$info->roll)}}" placeholder="address">
               @if ($errors->has('roll'))
                   <p class="text-danger mt-2">{{$errors->first('roll')}}</p>
               @endif
        </div>
         </div>


                 <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn bg-info text-white">Update</button>
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
