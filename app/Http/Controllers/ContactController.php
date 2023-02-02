<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ContactController;

class ContactController extends Controller
{
 public function createContact(Request $request){
    $validator = Validator::make($request->all(), [
        'name' => 'required',
         'email'=>'required',
         'message'=> 'required',

     ]);

     if ($validator->fails()) {
         return back()
                     ->withErrors($validator)
                     ->withInput();
     }

$data= $this->requestUserData($request);
Contact::create($data);
return back()->with(['contactSuccess'=>"Your message is sent!"]);
 }

 //contact list

 public  function contactList(){

    if(Session::has('CONTACT_DATA')){
        Session::forget('CONTACT_DATA');
    }
   $data = Contact::orderBy('contact_id','desc')->paginate(3);
   if(count($data) == 0){
    $empty_Status = 0;
}else{
    $empty_Status = 1;
}
    return view('admin.contact.list')->with(['contact'=>$data,'Status'=>$empty_Status]);
 }

 //contact search
 public function contactSearch(Request $request){
   $searchData = Contact::orwhere('name','like','%'.$request->searchData.'%')
                   ->orwhere('email','like','%'.$request->searchData.'%')
                   ->orwhere('message','like','%'.$request->searchData.'%')
                   ->paginate(3);


                   if(count($searchData) == 0){
                    $empty_Status = 0;
                }else{
                    $empty_Status = 1;
                }

                Session::put('CONTACT_DATA',$request->searchData);

                $searchData->appends($request->all());

 return view('admin.contact.list')->with(['contact'=>$searchData,'Status'=>$empty_Status]);
 }

 //contact csv download
 public function contactDownload(){

    if(Session::has('CONTACT_DATA')){
        $contact = Contact::orwhere('name','like','%'.Session::get('CONTACT_DATA').'%')
                   ->orwhere('email','like','%'.Session::get('CONTACT_DATA').'%')
                   ->orwhere('message','like','%'.Session::get('CONTACT_DATA').'%')
                   ->get();


    }else {
        $contact = Contact::orderBy('contact_id','desc')->get();
    }

     $csvExporter = new \Laracsv\Export();


        $csvExporter->build($contact, [
    'contact_id'=>'ID',
    'name'=>'Customer Name',
   'email'=>'Email',
  'message'=>'Message',
    'created_at'=>'Created Date',
    'updated_at'=>'Updated Date',
    ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'contactList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
 }

 private function requestUserData($request){
    return
    [
        'user_id'=> auth()->user()->id,
        'name'=>$request->name,
        'email'=>$request->email,
        'message'=>$request->message,
    ];
 }

}
