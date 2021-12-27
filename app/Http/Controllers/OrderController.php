<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use bilawalsh\cart\Models\Order;
use bilawalsh\cart\Models\OrderItem;

use Illuminate\Support\Facades\Auth;
use App\Models\RectifyOrder;
use App\Models\RectifyOrderItem;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;



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

            return back()->with('success','Order Rectified Successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }

        
        
    }

    public function removeRectifyOrders($id,$item_id){

       

        try{
            DB::beginTransaction();

            RectifyOrderItem::find($item_id)->delete();
            $orderItem =  RectifyOrderItem::where('order_id',$id)->get();
            if(count($orderItem) <= 0){
                RectifyOrder::find($id)->delete();

                DB::commit();
                \Session::flash('success', 'Rectify Order Item Removed');
                return redirect('customer/suppliers');
            }else{
                DB::commit();
                \Session::flash('success', 'Rectify Order Item Removed');
                return back();
            }

            

        }catch(\Exception $e){
            DB::rollBack();

            \Session::flash('success', 'Rectify Order Item Not Removed');
            return back();

            // return $e->getMessage();
        }
        


    }

    public function modifyRectifyOrders($supid){

        // dd($supid);
        $id = explode("-",$supid)[1];
        $supplier = User::IsActive()->role('Supplier')->find($id);
        $products = Product::IsActive()->where('supplier_id', $id)->whereNull('category_id')->get();
        $categories = Category::with([
            'products' => function ($query) use ($id) {
                $query->IsActive()->where('supplier_id', $id);
            }
        ])->IsActive()->where('isActive', 1)->get();

        return view('customer.modifyrectify', compact('supplier', 'categories', 'products', 'id','supid'));

    }


    public function add(Request $request,$name)
    {

        // dd($request->all());
        $size = sizeof($request->product_id);

        // dd($request->all());
        for ($i = 0; $i < $size; $i++) {
            try {
                if ($request->quantity[$i] < $request->min_qty[$i]) {
                    \Session::flash('success', 'Required Quantity Must be greater than Minimum Quantity');
                    return back();
                }
            } catch (Exception $e) {
                continue;
            }
        }
       

        $count = 0;
        DB::beginTransaction();
        try {
            $size = 0;
            $size = sizeof($request->product_id);
            $ip = $request->ip();
            $total_price = 0;
            for ($i = 0; $i < $size; $i++) {
                // if ($request->quantity[$i] == 0)
                //     continue;
                // else
                if ($request->quantity[$i] > 0) {
                    $count++;
                    $product = Product::find($request->product_id[$i]);
                    $total_price = $total_price + ($product->price * $request->quantity[$i]);
                    // }
                    $all_cart = RectifyOrder::all();
                    $cart_exist = RectifyOrder::where(['user_id' => Auth::id(), 'supplier_name' => $name])->first();
                    // $delivery_com = CompanySupplier::where('supplier_id', $product->supplier_id)->first();
                    // dd($cart_exist);
                    if (!empty($cart_exist)) {
                    
                        $cart = RectifyOrder::find($cart_exist->id);
                        $cart->item_count =  $size;
                        $cart->total = $total_price;
                        $cart->grand_total =  $total_price;
                    }
                    if (Auth::check()) {
                        $cart->user_id = Auth::id();
                    }

                    $cart->save();

                    // for ($i = 0; $i < $size; $i++) {

                    
                    $cart_item_exist = RectifyOrderItem::where('product_id', $request->product_id[$i])
                                                ->where('order_id',$cart_exist->id)->first();
                    // dump($cart_item_exist);
                    $product = Product::find($request->product_id[$i]);
                    if ($product->quantity < $request->quantity[$i]) {
                        \Session::flash('success', $product->name . ' Quantity not available');
                        return back();
                    }
                    $unit = Unit::find($product->unit_id);
                    $min_quantity = 0;
                    if (!empty($cart_item_exist)) {
                        $cart_item = RectifyOrderItem::find($cart_item_exist->id);
                        $cart_item->quantity =  $request->quantity[$i];
                        if (empty($request->min_qty[$i]))
                            $min_quantity = 0;
                        else
                            $min_quantity = $request->min_qty[$i];
                        $cart_item->min_quantity = $min_quantity;
                        $cart_item->unit_price = $cart_item_exist->unit_price;
                        $cart_item->save();
                    // dump($cart_item_exist);

                    } else {
                        $cart_item = new RectifyOrderItem;
                        // dump('here');
                    
                        $cart_item->order_id = $cart_exist->id;
                    
                        $cart_item->product_id = $request->product_id[$i];
                        if (empty($request->min_qty[$i]))
                            $min_quantity = 0;
                        else
                            $min_quantity = $request->min_qty[$i];
                        $cart_item->min_quantity = $min_quantity;
                        $cart_item->quantity = $request->quantity[$i];
                        $cart_item->unit_price = $product->price;
                        $cart_item->unit_name = $unit->name;

                        $cart_item->save();
                    }
                    // dump($request->quantity[$i]);
                    
                    // dump($cart_item);
                }
            }

            // dd('jj');
            if ($count == 0) {
                \Session::flash('success', 'Put Quantity Greater than 0');
                return redirect('customer/rectify');
            }

            DB::commit();
            \Session::flash('success', 'Item added successfully');
            return redirect('customer/rectify');
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }


    public function rectifyOrderConfirmed(Request $request){

        
            $cart = RectifyOrder::find($request->order_id);
            $items = RectifyOrderItem::where('order_id',$cart->id)->get();
            // dump($cart);
            $user = User::find(auth()->user()->id);
            $supplier = User::find(explode("-",$cart->supplier_name)[1]);
            $name = substr($supplier->first_name, 0, 2);
            // dd($supplier);
            $year = date("Y");
            // dd($year);
            $n = 1;
            $check = 3;
            $ord = Order::where('supplier_name', $supplier->first_name)->where('user_name', $user->first_name)
                ->where('user_id', $user->id)->latest()->first();
            if (!empty($ord)) {
                $o_num = explode("-", $ord->order_number);
                $o_number = $o_num[3];
                // $o_n = $o_number[0];

                // if(count($o_n) > 0){
                $n = $o_number + 1;

                if ($n > 999) {
                    $check = $check + 1;
                } else if ($n > 9999) {
                    $check = $check + 2;
                }
                // }
            }
        
            try{
                DB::beginTransaction();

                $order_id =  rand(1111, 9999) . Auth::id() . $cart->id;
                $order = Order::create([
                    'order_no' => $cart->order_no,
                    'order_number' => $user->zip_code . "-" . strtoupper($supplier->abbrivation) . "-" . $year . "-" . str_pad($n, $check, 0, STR_PAD_LEFT),
                    'user_id' => $user->id,
                    'user_name' => $user->first_name,
                    'supplier_name' => $supplier->first_name,
                    'item_count' => $cart->item_count,
                    'total' => $cart->total,
                    'order_status' => Order::CONFIRMED,
                    'discount' => $cart->discount,
                    'taxes' => $cart->taxes,
                    'grand_total' => $cart->grand_total,
                    'delivery_date' => $cart->delivery_date,
                ]);
    
                $a = activity()->log('Look mum, I logged something');
                $a->subject_type = "Order";
                $a->subject_id = $order->order_number;
                $a->causer_type = "Customer";
                $a->properties = 1;
                $a->action = "Rectify Order Confirmed";
                if($request->message){
                    $a->comments = $request->message;
    
                }
                $a->save();
                // DeliveryInformation::where('order_id', $cart->id)->where('supplier_id',$supplier->id)->update(['order_id' => $order_id]);
                foreach ($items as $p) {
                    $prod = Product::find($p->product_id);
                    if ($prod->quantity < $p->quantity) {
                        
                        \Session::flash('success', $prod->name . ' Quantity not available');
                        return redirect('customer/rectify');
                    }
                    $prod->update([
                        'quantity' => $prod->quantity - $p->quantity
                    ]);
                    // $prod = Product::find($product->pivot->product_id);
    
                    // $p = Product::find($product->pivot->product_id);
                    $u = Unit::find($prod->unit_id);
    
    
    
                    $orderItem =  new OrderItem;
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $prod->id;
                    $orderItem->product_name = $prod->name;
                    $orderItem->quantity = $p->quantity;
                    $orderItem->min_quantity = $p->min_quantity;
                    $orderItem->unit_price = $p->unit_price;
                    $orderItem->unit_name = $u->name;
    
                    // $orderItem->unit = $product->pivot->unit_price;
                    $orderItem->save();
                }
    
                $cart_itemss = RectifyOrderItem::where('order_id', $cart->id)->get();
                foreach ($cart_itemss as $item) {
                    $item->delete();
                }
                $cart->delete();
                DB::commit();
            
            // dd("ENNNNNN");
            $check_cart_for_redirect = RectifyOrder::where('user_id', Auth::id())->first();
            if (empty($check_cart_for_redirect)) {
                \Session::flash('success', 'Order Placed Successfully');
                return redirect('customer/myorders');
            } else {
                \Session::flash('success', 'Order Placed Successfully');
                return back();
            }
            }catch(\Exception $e){
                DB::rollBack();

              \Session::flash('success', $e->getMessage());
                return back();
            }
        
    }
}
