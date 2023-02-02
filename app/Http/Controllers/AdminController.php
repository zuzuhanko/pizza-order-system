<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    //direct profile
    public function profile(){
        $id = auth()->user()->id;
    $userData = User::where('id',$id)->first();
    return view('admin.profile.index')->with(['user' => $userData]);
       }

       //update profile
       public function updateProfile($id,Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
             'email'=>'required',
             'phone'=> 'required',
             'address'=>'required',
         ]);

         if ($validator->fails()) {
             return back()
                         ->withErrors($validator)
                         ->withInput();
         }

$updatData = $this->requestUserData($request);

 User::where('id',$id)->update($updatData);
return back()->with(['updateSuccess'=>"user info is updated !"]);
       }


       //change password
        public function changePassword($id,Request $request){
            $validator = Validator::make($request->all(), [
                'oldPassword'=>'required',
                'newPassword'=>'required',
                'confirmPassword'=>'required'


             ]);

             if ($validator->fails()) {
                return back()
                            ->withErrors($validator)
                            ->withInput();
            }
            $data = User::where('id',$id)->first();
            $oldPassword = $request->oldPassword;
            $newPassword = $request->newPassword;
            $confirmPassword = $request->confirmPassword;
            $hashedPassword = $data['password'];

            if (Hash::check($oldPassword,$hashedPassword)) {

              if($newPassword != $confirmPassword){
                return back()->with(['notsameError'=>"Your new password is not same with confirm password..!"]);
              }else{
                if(strlen($newPassword)<=6 || strlen($confirmPassword)<=6 ){
                    return back()->with(['lengthError'=>"your password must be greater than six.."]);
                }else{
                   $hash = Hash::make($newPassword);

                    User::where('id',$id)->update([
                        'password'=>$hash
                    ]);
                    return back()->with(['success'=>"Password changed successfully"]);
                }
              }
            }else{

                return back()->with(['notmatchError'=>"Your password is not match with your old one...."]);
            }


        }


        public function changePasswordPage(){
            return view('admin.profile.changePassword');
        }

        //edit user info
        public function editUserInfo($id){

            $data = User::where('id',$id)->first();
            return view('admin.Change.changeUserInfo')->with(['info'=>$data]);
        }

        //update user info
        public function updateUserInfo($id,Request $request){


            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email'=>'required',
                'phone'=>'required',
                'address'=>'required',
                'roll'=>'required'
            ]
            );

            if ($validator->fails()) {
                return back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $updateInfo =[
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=> $request->phone,
                'address'=>$request->address,
                'roll'=> $request->roll,
            ];
       User::where('id',$id)->update($updateInfo);

            return back()->with(['updateSuccess'=>"User Information is changed! ..."]);
        }

       private function requestUserData($request){
        return[
            'name' => $request->name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'address'=> $request->address,

        ];
       }


}
