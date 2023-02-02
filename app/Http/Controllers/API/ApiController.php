<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;

use App\Models\category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\API\ApiController;

class ApiController extends Controller
{
    public function categoryList(){
        $category = category::get();
        $response =[
           " status" => 'success',
          "data" => $category,
        ];

        return Response::json($response);
    }


    public function createList(Request $request){

      $data = [
        'category_name'=>$request->CategoryName,
        'created_at'=>Carbon::now(),
        'updated_at'=>Carbon::now(),

      ];


      category::create($data);



     return Response::json( [
        'status'=> 200,
        'message'=>'success',
      ]);
    }

    //category details
    public function categoryDetails($id){
$data = category::where('category_id',$id)->first();

if(!empty($data)){
    return Response::json([
        'status'=>200,
        'message'=>'success',
        'data'=>$data,
    ]);
}

    return Response::json([
        'status'=>200,
        'message'=>'fail',

    ]);


 }

    //category delete
    public function categoryDelete($id){

  $data = category::where('category_id',$id)->first();

  if(empty($data))
{
    return Response::json([
        'status'=>200,
        'message'=>'No data to delete',]);
}

category::where('category_id',$id)->delete();
return Response::json([
    'status'=>200,
    'message'=>'success',


]);
}

public function categoryUpdate(Request $request){
 $updateData =[
    'category_id'=>$request->id,
    'category_name'=>$request->categoryName,
 ];

 $data = category::where('category_id',$request->id)->first();

 if(!empty($data)){
    category::where('category_id',$request->id)->update($updateData);
    return Response::json([
        'status'=>200,
        'message'=>'success',
        'data'=>$updateData,
    ]);

 }

 return Response::json([
    'status'=>200,
    'message'=>'there is no data to update!'
 ]);
}



}
