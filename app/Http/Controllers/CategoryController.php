<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\category;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CategoryController;




class CategoryController extends Controller
{

//direct category
   public function category(){

    if(Session::has('CATEGORY_DATA')){
       Session::forget('CATEGORY_DATA');
    }
    $data = category::select('categories.*',DB::raw('count(pizzas.category_id) as count'))
   ->leftjoin('pizzas','categories.category_id','pizzas.category_id')
   ->groupBy('categories.category_id')
   ->paginate(5);
return view('admin.category.list')->with(['category'=>$data]);
   }

 public function addCategory(){
    return view('admin.category.addCategory');
   }


   //edit category
   public function editCategory($id){
    $data= category::where('category_id',$id)->first();

  return view ('admin.category.edit')->with(['editSuccess'=>$data]);
   }

   //update category
   public function updateCategory(Request $request){

    $validator = Validator::make($request->all(), [
        'name' => 'required',

    ],[
        'name.required'=>'You need to fill this field',
    ]);

    if ($validator->fails()) {
        return back()
                    ->withErrors($validator)
                    ->withInput();
    }
$updateData = [
    'category_name' => $request->name,];

    category::where('category_id',$request->id)->update($updateData);
    return redirect()->route('admin#category')->with(['updateSuccess'=>'Category is updated']);
   }

   //delete
   public function deleteCategory($id){
    category::where('category_id',$id)->delete();
    return back()->with(['deleteSuccess'=>'Category is deleted']);
   }

   public function createCategory(Request $request){
    $validator = Validator::make($request->all(), [
        'name' => 'required',

    ],[
        'name.required'=>'You need to fill this field',
    ]);

    if ($validator->fails()) {
        return back()
                    ->withErrors($validator)
                    ->withInput();
    }

    $data=[
       'category_name'=> $request->name
    ];

    category::create($data);
 return redirect()->route('admin#category')->with(['categorySuccess'=>"Category is added"]);


   }


   //search category
   public function searchCategory(Request $request){
  // $data = category::where('category_name','like', '%'.$request->tableSearch.'%')->paginate(5);

   $data = category::select('categories.*',DB::raw('count(pizzas.category_id) as count'))
   ->leftjoin('pizzas','categories.category_id','pizzas.category_id')
   ->where('categories.category_name','like', '%'.$request->tableSearch.'%')
   ->groupBy('categories.category_id')
   ->paginate(5);
   Session::put('CATEGORY_DATA',$request->tableSearch);

   $data->appends($request->all());
return view('admin.category.list')->with(['category'=>$data]);

   }

//CSV download
   public function categoryDownload(){
if(Session::has('CATEGORY_DATA')){
    $category = category::select('categories.*',DB::raw('count(pizzas.category_id) as count'))
    ->leftjoin('pizzas','categories.category_id','pizzas.category_id')
    ->where('categories.category_name','like', '%'.Session::get('CATEGORY_DATA').'%')
    ->groupBy('categories.category_id')
    ->get();

}else {
    $category = category::select('categories.*',DB::raw('count(pizzas.category_id) as count'))
    ->leftjoin('pizzas','categories.category_id','pizzas.category_id')
    ->groupBy('categories.category_id')
    ->get();
}

 $csvExporter = new \Laracsv\Export();


    $csvExporter->build($category, [
'category_id'=>'ID',
'category_name'=>'Name',
'count'=>'Pizza Count',
'created_at'=>'Created Date',
'updated_at'=>'Updated Date',
]);

    $csvReader = $csvExporter->getReader();

    $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

    $filename = 'categoryList.csv';

    return response((string) $csvReader)
        ->header('Content-Type', 'text/csv; charset=UTF-8')
        ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
   }
}
