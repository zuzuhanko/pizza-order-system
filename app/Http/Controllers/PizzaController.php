<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\pizza;
use App\Models\category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PizzaController;
use Illuminate\Support\Facades\Validator;


class PizzaController extends Controller
{

 public function pizza(){

    if(Session::has('PIZZA_DATA')){
        Session::forget('PIZZA_DATA');
    }
        $data = pizza::paginate(3);
if(count($data) == 0){
    $empty_Status = 0;
}else{
    $empty_Status = 1;
}

        return view('admin.pizza.list')->with(['pizza'=>$data , 'Status'=> $empty_Status]);
       }

       //delete
 public function deletePizza($id){
    $data = pizza::select('image')->where('pizza_id',$id)->first();
   $fileName = $data['image'];


    pizza::where('pizza_id',$id)->delete(); //db delete

    if(File::exists(public_path().'/upload/'.$fileName)){
        File::delete(public_path().'/upload/'.$fileName);
    }



    return back()->with(['deleteSuccess'=>'Delete Success']);
 }

 public function createPizza(){
    $category = category::get();

    return view('admin.pizza.createPizza')->with(['category'=>$category]);
 }

 public function insertPizza(Request $request){


    $validator = Validator::make($request->all(), [
       'name' => 'required',
       'image' => 'required',
       'price'=>'required',
       'publish'=>'required',
       'category'=>'required',
       'discount' => 'required',
       'BuyOneGetOne' => 'required',
       'waitingtime' => 'required',
       'description' => 'required',
    ]);

    if ($validator->fails()) {
        return back()
                    ->withErrors($validator)
                    ->withInput();
    }

    $file = $request->file('image');
    $fileName =uniqid().'-'. $file->getClientOriginalName();
    $file->move(public_path().'/upload/',$fileName);

$data = $this->requestPizzaData($request,$fileName);
pizza::create($data);
return redirect()->route('admin#pizza')->with(['createSuccess'=>'Pizza is created!']);
 }

 //pizza information direct
 public function pizzaInfo($id){
    $data = pizza::where('pizza_id',$id)->first();
    return view('admin.pizza.info')->with(['pizza'=>$data]);

 }

 //edit pizza
 public function editPizza($id){

    $data = pizza::select('pizzas.*','categories.category_id','categories.category_name')
    ->join('categories','categories.category_id','pizzas.category_id')
    ->where('pizza_id',$id)
    ->first();

    $category = category::get();
    return view('admin.pizza.editPizza')->with(['pizza'=>$data, 'category'=>$category]);
 }


 //update pizza image
 public function updatePizza($id,Request $request){
   $validator = Validator::make($request->all(), [
      'name' => 'required',

      'price'=>'required',
      'publish'=>'required',
      'category'=>'required',
      'discount' => 'required',
      'BuyOneGetOne' => 'required',
      'waitingtime' => 'required',
      'description' => 'required',
   ]);

   if ($validator->fails()) {
       return back()
                   ->withErrors($validator)
                   ->withInput();
   }

   $updateData = $this->requestUpdatePizzaData($request);
if(isset($updateData['image'])){
    //get old image name
   $data = pizza::select('image')->where('pizza_id',$id)->first();
   $fileName = $data['image'];

//delete old image
   if(File::exists(public_path().'/upload/'.$fileName)){
    File::delete(public_path().'/upload/'.$fileName);
}

//get new image name
$file= $request->file('image');
$fileName =uniqid().'-'. $file->getClientOriginalName();
$file->move(public_path().'/upload/',$fileName);

$updateData['image']=$fileName;

}

    //update old image
    pizza::where('pizza_id',$id)->update($updateData);

    return redirect()->route('admin#pizza')->with(['updateSuccess'=>'Pizza image is updated']);

}




//category item
public function categoryItem($id){
    $data = pizza::select('pizzas.*','categories.category_name as categoryName')
    ->join('categories','pizzas.category_id','categories.category_id')
    ->where('categories.category_id',$id)
    ->paginate(5);

   return view('admin.category.item')->with(['pizza'=>$data]);
   }

   //pizza data search
public function searchPizza(Request $request){

    $searchKey = $request->tableSearch;
    $searchData = pizza::orWhere('pizza_name','like','%'.$searchKey.'%')
                        ->orWhere('price','like','%'.$searchKey.'%')
                        ->paginate(3);


                        if(count($searchData) == 0){
                            $empty_Status = 0;
                        }else{
                            $empty_Status = 1;
                        }
     Session::put('PIZZA_DATA',$request->tableSearch);

    $searchData->appends($request->all());
    return view('admin.pizza.list')->with(['pizza'=>$searchData , 'Status'=>$empty_Status]);

    }


private function requestUpdatePizzaData($request){
$arr = [
   'pizza_name' => $request->name,

   'price' => $request->price,
   'publish_status' => $request->publish,
   'category_id'  => $request->category,
   'discount_price' => $request->discount,
   'buy_one_get_one'=> $request->BuyOneGetOne,
   'waiting_time'=>$request->waitingtime,
   'description'=>$request->description,
   'created_at'=>Carbon::now(),
   'updated_at'=>Carbon::now(),

];
if(isset($request->image)){
   $arr['image']= $request->image;
}
return $arr;

 }

 //csv download
 public function pizzaDownload(){
    if(Session::has('PIZZA_DATA')){
        $pizzaData = pizza::orWhere('pizza_name','like','%'.Session::get('PIZZA_DATA').'%')
                        ->orWhere('price','like','%'.Session::get('PIZZA_DATA').'%')
                        ->get();

    }else {
        $pizzaData = pizza::get();
    }

     $csvExporter = new \Laracsv\Export();


        $csvExporter->build($pizzaData, [
    'pizza_id'=>'ID',
    'pizza_name'=>'Name',
    'price'=>'Price',
   'publish_status'=>'Publish Status',
   'buy_one_get_one'=>'Buy One Get One',
    'created_at'=>'Created Date',
    'updated_at'=>'Updated Date',
    ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'pizzaList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');


 }

 private function requestPizzaData($request,$fileName){
    return[
        'pizza_name' => $request->name,
        'image' => $fileName,
        'price' => $request->price,
        'publish_status' => $request->publish,
        'category_id'  => $request->category,
        'discount_price' => $request->discount,
        'buy_one_get_one'=> $request->BuyOneGetOne,
        'waiting_time'=>$request->waitingtime,
        'description'=>$request->description,
        'created_at'=>Carbon::now(),
        'updated_at'=>Carbon::now(),
    ];
 }


}
