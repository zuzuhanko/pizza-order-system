@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-8 offset-2 mt-4">
            <h2 class="my-3">{{$pizza[0]->categoryName}}</h2>
            <div class="card">
              <div class="card-header">

<span class="fs-5 mx-3 float-end">Total - {{$pizza->total() }}</span>
                <div class="card-tools">

                </div>
              </div>


              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Image</th>
                      <th>Pizza Name</th>
                      <th>Price</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>

                  @foreach ($pizza as $item )
                  <tr>
                    <td>{{$item->pizza_id}}</td>
                    <td><img src="{{asset('upload/'.$item->image)}}" with="100px" height="100"></td>

                    <td>{{$item->pizza_name}}</td>

                    <td>{{$item->price}}</td>
                    <td>
                        @if ($item->count == 0)

                     <a href="#"> {{$item->count }}</a>
                        @else
                        <a href="{{route('admin#categoryItem',$item->category_id)}}">{{$item->count}}</a>

                        @endif

                  @endforeach

                  </tbody>
                </table>

                {{$pizza->links()}}
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <a href="{{route('admin#category')}}"> <input type="button" value="Back" class="btn bg-dark text-white"></a>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection
