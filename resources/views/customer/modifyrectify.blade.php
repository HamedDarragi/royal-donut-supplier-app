@extends('admin.layout.app')
@section('content')
<style>
    input {
        /* background: white;
        border:none; */
    }

    .card {
        background: white;
    }

    table {
        background: white;
    }
</style>

<div class="container my-4">
    <section>
        {{-- <h2> {{ $supplier->first_name }} {{ $supplier->last_name }}</h2> --}}
    </section>
</div>

<div style="margin-top:20px;"></div>
<form method="POST" action="{{ route('rectify.add',$supid) }}">
    @csrf
    <center>
        {{-- <img src="{{asset('/images/Category/'. $category->image)}}" alt="" height="120" width="120"
            style="border-radius:50%;margin-bottom:20px;"> --}}
        {{-- <h3> No Category </h3> --}}
    </center>
    @isset($products[0])
    <div class="table my-4 card">
        <div class="table-responsive">
            <table class="table table-bordered border-top mb-0" style="background:white;" id="my-table">
                <thead>
                    <tr>
                        <th width="40px">#</th>
                        <th>Name</th>
                        <th>Unit</th>
                        <th>Price/unit (€)</th>
                        <th>Available Quantity</th>
                        <th>Total (€)</th>
                        <th>Required Quantity</th>
                    </tr>
                </thead>
                <tbody id='table-body'>
                    @csrf
                    @php
                        $order =
                        App\Models\RectifyOrder::where(['supplier_name'=>$supid,'user_id'=>Auth::id()])->first();
                        @endphp
                        @csrf
                        @foreach($category->products as $product)
                        @php
                        
                        $data =
                        App\Models\RectifyOrderItem::where(['product_id'=>$product->id,'order_id'=>$order->id])->first();
                        @endphp
                    <tr>
                        <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                        <th width="40px">{{ $loop->index+1 }}</th>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->unit->name }}</td>
                        <td>
                            <input id="price{{$product->id}}" type="number" style="width:90px;border:none"
                                value="{{ $product->price }}" min="0">
                        </td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            <input id="total{{$product->id}}" type="number" style="width:90px;border:none"
                                value="{{ isset($data->unit_price)? $data->unit_price*$data->quantity: '0' }}" min="0">
                        </td>
                        <td>
                            <input id="qty{{$product->id}}" name="quantity[]" onkeyup="calc({{$product->id}})"
                                type="number" style="width:40px;"
                                value="{{ isset($data->quantity)? $data->quantity: '0' }}" min="0"><br><br>
                            @if($product->min_req_qty == 1)
                            <input type="checkbox" id="min_qty{{$product->id}}" @isset($data->min_quantity)
                            @if($data->min_quantity>0)
                            checked
                            @endif
                            @endisset
                            onclick="minQuantity({{ $product->id}})"
                            style="width:40px;border:none" name=""> Min
                            Quantity
                            <div id="showqty{{$product->id}}"
                                style="{{ isset($data->min_quantity)? '': 'display:none' }}">
                                <input id="qty1{{$product->id}}" type="number" name="min_qty[]" size="5"
                                    style="width:40px"
                                    value="{{ isset($data->min_quantity)? $data->min_quantity: '0' }}" min="0">
                            </div>
                            @else
                            <input id="qty1{{$product->id}}" style="display:none" type="number" name="min_qty[]" size="5"
                                    style="width:40px" value="0" min="0">
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endisset











    @foreach($categories as $category)
    @if($category->products->count() < 1) @continue @endif <center>
        <img src="{{asset('/images/Category/'. $category->image)}}" alt="" height="120" width="120"
            style="border-radius:50%;margin-bottom:20px;">
        <h3>{{$category->name}} </h3>
        </center>
        <div class="table my-4 card">
            <div class="table-responsive">
                <table class="table table-bordered border-top mb-0" style="background:white;" id="my-table">
                    <thead>
                        <tr>
                            <th width="40px">#</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Price/unit (€)</th>
                            <th>Available Quantity</th>
                            <th>Total (€)</th>
                            <th>Required Quantity</th>
                        </tr>
                    </thead>
                    <tbody id='table-body'>
                        @php
                        $order =
                        App\Models\RectifyOrder::where(['supplier_name'=>$supid,'user_id'=>Auth::id()])->first();
                        @endphp
                        @csrf
                        @foreach($category->products as $product)
                        @php
                        $data =
                        App\Models\RectifyOrderItem::where(['product_id'=>$product->id,'order_id'=>$order->id])->first();
                        @endphp
                        <tr>
                            <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                            <th width="40px">{{ $loop->index+1 }}</th>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->unit->name }}</td>
                            <td>
                                <input id="price{{$product->id}}" type="number" style="width:90px;border:none"
                                    value="{{ $product->price }}" min="0">
                            </td>
                            <td>{{ $product->quantity }}</td>
                            <td>

                                <input id="total{{$product->id}}" type="number" style="width:90px;border:none"
                                    value="{{ isset($data->unit_price)? $data->unit_price*$data->quantity: '0' }}"
                                    min="0">
                            </td>
                            <td>
                                <input id="qty{{$product->id}}" name="quantity[]" onkeyup="calc({{$product->id}})"
                                    type="number" style="width:40px;"
                                    value="{{ isset($data->quantity)? $data->quantity: '0' }}" min="0"><br><br>
                                @if($product->min_req_qty == 1)
                                <input type="checkbox" id="min_qty{{$product->id}}" @isset($data->min_quantity)
                                @if($data->min_quantity>0)
                                checked
                                @endif
                                @endisset
                                onclick="minQuantity({{ $product->id}})"
                                style="width:40px;border:none" name=""> Min
                                Quantity
                                <div id="showqty{{$product->id}}"
                                    style="{{ isset($data->min_quantity)? '': 'display:none' }}">
                                    <input id="qty1{{$product->id}}" type="number" name="min_qty[]"
                                        size="5" style="width:40px"
                                        value="{{ isset($data->min_quantity)? $data->min_quantity: '0' }}" min="0">
                                </div>
                                @else
                                <input id="qty1{{$product->id}}" style="display:none" type="number" name="min_qty[]" size="5"
                                    style="width:40px" value="0" min="0">
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8">

                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @endforeach
        <style>
            #fixedbutton {
                position: fixed;
                bottom: 13%;
                right: 1.7%;
                background-color: #ec607f;
                border: none;
                color: white;
                padding: 20px 25px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 20px;
                margin: 10px 2px;
                border-radius: 50%;
                box-shadow: 0px 0px 37px 0px rgba(236, 96, 127, 1);
            }
        </style>
        <div>
            <button id="fixedbutton" class="btn" class="" style=""><i class="fa fa-shopping-cart"></i></button>
        </div>
</form>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Calculation
    function calc(id){
        var a = document.getElementById('qty'+id).value;
        var b = document.getElementById('price'+id).value;
        if(a>=0){
            var c = parseInt(a) * parseInt(b);
            $('#total'+id).val(c);
        }
        else{
            alert('Quantity always in positive');
        }
    }
    function minQuantity(id){
        var checkbox = document.getElementById('min_qty'+id);
        if(checkbox.checked) {
            document.getElementById("showqty"+id).style.display = "block";
        }else{
            document.getElementById("showqty"+id).style.display = "none";
        }
    }

    function sessionAddToCart(id,cat_id,sup_id){
        var total = $('#total'+id).val();
        var qty = $('#qty'+id).val();
        var qty1 = $('#qty1'+id).val();
        var checked = "";
        if($("#checked"+id).prop('checked') == true){
            checked = "1";
        }else{
            checked = "0";
            alert('Product Deleted from Cart');
        }
        $.ajax({
            "url" : "{{ route('cart.add') }}",
            "method" : "post",
            "type" : "json",
            "data" : formData,
        });
    }
</script>
@endsection
