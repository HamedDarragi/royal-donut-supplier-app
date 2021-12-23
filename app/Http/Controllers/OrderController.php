<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use bilawalsh\cart\Models\Order;
use bilawalsh\cart\Models\OrderItem;

use Illuminate\Support\Facades\Auth;
use App\Models\RectifyOrder;
use App\Models\RectifyOrderItem;
use App\Models\User;

use Illuminate\Support\Facades\DB;


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


    public function rectifyOrder(Request $request){

        $o = Order::find($request->order_id);
        $order_items = OrderItem::where('order_id',$o->id)->get();
        $sup = User::role('Supplier')->where('abbrivation',explode('-',$o->order_number)[1])->first();

        // dump($sup);
        // dump($order_items);
        // dump($o);

        // dd($request->all());

        try{
            DB::beginTransaction();


            $order = RectifyOrder::create([
                'order_no' => $o->order_no,
                'order_number' => $o->order_number,
                'user_id' => $o->user_id,
                'user_name' => $o->user_name,
                'supplier_name' => $o->supplier_name."-".$sup->id,
                'item_count' => $o->item_count,
                'total' => $o->total,
                'order_status' => RectifyOrder::RECTIFIED,
                'discount' => $o->discount,
                'taxes' => 0,
                'grand_total' => $o->grand_total,
                'delivery_date' => $o->delivery_date,
            ]);

            foreach($order_items as $orderitem){
                $orderItem =  new RectifyOrderItem;
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $orderitem->product_id;
                $orderItem->product_name = $orderitem->product_name;
                $orderItem->quantity = $orderitem->quantity;
                $orderItem->min_quantity = $orderitem->min_quantity;
                $orderItem->unit_price = $orderitem->unit_price;
                $orderItem->unit_name = $orderitem->unit_name;
    
                // $orderItem->unit = $product->pivot->unit_price;
                $orderItem->save();

            }
            // dd($order_items);

            foreach($order_items as $orderitem){
                $orderitem->delete();

            }

            $o->delete();
           
    
    
            $a = activity()->log('Look mum, I logged something');
                    $a->subject_type = "Order";
                    $a->subject_id = $order->order_number;
                    $a->causer_type = "Admin";
                    $a->properties = 1;
                    $a->action = "Order Rectified";
                    if($request->message){
                        $a->comments = $request->message;
    
                    }
                    $a->save();

            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }

        return back()->with('success','Order Rectified Successfully');
        
    }
}
