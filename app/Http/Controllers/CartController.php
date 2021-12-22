<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Unit;
use App\Models\Order;



class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        dd($request->all());
        $prod = Product::find($request->p_id);
        $unit = Unit::find($prod->unit_id);
        $sup = User::role('Supplier')->find($request->s_id);
        if ($request->checked == 1) {
            $data = [
                'cust_id' => auth()->user()->id,
                'prod_id' => $prod->id,
                'sup_id' => $sup->id,
                'qty' => $request->qty,
                'total' => $request->total,
                'price' => $prod->price,
                'unit' => $unit->name,
                'qty1' => $request->qty1,
                'catid' => $request->catid,
            ];
            session()->push('all_cart_data' . $prod->id, $data);
            //session()->get('all_cart_data' . $prod->id)->forget();
            // dd(session()->all());
        } else {
            $cartcheck = Cart::where('customer_id', auth()->user()->id)->where('product_id', $prod->id)->first();
            if ($cartcheck) {
                $cartcheck->delete();
            }
        }
    }


    public function addToCartt(Request $request)
    {
        $products = Product::all();
        $prod = Product::find($request->p_id);
        $unit = Unit::find($prod->unit_id);
        $sup = User::role('Supplier')->find($request->s_id);
        foreach ($products as $prod) {
            $data = session()->get('all_cart_data' . $prod->id);
            if ($data != null) {
                // dd($data);
                $cart = new Cart();
                $cart->customer_id = $data[0]['cust_id'];
                $cart->product_id = $data[0]['prod_id'];
                $cart->supplier_id = $data[0]['sup_id'];
                $cart->price = $data[0]['price'];
                $cart->qty = $data[0]['qty'];
                $cart->total = $data[0]['total'];
                $cart->unit = $data[0]['unit'];
                $cart->min_qty = $data[0]['qty1'];
                $cart->category_id = $data[0]['catid'];
                $cart->save();
            }
            session()->put('all_cart_data' . $prod->id, []);
        }
        return redirect('/customer/suppliers');
    }


    public function confirmOrder(Request $request)
    {


        $sup = User::role('Supplier')->find($request->id);
        $c = Cart::where('supplier_id', $sup->id)->get();
        $total = 0;
        $qty = [];
        $min_qty = [];
        $product_ids = [];
        foreach ($c as $data) {
            $total = $total + $data->total;
            array_push($qty, $data->qty);
            array_push($min_qty, $data->min_qty);
            array_push($product_ids, $data->product_id);
        }
        $order = new Order();
        $order->order_number = rand(456788, 100000000);
        $order->customer_id = auth()->user()->id;
        $order->product_id = json_encode($product_ids);
        $order->supplier_id = $sup->id;
        $order->qty = json_encode($qty);
        $order->min_qty = json_encode($min_qty);
        $order->total = $total;
        $order->save();
        foreach ($c as $data) {
            $data->delete();
        }
        $response = [
            'data' => $order->order_number
        ];
        return response(json_encode($response));
    }

    public function removeItem($id)
    {

        Cart::find($id)->delete();

        return back()->with('success', 'Item deleted from cart');
    }
}
