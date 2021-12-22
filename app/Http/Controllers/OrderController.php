<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use bilawalsh\cart\Models\Order;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    protected $view = 'orders';
    public function index()
    {
        $view = $this->view;
        $orders = Order::with('products')->where('supplier_id', Auth::id())->get();
        
        return view('mycomponent.datatable', compact('orders', 'view'));
    }

    public function updateStatus(Request $request)
    {
        // dd($request->all());
        $order = Order::find($request->order_id);
        Order::where('id', $request->order_id)->update([
            'order_status' => $request->order_status
        ]);
        if($request->order_status == 3){
            if($request->cas == "Admin"){
                $a = activity()->log('Look mum, I logged something');
                $a->subject_type = "Order";
                $a->subject_id = $order->order_number;
                $a->causer_type = $request->cas;
                $a->properties = 1;
                $a->action = "Order Delivered";
                $a->comments = preg_replace('/[^a-z A-Z]+/','', $request->message);
                $a->save();
            }else{
                $a = activity()->log('Look mum, I logged something');
                $a->subject_type = "Order";
                $a->subject_id = $order->order_number;
                $a->causer_type = $request->cas;
                $a->properties = 1;
                $a->action = "Order Delivered";
                $a->comments = preg_replace('/[^a-z A-Z]+/','', $request->message);
                $a->save();
            }
            
        }else if($request->order_status == 2){
            $a = activity()->log('Look mum, I logged something');
                $a->subject_type = "Order";
                $a->subject_id = $order->order_number;
                $a->causer_type = "Admin";
                $a->properties = 1;
                $a->action = "Order Delivered";
                $a->comments = preg_replace('/[^a-z A-Z]+/','', $request->message);
                $a->save();
        }

        return back();
        

        //return trans('message.Success_updated');

    }
    public function updateQuantity(Request $request)
    {
        Order::where('id', $request->order_id)->update([
            'shipped_with_min_qty' => $request->req_min_qty
        ]);

        return back();
    }

    public function orderModify(Request $request)
    {

        $order = Order::find($request->order_id);
        $order->product_id = $request->product_id;
        $order->qty = $request->qty;
        $order->total = $request->price;
        $order->save();
        return redirect('customer/myorders');
    }


    public function removeItemOrder($id, $prod)
    {
        $order = Order::find($id);
        $product_id = json_decode($order->product_id);
        $qty = json_decode($order->qty);
        $min_qty = json_decode($order->min_qty);
        $size = sizeof($product_id);
        $new_product_id = array();
        $new_qty = array();
        $new_min_qty = array();
        for ($i = 0; $i < $size; $i++) {
            if ($product_id[$i] == $prod)
                continue;
            $new_product_id[] = $product_id[$i];
            $new_qty[] = $qty[$i];
            $new_min_qty[] = $min_qty[$i];
        }
        $order->product_id = json_encode($new_product_id);
        $order->min_qty = json_encode($new_min_qty);
        $order->qty = json_encode($new_qty);
        $order->save();
        return back()->with('success', 'Item deleted from cart');
    }
}
