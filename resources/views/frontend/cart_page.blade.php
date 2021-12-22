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
        .total{
            font-size:26px;
        }
        </style>
<div class="container my-4">
    {{-- main card showing all order --}}
    <div class="card">
        <div class="card-header" style="background-color:rgb(236, 96, 127)

        ">
            <div class="col-12">
                <div class="row">
                    <div class="col-9">
                    </div>
                    <div class="col-2">
                        <a href="" class="btn" style="background-color: black;color:white
                        ">Order for another supplier</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{-- inner order card   --}}
            @php $id_array = [];
                $total = 0;
            @endphp
            @foreach($carts as $cart)

               
                @php
                    $prod = App\Models\Product::find($cart->product_id);
                    $sup = App\Models\Supplier::find($cart->supplier_id);
                    $date = explode(" ",$cart->created_at);

                @endphp
            <div class="card">
                @if(!in_array($sup->id,$id_array))
                <div class="card-header" style="background-color: rgb(236, 96, 127) ">
                        <section class="col-md-12">
                            <div class="row">
                                <div class="col-10">
                                    <table class="">
                                        <thead>
                                            
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
                                                    <h5> Date : </h5>
                                                </th>
                                                <th class="text-left px-2">
                                                    <h6> {{ $date[0] }} </h6>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-2 my-4">
                                    @php $c = App\Models\Cart::where('supplier_id',$sup->id)->get();
                                    $total = 0;
                                        foreach($c as $data){
                                            $total = $total + $data->total;
                                        }
                                    @endphp
                                    <tr>
                                        <td>
                                            <h4 class="total">Total: <span>€{{$total}}</span>
                                            </h4>
                                        </td>
                                    </tr>
                                </div>
                            </div>
                        </section>
                    </div>
                   
                <div class="card-header" style="background-color: rgb(236, 96, 127) ">
                    <div class="col-12">
                    <div class="row">
                        <!-- <div class="col-2">id#</div> -->
                        <div class="col-2 heading">Item</div>
                        <div class="col-2 heading">Quantity</div>
                        <div class="col-2 heading">Minimum Quantity</div>

                        <!-- <div class="col-2 heading">Supplier</div> -->
                        <div class="col-2 heading">Unit</div>
                        <div class="col-2 heading">Total</div>
                    </div>
                </div>
                </div>
               
                @endif
               
                <div class="card-body">
                    <div class="col-12">
                    <div class="row mb-2">
                        <!-- <div class="col-2">1</div> -->

                        <div class="col-2">{{ $prod->name }}</div>
                        <div class="col-2">{{ $cart->qty }}</div>
                        <div class="col-2">{{ $cart->min_qty }}</div>

                        <!-- <div class="col-2">{{ $sup->first_name }}  {{ $sup->last_name }}</div> -->
                        <div class="col-2">
                        {{ $prod->unit->name }}
                        </div>
                        <div class="col-2">
                        {{ $cart->total }}
                        </div>
                    </div>
                
                </div>
               
                </div>
                @if(in_array($sup->id,$id_array))
                <div class="card-footer">
                       <div class=" d-flex flex-col-reverse float-right">
                        <a href="#" style="background:#a54f18;color:white" class="btn mx-1 ">modifiy</a>
                        <button onclick="confirm({{$sup->id}})" style="background:#f5b0c7;color:white" class="btn mx-1 ">confrim</button>

                       </div>
                </div>
                @endif
            </div>
            @php array_push($id_array,$sup->id); @endphp
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                            
                            
                            function confirm(id){

                               

                                $.ajax({
                                    "url" : "{{ route('confirm_order') }}",
                                    "method" : "GET",
                                    "type" : "json",
                                    "data" : {
                                        id:id,
                                       
                                    },
                                    success: function(data){
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'success',
                                            title: 'Your Order is confirmed',
                                            text: "Your Order Id is "+data.data,
                                            showConfirmButton: false,
                                            timer: 1500
                                        });

                                        window.location = "/cart_page";

                                       
                                        
                                    }
                                });

                                
                            }
                            
                            
                            
                        </script>
               
            @endforeach
            {{-- iner card end --}}

        
        {{-- iner card end --}}


        </div>



    </div>
</div>


@endsection
