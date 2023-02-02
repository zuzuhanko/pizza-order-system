<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\OrderController;

class OrderController extends Controller
{//order list
   public function orderList(){

    if(Session::has('ORDER_DATA')){
        Session::forget('ORDER_DATA');
    }
 $data = order::select('orders.*',
 DB::raw('COUNT(orders.pizza_id) as count'),'pizzas.pizza_name','users.name as customer_name')
    ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
    ->join('users','users.id','orders.customer_id')
    ->groupBy('orders.customer_id','orders.pizza_id',)
    ->paginate(3);




return view('admin.order.orderList')->with(['orderList'=>$data]);
   }

   //order search

   public function orderSearch(Request $request){
    $data = order::select('orders.*',
    DB::raw('COUNT(orders.pizza_id) as count'),'pizzas.pizza_name','users.name as customer_name')
       ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
       ->join('users','users.id','orders.customer_id')
       ->orWhere('users.name','like','%'.$request->tableSearch.'%')
       ->orWhere('pizzas.pizza_name','like','%'.$request->tableSearch.'%')
       ->groupBy('orders.customer_id','orders.pizza_id')
       ->paginate(3);

    //    if(count($data) == 0){
    //     $empty_Status = 0;
    // }else{
    //     $empty_Status = 1;
    // }

 Session::put('ORDER_DATA',$request->tableSearch);

$data->appends($request->all());
return view('admin.order.orderList')->with(['orderList'=>$data]);
   }


   //order csv download
   public function orderDownload(){

    if(Session::has('ORDER_DATA')){
        $order = order::select('orders.*',
    DB::raw('COUNT(orders.pizza_id) as count'),'pizzas.pizza_name','users.name as customer_name')
       ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
       ->join('users','users.id','orders.customer_id')
       ->orWhere('users.name','like','%'.Session::get('ORDER_DATA').'%')
       ->orWhere('pizzas.pizza_name','like','%'.Session::get('ORDER_DATA').'%')
       ->groupBy('orders.customer_id','orders.pizza_id')
       ->get();

    }else {
        $order = order::select('orders.*',
        DB::raw('COUNT(orders.pizza_id) as count'),'pizzas.pizza_name','users.name as customer_name')
           ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
           ->join('users','users.id','orders.customer_id')
           ->groupBy('orders.customer_id','orders.pizza_id',)
           ->get();
    }

     $csvExporter = new \Laracsv\Export();


        $csvExporter->build($order, [
    'order_id'=>'ID',
    'customer_name'=>'Customer Name',
    'pizza_name'=>'Pizza Name',
    'count'=>'Pizza Count',
    'order_time'=>'Date',
    'created_at'=>'Created Date',
    'updated_at'=>'Updated Date',
    ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'orderList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
   }

}
