<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

use Illuminate\Support\Facades\Http;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function new_order()
     {
    $view='order';
    $response = Http::get('http://127.0.0.1:7000/api/cart');
    $orders=$response->body();
    $orders =json_decode($orders);
    return view('mycomponent.datatable',compact('orders', 'view'));
     }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function confirm_order(Request $request)
    {
      $request->validate([
          'customer_id'=>'required',
          'product_id'=>'required',
          'min_qty'=>'required',
          'req_qty'=>'required'
      ]);

            $product=Product::find($request->product_id);
            $price=$product->price;
      if($request->sel_min_qty != null)
      {
            $total=$request->sel_min_qty*$price;
            $sel_qty="minimum";
      }
      else if($request->sel_req_qty != null)
      {
            $total=$request->sel_req_qty*$price;
            $sel_qty="required";
      }

      Order::create([
            'customer_id'=>$request->customer_id,
            'product_id'=>$request->product_id,
            'min_qty'=>$request->min_qty,
            'req_qty'=>$request->req_qty,
            'total'=>$total,
            'sel_qty'=>$sel_qty,
            'status'=>1
      ]);

      return back();
    }
}
