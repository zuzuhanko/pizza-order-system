<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PizzaUserController extends Controller
{    //direct userlist
   public function userList(){
    $userData =  User::where('roll','user')->paginate(5);

    return view('admin.user.userList')->with(['user'=>$userData]);
   }

   //direct admin list
   public function adminList(){
    $userData = User::where('roll','admin')->paginate(5);
    return view('admin.user.adminList')->with(['user'=>$userData]);
   }


   //user list serach
   public function Usersearch(Request $request){

   $response = $this->search('user',$request);


  return view('admin.user.userList')->with(['user'=>$response]);

   }

   //delete user list
   public function deleteUser($id){
    User::where('id',$id)->delete();
    return back()->with(['deleteSuccess'=>'User account is deleted!']);
   }

   //admin list search
   public function adminSearch(Request $request){
    $response =$this->search('admin',$request);



   return view('admin.user.adminList')->with(['user'=>$response]);

    }

    //delete admin list
    public function deleteAdmin($id){
        User::where('id',$id)->delete();


        return back()->with(['deleteSuccess'=>"Admin account is deleted!"]);
    }


    //data searching
    private function search($roll,$request){
        $searchData = User::where('roll',$roll)
        ->where(function ($query) use ($request) {
         $query->orWhere('name','like','%'.$request->userData.'%')     //logical grouping in laravel .com
         ->orWhere('email','like','%'.$request->userData.'%')
         ->orWhere('phone','like','%'.$request->userData.'%')
         ->orWhere('address','like','%'.$request->userData.'%');
     })->paginate(5);







     $searchData->appends($request->all());

     return $searchData;

    }

}
