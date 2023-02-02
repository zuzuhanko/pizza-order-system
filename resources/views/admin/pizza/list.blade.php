@extends('admin.layout.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        @if (Session::has('deleteSuccess'))

        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{Session::get('deleteSuccess')}}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (Session::has('updateSuccess'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{Session::get('updateSuccess')}}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (Session::has('createSuccess'))

        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{Session::get('createSuccess')}}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    <a href="{{route('admin#createPizza')}}"> <button class="btn btn-sm bg-dark" ><i class="fas fa-plus"></i></button> </a>
                </h3>
                <span class="fs-5 mx-3">Total - {{$pizza->total() }}</span>
                <div class="card-tools d-flex">
                    <a href="{{route('admin#pizzaDownload')}}"> <button class="btn btn-sm btn-success me-2 ">CSV Download</button></a>
                  <form action="{{ route('admin#searchPizza')}}" method="get">
                    @csrf
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="tableSearch" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                          </button>
                        </div>

                  </form>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Pizza Name</th>
                      <th>Image</th>
                      <th>Price</th>
                      <th>Publish Status</th>
                      <th>Buy 1 Get 1 Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>

                  @if ($Status == 0)
                  <tr>
                    <td colspan="7">

                <small class="text-muted">There is no data</small>
                    </td>
                  </tr>

                  @else
                  @foreach ( $pizza as $item)
                  <tr>
                      <td>{{$item->pizza_id}}</td>
                      <td>{{$item->pizza_name}}</td>
                      <td>
                        <img src="{{asset('upload/'.$item->image)}}" class="img-thumbnail" width="100px">
                      </td>
                      <td>{{$item->price}} MMK</td>
                      <td>
                          @if ($item->publish_status == 1)
                          Publish
              @elseif ($item->publish_status == 0)
              Unplish

                          @endif
                      </td>
                      <td>
                          @if ($item->buy_one_get_one == 0)
                          YES
                          @elseif ($item->buy_one_get_one == 1)
                          NO

                          @endif
                      </td>
                      <td>
                       <a href="{{route('admin#editPizza',$item->pizza_id)}}"> <button class="btn btn-sm bg-dark text-white"><i class="fas fa-edit"></i></button></a>
<a href="{{route('admin#deletePizza',$item->pizza_id)}}"><button class="btn btn-sm bg-danger text-white"><i class="fas fa-trash-alt"></i></button></a>
<a href="{{route('admin#pizzaInfo',$item->pizza_id)}}"><button class="btn btn-sm bg-warning text-white"><i class="fas fa-eye"></i></i></button></a>
</td>
                    </tr>

                  @endforeach
                  @endif

                  </tbody>
                </table>
                <div class="">{{$pizza->links()}}</div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
