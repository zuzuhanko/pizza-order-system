<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\order;
use App\Models\pizza;
use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    public function index(){
$pizza = pizza::where('publish_status',1)->paginate(9);
$status = count($pizza) == 0 ? 0: 1 ;


$category = category::get();

        return view('user.home')->with(['pizza'=>$pizza, 'category'=>$category, 'status'=>$status]);
    }

    //pizza detail
    public function pizzaDetail($id){
        $data= pizza::where('pizza_id',$id)->first();
        Session::put('PIZZA_INFO',$data);
        return view('user.detail')->with(['pizza'=>$data]);
    }

    //pizza order
    public function pizzaOrder(){
        $pizzaInfo = Session::get('PIZZA_INFO');

        return view('user.order')->with(['pizza'=>$pizzaInfo]);
    }

    //payment method
    public function payment(Request $request){
        $validator = Validator::make($request->all(), [
            'pizzaCount' => 'required',
            'paymentType' => 'required',


         ]);

         if ($validator->fails()) {
             return back()
                         ->withErrors($validator)
                         ->withInput();
         }


        $pizzaInfo= Session::get('PIZZA_INFO');
        $userId= auth()->user()->id;
        $count = $request->pizzaCount;

        $orderData = $this->requestPayment($request,$pizzaInfo,$userId);

       for($i=0;$i<$count ; $i++){
        order::create($orderData);
       }

       $waitingTime = $pizzaInfo['waiting_time'] * $count ;

    return back()->with(['totalTime'=>$waitingTime]);
}

    public function categorySearch($id){

        $data = pizza::where('pizza_id',$id)->paginate(9);
        $status = count($data) == 0 ? 0: 1 ;
        $category = category::get();
       return view('user.home')->with(['pizza'=>$data,'category'=>$category, 'status'=>$status]);
    }

    public function searchPizza(Request $request){
      $data = pizza::where('pizza_name','like','%'.$request->searchData.'%')->paginate(9);
      $status = count($data) == 0 ? 0: 1 ;
      $category = category::get();
      $data->appends($request->all());
     return view('user.home')->with(['pizza'=>$data,'category'=>$category, 'status'=>$status]);
    }

    public function searchItem(Request $request){
        $min = $request->minPrice;
        $max = $request->maxPrice;

        $start = $request->startDate;
        $end = $request->endDate;

$pizza = pizza::select('*');

//date search
if(is_null($start) && !is_null($end)){
$pizza = $pizza->whereDate('created_at','<=',$end);
}elseif(!is_null($start) && is_null($end)){
    $pizza = $pizza->whereDate('created_at','>=',$start);
}elseif(!is_null($start) && !is_null($end)){
    $pizza = $pizza->whereDate('created_at','<=',$end)
                   ->whereDate('created_at','>=',$start);
}

//price search
if(!is_null($min) && is_null($max)){

  $pizza = $pizza->where('price','>=', $min);
}
elseif(is_null($min) && !is_null($max)){
 $pizza =$pizza->where('price','<=',$max);
}
elseif(!is_null($min)&& !is_null($max)){
    $pizza = $pizza->where('price','>=',$min)
                   ->where('price','<=',$max);

}

$pizza = $pizza->paginate(9);
$pizza->appends($request->all());

$status = count($pizza) == 0 ? 0: 1 ;
$category = category::get();

return view('user.home')->with(['pizza'=>$pizza,'category'=>$category, 'status'=>$status]);

    }

    private function requestPayment($request,$pizzaInfo,$userId){

        return[
'customer_id'=>$userId,
'pizza_id'=>$pizzaInfo['pizza_id'],
'carrier_id'=>0,
'payment_status'=>$request['paymentType'],
'order_time'=>Carbon::now()
        ];

    }
}
