<?php

namespace bilawalsh\cart;

use Exception;
use App\Models\Product;
use App\Models\User;
use App\Models\Unit;


use bilawalsh\cart\Models\Cart;
use bilawalsh\cart\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DeliveryInformation;
use bilawalsh\cart\Models\OrderItem;
use bilawalsh\cart\Models\CartItem;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use IPQualityScore\IPQualityScore;

class OrderController extends Controller
{
    public function orderConfirmed($id,$comments=null,$date)
    {
        // dd($comments);
        // dd(str_contains($id, ','));
        // dump($id);
        $cart_ids = [];
        if (str_contains($id, ',') == true) {
            $cart_ids = explode(',', $id);
        } else if (str_contains($id, ',') == false) {
            $cart_ids[] = $id;
        }

        // dump($cart_ids);
        try {
            foreach ($cart_ids as $single_cart_id) {
                // dump($single_cart_id);
                $cart = Cart::with('products')->find($single_cart_id);
                // dump($cart);
                $user = User::find(auth()->user()->id);
                $supplier = User::find($cart->supplier_id);
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

                DB::beginTransaction();

                $order_id =  rand(1111, 9999) . Auth::id() . $cart->id;
                $order = Order::create([
                    'order_no' => $order_id,
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
                    'delivery_date' => $date,
                ]);

                $a = activity()->log('Look mum, I logged something');
                $a->subject_type = "Order";
                $a->subject_id = $order->order_number;
                $a->causer_type = "Customer";
                $a->properties = 1;
                $a->action = "Order Confirmed";
                if($comments !=0){
                    $a->comments = $comments;

                }
                $a->save();
                DeliveryInformation::where('order_id', $cart->id)->where('supplier_id',$supplier->id)->update(['order_id' => $order_id]);
                foreach ($cart->products as $product) {

                    if ($product->quantity < $product->pivot->quantity) {
                        $delete_cart_associated_with_parent = Cart::where('parent', $single_cart_id)->get();
                        foreach ($delete_cart_associated_with_parent as $delete_child_cart) {
                            $cart_itemss = CartItem::where('cart_id', $delete_child_cart->id)->get();
                            foreach ($cart_itemss as $item) {
                                $item->delete();
                            }
                            $delete_child_cart->delete();
                        }

                        Session::flash('success', $product->name . ' Quantity not available');
                        return redirect('customer/suppliers');
                    }
                    $product->update([
                        'quantity' => $product->quantity - $product->pivot->quantity
                    ]);
                    $prod = Product::find($product->pivot->product_id);

                    // $p = Product::find($product->pivot->product_id);
                    $u = Unit::find($prod->unit_id);



                    $orderItem =  new OrderItem;
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $prod->id;
                    $orderItem->product_name = $prod->name;
                    $orderItem->quantity = $product->pivot->quantity;
                    $orderItem->min_quantity = $product->pivot->min_quantity;
                    $orderItem->unit_price = $product->pivot->unit_price;
                    $orderItem->unit_name = $u->name;

                    // $orderItem->unit = $product->pivot->unit_price;
                    $orderItem->save();
                }

                $cart_itemss = CartItem::where('cart_id', $cart->id)->get();
                foreach ($cart_itemss as $item) {
                    $item->delete();
                }
                $cart->delete();
                DB::commit();
            }
            // dd("ENNNNNN");
            $check_cart_for_redirect = Cart::where('user_id', Auth::id())->first();
            if (empty($check_cart_for_redirect)) {
                Session::flash('success', 'Order Placed Successfully');
                return redirect('customer/myorders');
            } else {
                Session::flash('success', 'Order Placed Successfully');
                return back();
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
