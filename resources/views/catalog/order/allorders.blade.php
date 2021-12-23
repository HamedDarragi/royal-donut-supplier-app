@extends('admin.layout.app')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" rel="stylesheet" id="bootstrap-css">

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
        <h3 class="card-title">{{ trans('french.Orders')}}</h3>
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
    
    @if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif
    @foreach($orders as $order)
    @php
    
    
    $email = App\Models\Email::where('order_number',$order->order_number)
                                ->where('status',1)->first();
    $rectify = App\Models\RectifyOrder::where('order_number',$order->order_number)
                                ->first();
    $date = explode(" ",$order->created_at);
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
                                            <h5>{{ trans('french.Order')}}# : </h5>
                                        </th>
                                        <th class="text-left px-2">
                                            <h6> {{$order->order_number}}</h6>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="text-right px-2">
                                            <h5>{{ trans('french.Supplier')}} : </h5>
                                        </th>
                                        <th class="text-left px-2">
                                            <h6> {{$order->supplier_name}} </h6>
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
                                            <h5>{{ trans('french.Order Date')}} : </h5>
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
                                    <h4 class="total">{{ trans('french.Total')}}: <span>{{$order->grand_total}} €</span><br>
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
                            <th scope="col">#</th>
                            <th scope="col">{{ trans('french.Name')}}</th>
                            <th scope="col">{{ trans('french.unit')}}</th>
                            <th scope="col">{{ trans('french.Price')}} (€)</th>
                            <th scope="col">{{ trans('french.REQUIRED QUANTITY')}}</th>
                            <th scope="col">{{ trans('french.MINIMUM QUANTITY')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $k = 0; @endphp
                        @foreach($order->products as $product)
                       
                        <tr>
                            <td scope="row">{{ $loop->index+1 }}</td>
                            <td scope="row">{{ $product->pivot->product_name }}</td>
                            <td scope="row">{{ $product->pivot->unit_name }}</td>
                            <td scope="row">{{ $product->pivot->unit_price }} €</td>
                            <td scope="row">{{ $product->pivot->quantity }}</td>
                            <td scope="row">{{ $product->pivot->min_quantity}}</td>
                        </tr>
                        @php $k++; @endphp

                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="col-12">
                    <div class="row">
                        <div class="col-7 float-left">
                            @if(empty($email))
                            <button data-toggle="modal" data-target="#emailmodal{{$order->id}}" class="btn btn-warning"><i class="fa fa-envelope"></i> {{ trans('french.Generate Email')}}</button>
                            <div class="modal fade" id="emailmodal{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('email',$order->id) }}" method="get" enctype="multipart/form-data">
                                        @csrf
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
                                                <button type="submit" class="btn btn-primary">Generate</button>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                            @endif
                            <a class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter{{$order->id}}"> JSON </a>
                        </div>
                        <div class="modal fade" id="exampleModalCenter{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div style="background-color:black " class="modal-content">
                                       
                                        <div class="modal-body">
                                            <p class="text-light">{{json_encode($order)}}</p>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        <div class="col-5 float-right text-right">
                            @if($order->order_status != bilawalsh\cart\Models\Order::DELIVERED && empty($rectify))
                                <button data-toggle="modal" data-target="#rectify_modal{{$order->id}}" class="btn btn-primary">
                                Rectify Order <i class="fa fa-arrow-right"></i></button>

                                <div class="modal fade" id="rectify_modal{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ url('rectify_orders') }}" method="get" enctype="multipart/form-data">
                                            @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <input type="hidden" name="order_status" value="5">


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
                                                    <button type="submit" class="btn btn-primary">Change</button>
                                                </div>
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($order->order_status == bilawalsh\cart\Models\Order::TREATED && !empty($email))
                            
                            <button data-toggle="modal" data-target="#indeliverymodal{{$order->id}}" class="btn btn-primary">
                            {{ trans('french.Indelivery')}} <i class="fa fa-arrow-right"></i></button>
                            
                           
                            
                            <div class="modal fade" id="indeliverymodal{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ url('order/status') }}" method="get" enctype="multipart/form-data">
                                        @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <input type="hidden" name="order_status" value="2">


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
                                                <button type="submit" class="btn btn-primary">Change</button>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
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
                        var status = 2;
                                $.ajax({
                                    "url" : "{{ url('order/status') }}",
                                    "method" : "GET",
                                    "data" : {
                                       order_id:id ,
                                       order_status:status
                                    },
                                    success: function(data)
                                    {
                                        location.reload();
                                    }
                                });
                            }
    </script>
                            
                            @elseif($order->order_status == bilawalsh\cart\Models\Order::INDELIVERY)
                            <button data-toggle="modal" data-target="#deliverymodal{{$order->id}}" class="btn btn-primary">
                            {{ trans('french.Delivered')}} <i class="fa fa-arrow-right"></i></button>

                            <div class="modal fade" id="deliverymodal{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ url('order/status') }}" method="get" enctype="multipart/form-data">
                                        @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <input type="hidden" name="order_status" value="3">
                                            <input type="hidden" name="cas" value="Admin">



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
                                                <button type="submit" class="btn btn-primary">Change</button>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
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
                        var cas = "Admin";
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    
    @endforeach
</div>
{{$orders->links()}}
@endsection
