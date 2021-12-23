<?php

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Catalog\ProductController;
use App\Http\Controllers\Catalog\CustomerController;
use App\Models\AssociateRule;
use App\Models\Date;
use App\Models\DeliveryInformation;
use App\Models\Rule;
use Illuminate\Http\Request;
use bilawalsh\cart\Models\Cart as ModelsCart;

Route::prefix('customer')->middleware(['auth', 'role:Customer'])->group(function () {

    Route::get('suppliers', [CustomerController::class, 'getSupplier']);
    Route::post('order/modified', [OrderController::class, 'orderModify']);

    Route::get('rectify', [CustomerController::class, 'rectifyOrders']);


    Route::get('/supplierdetails/{id}', function ($id) {
        $supplier = User::IsActive()->role('Supplier')->find($id);
        $products = Product::IsActive()->where('supplier_id', $id)->whereNull('category_id')->get();
        $categories = Category::with([
            'products' => function ($query) use ($id) {
                $query->IsActive()->where('supplier_id', $id);
            }
        ])->IsActive()->where('isActive', 1)->get();
        return view('customer.supplier_detail', compact('supplier', 'categories', 'products'));
    })->name('supplierdetails');


    Route::get('/supplier-cart-modify/{id}', function ($id) {
        $supplier = User::IsActive()->role('Supplier')->find($id);
        $products = Product::IsActive()->where('supplier_id', $id)->whereNull('category_id')->get();
        $categories = Category::with([
            'products' => function ($query) use ($id) {
                $query->IsActive()->where('supplier_id', $id);
            }
        ])->IsActive()->where('isActive', 1)->get();
        return view('customer.cart_modify', compact('supplier', 'categories', 'products', 'id'));
    });

    Route::get('cart', function () {
        // $suppliers = User::role('Supplier')->get();
       $suppliers = ModelsCart::all();
        return view('customer.cart_page', compact('suppliers'));
    })->name('cart_page');


    Route::get('/myorders', function () {
        $orders = \bilawalsh\cart\Models\Order::with('products')
                                            ->paginate(5);
;
                    // dd($orders);
        return view('customer.myorder', compact('orders'));
    });

    Route::get('purchased', function () {
        $orders = \bilawalsh\cart\Models\Order::where(['customer_id' => auth()->user()->id, ['status', '!=', 'Not confirmed']])->get();
        return view('customer.purchased', compact('orders'));
    });

    // Route::get('product/category', [ProductController::class, 'productsByCategory'])->name('customer.product.category');

    // Route::get('session_add_to_cart', [CartController::class, 'addToCart'])->name('session_add_to_cart');
    // Route::get('add_to_cart', [CartController::class, 'addToCartt'])->name('add_to_cart');

    Route::post('confirm_order', [CartController::class, 'confirmOrder'])->name('confirm_order');

    Route::get('remove/{id}', [CartController::class, 'removeItem'])->name('remove_item');
    Route::get('remove/order/{id}/{prod}', [OrderController::class, 'removeItemOrder'])->name('remove_item_order');


    Route::post('get_rule', function (Request $request) {
        // dd($request->all());
        $associate_rule = AssociateRule::where('customer_id', $request->customer_id)->where('supplier_id', $request->supplier_id)->first();
        // dd($associate_rule);
        if ($associate_rule != null) {
            $rule = Rule::find($associate_rule->rule_id);
            return response()->json($rule);
        } else {
            return response()->json("empty");
        }
    });

    Route::post('check_db', function (Request $request) {
        $date = Date::where('c_date', $request->date)->first();
        // dd($request->date);
        if ($date != null) {
            return response()->json(['db' => true, 'data' => $date]);
        } else {
            return response()->json(['db' => false, 'data' => $request->date]);
        }
    });

    Route::post('get_cart_from_delivery_supplier', function (Request $request) {
        if ($request->delivery_supp_id != null) {
            $carts = ModelsCart::where('delivery_supplier_id', $request->delivery_supp_id)->get();
            $cart_id = [];
            foreach ($carts as $cart) {
                $cart_id[] = $cart->id;
            }
            return response()->json(['data' => $cart_id]);
        }
    });

    Route::post('submit_delivery_data', function (Request $request) {
        // dd($request->message);
        // if(isset($request->cart_id)){
            foreach ($request->cart_id as $cart_id) {
                $delivery = new DeliveryInformation();
                $delivery->order_id = $cart_id;
                $delivery->customer_id = $request->customer_id;
                $delivery->supplier_id = $request->supplier_id;
                $delivery->treatment_time = $request->treatment_time;
                $delivery->delivery_day = $request->delivery_date;
                $delivery->save();
            }

            
        // }
        
        $response = ['data' => $request->cart_id,
                    'message' => preg_replace('/[^a-z A-Z]+/','', $request->message),
                'date' => $request->delivery_date];
                // dd($response);
        return response()->json(['redirect' => true, $response]);
    })->name('submit_delivery');
});
