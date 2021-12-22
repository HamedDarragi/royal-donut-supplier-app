<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Email;
use App\Models\User;

use Illuminate\Support\Facades\Mail; 
use App\Mail\SupplierMail;
use bilawalsh\cart\Models\Order;

class SettingsController extends Controller
{
    public function footer(){
        $setting = Setting::first();
        return view('admin.settings.footer',compact('setting'));
    }

    public function footerUpdate(Request $request){

        if(isset($request->update)){
            $setting = Setting::find($request->id);

            if(!empty($request->description)){
                $setting->description = $request->description;
                $setting->save();
            }
    
        }

        if(isset($request->create)){
            $setting = new Setting();

            if(!empty($request->description)){
                $setting->description = $request->description;
                $setting->save();
            }
    
        }
        
        return back()->with('success','Footer Signature Updated');

    }



    public function title(){
        $setting = Setting::first();
        return view('admin.settings.title',compact('setting'));
    }

    public function titleUpdate(Request $request){

        $this->validate($request,[
            'title' => 'max:255',
        ]);
        $setting = Setting::find($request->id);

        if(!empty($request->title)){
            $setting->title = $request->title;
            $setting->save();
        }

        return back()->with('success','Title Updated');

    }



    public function email(Request $request,$id){
        
        $setting = Setting::first();
        $order = Order::find($id);
        $o_num = explode('-',$order->order_number);
        $customer = User::find($order->user_id);
        $message = preg_replace('/[^a-z A-Z]+/','', $request->message);

        $supplier = User::where('abbrivation',$o_num[1])->first();

        return view('admin.settings.email',compact('setting','order','supplier','customer','message'));
    }


    public function emailSend(Request $request){

        // dd($request->all());
        // $order = json_decode($request->order);
        $order = Order::find($request->order);
        $customer = User::find($order->user_id);
        $o_num = explode('-',$order->order_number);
        $supplier = User::where('abbrivation',$o_num[1])->first();
        // dd($order);
        $header = $request->header;
        $footer = $request->footer;
        $message = "";
        try{
            Mail::to($supplier->email)->send(new SupplierMail($order,$header,$footer,$supplier,$customer));
            $email = new Email();
            $email->subject = $header;
            $email->message = "Email sent Successfully";
            $email->status = 1;
            $email->order_number = $order->order_number;

            $email->save();
            $order->order_status = 4;
            $order->save();

            $a = activity()->log('Look mum, I logged something');
            $a->subject_type = "Email";
            $a->subject_id = "EMAIL-".$email->id;
            $a->causer_type = "Admin";
            $a->properties = 1;
            $a->action = "Email Sent";

            $a->save();

            $a = activity()->log('Look mum, I logged something');
            $a->subject_type = "Order";
            $a->subject_id = $order->order_number;

            $a->causer_type = "Admin";
            $a->properties = 1;
            $a->action = "Order Treated";
            $a->comments = $request->message;

            $a->save();

            return redirect('/orders')->with('success','Email sent successfully');
        }catch(\Exception $e){
            $email = new Email();
            $email->subject = $header;
            $email->message = $e->getMessage();
            $email->order_number = $order->order_number;
            $email->status = 0;

            $email->save();

            $a = activity()->log('Look mum, I logged something');
            $a->subject_type = "Email";
            $a->subject_id = "EMAIL-".$email->id;

            $a->causer_type = "Admin";
            $a->properties = 0;
            $a->action = "Email Not Sent";
            
            $a->save();

            return redirect('/orders')->with('success','Email Error...Check your logs please');

        }
        
    }



    public function emailHistory(){
        $emails = Email::paginate(4);

        return view('admin.settings.emailhistory',compact('emails'));
    }



    public function chek(){
        
        $order = Order::find(6);
        $header = "It is Header";
        $footer = "It is Footer";
        return view('admin.settings.sendemail',compact('order','header','footer'));
    }
}
