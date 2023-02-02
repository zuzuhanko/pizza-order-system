@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header text-center">
                <h3 class="card-title">
              <b>Order Lists</b>
                </h3>

                <span class="fs-5 mx-3">Total - {{$orderList->total()}} </span>

        <div class="card-tools d-flex">
 <a href="{{route('admin#orderDownload')}}"> <button class="btn btn-sm btn-success me-2 ">CSV Download</button></a>

 <form action="{{route('admin#orderSearch')}}" method="get">
                    @csrf
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="tableSearch" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                      </div>
                 </form>
                </div>
              </div>


              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Customer Name</th>
                      <th>Pizza Name</th>
                      <th>Pizza Count </th>
                      <th>Payment Status</th>
                      <th>Order Date</th>
                    </tr>
                  </thead>
                  <tbody>

                    {{-- @if ($Status == 0)
                    <tr>
                      <td colspan="7">

                  <small class="text-muted">There is no data</small>
                      </td>
                    </tr>

                    @else --}}

                  @foreach ($orderList as $item )
                  <tr>
                    <td>{{$item->order_id}}</td>

                    <td>{{$item->customer_name}}</td>
                    <td>{{$item->pizza_name}}</td>
                    <td>{{$item->count}}</td>
                    <td>
                       @if ($item->payment_status ==  1)
                       Credit Card

             @else
                       Cash
                       @endif
                    </td>

                    <td>{{$item->order_time}}</td>
                   </tr>
                  @endforeach
                  {{-- @endif --}}

                  </tbody>
                </table>


               <div class="mt-3">
                {{$orderList->links()}}
               </div>

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

@endsection
