<div class="card-header">
    <div class="card-title">Orders</div>
    <div class="col-md-12">
        {{-- <div class="text-right mr-5">
            <a href="{{ route($view.'.create') }}" class="btn btn-primary text-white mr-5"><i class="fa fa-plus"></i>
                {{ $view }}</a>
        </div> --}}
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        @include('message')
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="wd-15p">Image</th>
                    <th class="wd-15p">Customer</th>
                    <th class="wd-15p">Product Name</th>
                    <th class="wd-10p">Price</th>
                    <th class="wd-10p">Minimum Quantity</th>
                    <th class="wd-10p">Required Quantity</th>
                    <th class="wd-10p">Action</th>
                    <!-- <th class="wd-10p">Action</th> -->
                </tr>
            </thead>
            <tbody>

                @foreach ($orders as $order)
                <tr>
                    <?php
                    
                    $product= App\Models\Product::where('id', $order->product_id)->first();
                    $customer=App\Models\Customer::find($order->customer_id);
                     ?>
                    <td><img src="{{ asset('images/Product/'.$product->image) }}" style="height: 80px; width:150px"
                            alt="">
                    </td>
                    <td>{{$customer->first_name}} {{$customer->last_name}}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $order->min_qty }}</td>
                    <td>{{ $order->req_qty }}</td>
                    <td>
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#Show{{ $order->id }}">Confirm order</button>
                    </td>
                    {{-- <td>{{ $order->total }}</td> --}}

                    {{-- <td>
                        <a href="{{ route('order.status',$order->id) }}"><span
                                class="label label-pill label-{{ $order->isActive == 1?'success':'danger' }} mt-2">{{
                                $order->isActive == 1?
                                trans('message.isActive.active'):trans('message.isActive.inactive') }}</span>
                        </a>
                    </td> --}}
                    {{-- <td>
                        <div class="row">
                            <div class="col-sm-3">
                                <a href="{{ route('order.edit',$order->id) }}" class="btn btn-primary btn-sm"><i
                                        class="fa fa-edit text-white"></i></a>
                            </div>
                            <div class="col-sm-3">
                                <form action="{{ route('order.destroy',$order->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="fa fa-trash text-white"></i></button>
                                </form>
                            </div>
                        </div>

                    </td> --}}


                </tr>

                {{-- Show Modal --}}
                <div class="modal" id="Show{{ $order->id }}" role="dialog" aria-labelledby="exampleModalLongTitle"
                    style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Order Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('confirm_order')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <h6>Please select the quantity</h6>
                                    <input type="hidden" name="req_qty" value="{{ $order->req_qty }}">
                                    <input type="hidden" name="min_qty" value="{{ $order->min_qty }}">
                                    <input type="hidden" name="customer_id" value="{{ $order->customer_id }}">

                                    <input type="hidden" name="product_id" value="{{ $order->product_id }}">
                                    <input type="radio" id="css" name="sel_req_qty" value="{{$order->req_qty}}">
                                    <label for="css">{{$order->req_qty}}</label><br>
                                    <input type="radio" id="javascript" name="sel_min_qty" value="{{$order->min_qty}}">
                                    <label for="javascript">{{$order->min_qty}}</label><br>

                                    <button type="submit" class="btn btn-secondary">Submit</button>

                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
