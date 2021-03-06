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
        font-size: 23px;
    }
</style>
<div class="card my-5">
    <div class="card-header">
        <h3 class="card-title">Rectify Orders</h3>
        <div class="card-options">
            <span class="input-group-btn mx-2">
                <!-- <a class="btn">
                            <span class="fe fe-filter text-white" type="datepicker"></span>
                        </a> -->
            </span>
            <!-- <form>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" placeholder="Search something..." name="s">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <span class="fe fe-search" style="color:pink"></span>
                        </button>
                    </span>
                </div>
            </form> -->
        </div>
    </div>
    
    @foreach($orders as $order)
    @if($order->user_id == auth()->user()->id)
    @php
    
    $date = explode(" ",$order->created_at);
    $items = App\Models\RectifyOrderItem::where('order_id',$order->id)->get();
    @endphp
    <section class="orderdetails my-2 col-md-12">
        <div class="card">
            <div class="card-header">
                <section class="col-md-12">
                    <div class="row">
                        <div class="col-9">
                            <table class="">
                                <thead>
                                    
                                    <tr>
                                        <th class="text-right px-2">
                                            <h5>{{ trans('french.Supplier')}} : </h5>
                                        </th>
                                        <th class="text-left px-2">
                                            <h6> {{explode("-",$order->supplier_name)[0]}} </h6>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="text-right px-2">
                                            <h5>{{ trans('french.customer')}} : </h5>
                                        </th>
                                        <th class="text-left px-2">
                                            <h6> {{ $order->user_name }} </h6>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="text-right px-2">
                                            <h5>{{ trans('french.Order Date')}}: </h5>
                                        </th>
                                        <th class="text-left px-2">
                                            <h6> {{ $date[0] }} </h6>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-3 my-4">
                            <tr>
                                <td>
                                    <h4>
                                    @if($order->order_status == 1)
                                        <span class="badge badge-success">{{ trans('french.Confirmed')}}</span>
                                        @elseif($order->order_status == 2)
                                        <span class="badge badge-warning">{{ trans('french.Indelivery')}}</span>
                                        @elseif($order->order_status == 3)
                                        <span class="badge badge-success">{{ trans('french.Delivered')}}</span>
                                        @elseif($order->order_status == 4)
                                        <span class="badge badge-success">{{ trans('french.Treated')}}</span>
                                        @endif
                                        <br><br>
                                    </h4>
                                    <h4 class="total">{{ trans('french.Total')}}: <span>{{$order->grand_total}} ???</span>
                                        
                                    </h4>
                                </td>
                            </tr>
                        </div>
                    </div>
                </section>
            </div>
            <div class="card-body">
                
                <table class="table table-bordered text-center rounded-lg" id="order-tab">
                    <thead class="thead">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="order_header">{{ trans('french.Name')}}</th>
                            <th scope="col" class="order_header">{{ trans('french.unit')}}</th>
                            <th scope="col" class="order_header">{{ trans('french.Price')}} (???)</th>
                            <th scope="col" class="order_header">{{ trans('french.REQUIRED QUANTITY')}}</th>
                            <th scope="col" class="order_header">{{ trans('french.MINIMUM QUANTITY')}}</th>
                            <th scope="col" class="order_header">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php $k = 0; @endphp
                        @foreach($items as $item)
                        @php $product = App\Models\Product::find($item->product_id); @endphp
                        <tr>
                            <td scope="row">{{ $loop->index+1 }}</td>
                            <td scope="row">{{ $product->name }}</td>
                            <td scope="row">{{ $item->unit_name }}</td>
                            <td scope="row">{{ $item->unit_price }} ???</td>
                            <td scope="row">{{ $item->quantity }}</td>
                            <td scope="row">{{ $item->min_quantity}}</td>
                            <td>
                                <a href="{{ route('remove_rectify',[$order->id,$item->id]) }}"><i class="fa fa-times text-red"></i></a>
                            </td>
                        </tr>
                        @php $k++; @endphp

                        @endforeach
                    </tbody>
                </table>
            </div>
            @php $rec = "rec";  @endphp
            <div class="card-footer">
                <div class="col-12">
                    <div class="row float-right">
                        <a href="{{ route('modify_rectify',$order->supplier_name) }}" class="btn btn-primary float-right">Modify</a>&nbsp;
                        <button data-toggle="modal" data-target="#rectify_confirm{{$order->id}}" class="btn btn-success">
                        Confirm <i class="fa fa-arrow-right"></i></button>

                                <div class="modal fade" id="rectify_confirm{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ url('customer/confirm_rectify_orders') }}" method="get" enctype="multipart/form-data">
                                            @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <input type="hidden" name="order_status" value="1">


                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel" style="color:grey">Give Comments</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <label for="">Comments</label>
                                                    <textarea class="form-control" maxlength = "100" name="message" id="message" cols="30" rows="3"></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Confirm Order</button>
                                                </div>
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function changeQty(value, order_id)
                {
                    $.ajax
                    ({
                        "url" : "{{ route('quantity.update') }}",
                        "method" : "GET",
                        "data" : {
                            order_id:order_id,
                            req_min_qty:value
                        },
                        success: function(data)
                        {
                            console.log(data);
                        }
                    });
                }

                    function changeDelStatus(id){
                        var status = 3;
                        var cas = "Customer";
                                $.ajax({
                                    "url" : "{{ url('order/status') }}",
                                    "method" : "GET",
                                    "data" : {
                                       order_id:id ,
                                       order_status:status,
                                       cas:cas,
                                    },
                                    success: function(data)
                                    {
                                        location.reload();
                                    }
                                });
                            }
    </script>


    @endif
    @endforeach
</div>
{{$orders->links()}}

<script>

$(document).ready(function(){
    var width = screen.width;
    if(width <= 400){
    $("table#order-tab").addClass("table-responsive");
    }else{
    $("table#order-tab").removeClass("table-responsive");

    }
});

</script>
@endsection
