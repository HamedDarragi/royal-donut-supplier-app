@extends('admin.layout.app')
@section('content')
<style type="text/css">
    .thead th,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        color: white;
    }

    .thead,
    .card-header {
        background-color: rgb(236, 96, 127);
    }

    .total {
        font-size: 28px;
    }
</style>
<div class="card my-5">
    <div class="card-header">
        <h3 class="card-title">My Orders</h3>
        <div class="card-options">
            <span class="input-group-btn mx-2">
                <!-- <a class="btn">
                            <span class="fe fe-filter text-white" type="datepicker"></span>
                        </a> -->
            </span>
            <form>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" placeholder="Search something..." name="s">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <span class="fe fe-search" style="color:pink"></span>
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    @foreach($orders as $order)
    @php
    $prod_ids = json_decode($order->product_id);

    $sup = App\Models\Supplier::find($order->supplier_id);
    $date = explode(" ",$order->created_at);


    @endphp
    <section class="orderdetails my-2 col-md-12">
        <div class="card">
            <div class="card-header">
                <section class="col-md-12">
                    <div class="row">
                        <div class="col-10">
                            <table class="">
                                <thead>
                                    <tr>
                                        <th class="text-right px-2">
                                            <h5>Order# : </h5>
                                        </th>
                                        <th class="text-left px-2">
                                            <h6> {{$order->order_number}}</h6>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="text-right px-2">
                                            <h5>Supplier : </h5>
                                        </th>
                                        <th class="text-left px-2">
                                            <h6> {{$sup->first_name}} {{$sup->last_name}} </h6>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="text-right px-2">
                                            <h5>Order Date : </h5>
                                        </th>
                                        <th class="text-left px-2">
                                            <h6> {{ $date[0] }} </h6>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-2 my-4">
                            <tr>
                                <td>
                                    <h4 class="total">Total: <span>€{{$order->total}}</span>
                                    </h4>
                                </td>
                            </tr>
                        </div>
                    </div>
                </section>
            </div>
            <div class="card-body">
                <table class="table table-bordered text-center rounded-lg">
                    <thead class="thead">
                        <tr>

                            <th scope="col">Item</th>
                            <th scope="col">Price/unit</th>


                            <th scope="col">Minimum Quantity</th>
                            <th scope="col">Unit</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($prod_ids as $id)
                        @php $prod = App\Models\Product::find($id); @endphp
                        <tr>
                            <td scope="row">{{ $prod->name }}</td>
                            <td scope="row">{{ $prod->price }}</td>


                            <td scope="row">{{$order->min_qty}}</td>
                            <td scope="row">{{$prod->unit->name}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="col-12">
                    <div class="row">
                        <div class="col-10 float-left"></div>
                        <div class="col-2 float-right text-right">
                            <span class="btn btn-success ">{{ $order->status }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endforeach



</div>
@endsection
