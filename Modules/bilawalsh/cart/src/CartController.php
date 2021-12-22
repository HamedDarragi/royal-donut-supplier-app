<?php

namespace bilawalsh\cart;

use Exception;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\CompanySupplier;
use bilawalsh\cart\Models\Cart;
use Illuminate\Support\Facades\DB;
use bilawalsh\cart\Models\CartItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $suppliers = User::role('Supplier')->get();

        return view('customer.cart_page', compact('suppliers'));
    }
    public function add(Request $request)
    {
        $size = sizeof($request->product_id);

        // dd($request->all());
        for ($i = 0; $i < $size; $i++) {
            try {
                if ($request->quantity[$i] < $request->min_qty[$i]) {
                    Session::flash('success', 'Required Quantity Must be greater than Minimum Quantity');
                    return back();
                }
            } catch (Exception $e) {
                continue;
            }
        }
        // $size = 0;
        // $size = sizeof($request->product_id);
        // for ($i = 0; $i < $size; $i++) {
        //     if ($request->quantity[$i] < 0 || !empty($request->quantity[$i])) {
        //         continue;
        //     }
        //     if (isset($request->min_qty[$request->product_id[$i]]))
        //         if ($request->quantity[$i] < $request->min_qty[$request->product_id[$i]]) {
        //             Session::flash('success', 'Required Quantity Must be greater than Minimum Quantity');
        //             return back();
        //         }
        // }

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
                    $all_cart = Cart::all();
                    $cart_exist = Cart::where(['user_id' => Auth::id(), 'supplier_id' => $product->supplier_id])->first();
                    $delivery_com = CompanySupplier::where('supplier_id', $product->supplier_id)->first();
                    // dd($cart_exist);
                    if (empty($cart_exist)) {
                        $cart = new Cart;
                        $cart->item_count = $count;
                        $cart->supplier_id = $product->supplier_id;
                        $cart->total = $total_price;
                        $cart->grand_total = $total_price;
                        if ($delivery_com != null) {
                            $find_cart_with_same_delivery_company = Cart::where('delivery_supplier_id', $delivery_com->delivery_company_id)->first();
                            if ($find_cart_with_same_delivery_company == null) {
                                $cart->delivery_supplier_id = $delivery_com->delivery_company_id;
                                $cart->parent = null;
                            } else {
                                $cart->delivery_supplier_id = $delivery_com->delivery_company_id;
                                $cart->parent = $find_cart_with_same_delivery_company->id;
                            }
                        }
                    } else {
                        $cart = Cart::find($cart_exist->id);
                        $cart->item_count =  $size;
                        $cart->total = $total_price;
                        $cart->grand_total =  $total_price;
                    }
                    if (Auth::check()) {
                        $cart->user_id = Auth::id();
                    }
                    $cart->ip_address = $ip;

                    $cart->save();

                    // for ($i = 0; $i < $size; $i++) {

                    $cart_item = new CartItem;
                    if (empty($cart_exist)) {
                        $cart_item->cart_id = $cart->id;
                    } else {
                        $cart_item->cart_id = $cart_exist->id;
                    }
                    $cart_item->product_id = $request->product_id[$i];
                    $cart_item_exist = CartItem::where('product_id', $request->product_id[$i])->first();
                    $product = Product::find($request->product_id[$i]);
                    // $unit = Unit::find($product->unit_id);
                    $min_quantity = 0;
                    if (!empty($cart_item_exist)) {
                        $cart_item = CartItem::find($cart_item_exist->id);
                        $cart_item->quantity =  $request->quantity[$i];
                        if (empty($request->min_qty[$i]))
                            $min_quantity = 0;
                        else
                            $min_quantity = $request->min_qty[$i];
                        $cart_item->min_quantity = $min_quantity;
                        $cart_item->unit_price = $cart_item_exist->unit_price;
                    } else {
                        if (empty($request->min_qty[$i]))
                            $min_quantity = 0;
                        else
                            $min_quantity = $request->min_qty[$i];
                        $cart_item->min_quantity = $min_quantity;
                        $cart_item->quantity = $request->quantity[$i];
                        $cart_item->unit_price = $product->price;
                    }
                    $cart_item->save();
                }
            }


            if ($count == 0) {
                Session::flash('success', 'Put Quantity Greater than 0');
                return redirect('customer/cart');
            }

            DB::commit();
            Session::flash('success', 'Item added successfully');
            return redirect('customer/cart');
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    public function cartItemRemove($cart, $product)
    {

        $cart = Cart::find($cart);
        $cartItem = $cart->products()->where('product_id', $product)->first();
        $cart->update([
            'item_count' => $cart->item_count - $cartItem->pivot->quantity,
            'total' => $cart->total - ($cartItem->pivot->quantity * $cartItem->price),
            'grand_total' => $cart->grand_total - ($cartItem->pivot->quantity * $cartItem->price),
        ]);
        $cart->products()->detach($product);
        if ($cart->products()->get()->count() < 1) {
            if ($cart->parent == null) {
                $find_first_cart_child = Cart::where('parent', $cart->id)->first();
                $find_cart_children = Cart::where('parent', $cart->id)->get();
                foreach ($find_cart_children as $cart_child) {
                    if ($find_first_cart_child->id != $cart_child->id) {
                        $cart_child->update(['parent' => $find_first_cart_child->id]);
                    } else {
                        $cart_child->update(['parent' => null]);
                    }
                }
            }
        }
        if ($cart->products()->get()->count() < 1)
            $cart->delete();
        Session::flash('success', 'item Remove');
        return redirect('customer/cart');
    }

    public function cartItemIncrement(Request $request)
    {
        $cart = Cart::find($request->id);
        $cartItem = $cart->products()->where('product_id', $request->product_id)->first();
        $cart->update([
            'item_count' => ($cart->item_count - $cartItem->pivot->quantity) + $request->quantity,
            'total' => ($cart->total - ($cartItem->pivot->quantity * $cartItem->price_euro)) + ($request->quantity * $cartItem->price_euro),
            'grand_total' => ($cart->grand_total - ($cartItem->pivot->quantity * $cartItem->price_euro)) + ($request->quantity * $cartItem->price_euro),
        ]);
        $cartItem->pivot->update([
            'quantity' => $request->quantity,
        ]);
        return "item update";
    }
}
