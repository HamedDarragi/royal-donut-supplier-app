@extends('admin.layout.app')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" rel="stylesheet"
        id="bootstrap-css">

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
            font-size: 21px;
        }

    </style>
    <div class="container my-4">
        {{-- main card showing all order --}}
        <div class="card">
            <div class="card-header" style="background-color:rgb(236, 96, 127)">
                <div class="col-12">
                    <div class="row">
                        <div class="col-8">
                        </div>
                        <div class="col-2">
                            <a href="{{ url('customer/suppliers') }}" class="btn"
                                style="background-color: white;color:black">{{ trans('french.Order for another supplier')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- inner order card --}}
                <?php $id_array = [];
                $total = 0;
                $dontPrintEmptyMessage = 0;
                ?>
                @foreach ($suppliers as $supplier)
                    @php
                        $carts = bilawalsh\cart\Models\Cart::where(['supplier_id' => $supplier->id, 'user_id' => Auth::id()])->first();
                        $c_sup = App\Models\DeliveryCompany::join('companies_supplier','companies_supplier.delivery_company_id','delivery_companies.id')
                                    ->where('companies_supplier.supplier_id',$supplier->id)->first();
                        

                    @endphp
                    @if (!empty($carts))
                        @php
                            $dontPrintEmptyMessage = 1;
                        @endphp
                        <div class="card" id="Supplier{{ $supplier->id }}">
                            <div class="card-header" style="background-color: rgb(236, 96, 127) ">
                                <section class="col-md-12">
                                    <div class="row">
                                        <div class="col-7 my-4">
                                            <table class="">
                                                <thead>
                                                    <tr>
                                                        <td class="text-right">
                                                            <h5 class="total">{{ trans('french.Supplier')}} : </h5>
                                                        </td>
                                                        <td class="text-left">
                                                            <h6 class="total"> {{ $supplier->first_name }}
                                                                {{ $supplier->last_name }}
                                                            </h6>
                                                        </td>
                                                    </tr>

                                                </thead>
                                            </table>
                                        </div>
                                        <div class="col-5 my-4">
                                            <?php $c = bilawalsh\cart\Models\Cart::where('supplier_id', $supplier->id)
                                                ->where('user_id', auth()->user()->id)
                                                ->get();
                                            $total = 0;
                                            foreach ($c as $data) {
                                                $total = $total + $data->total;
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <h4>
                                                        <span class="badge badge-warning"> {{ trans('french.UnConfirmed')}}</span> <br><br>
                                                    </h4>
                                                    @if(!empty($c_sup))
                                                        @if($c_sup->minimum_order_amount <= $total)
                                                        <h4 class="total">{{ trans('french.Total')}}:
                                                            <span>{{ getCurrencySign($total) }}</span>
                                                        </h4>
                                                        @else
                                                        <h4 class="total">{{ trans('french.Total')}}:
                                                            <span>{{ getCurrencySign($total + $c_sup->delivery_fee) }}</span>&nbsp;&nbsp;<span class="badge badge-danger">{{ trans('french.Fee Applied')}}</span>
                                                        </h4>
                                                        @endif
                                                    @else
                                                        <h4 class="total">{{ trans('french.Total')}}:
                                                            <span>{{ getCurrencySign($total) }}</span>
                                                        </h4>
                                                    @endif
                                                    @if(!empty($c_sup))
                                                    <h4 class="total">{{ trans('french.Delivery Fee')}}:
                                                        <span>{{ getCurrencySign($c_sup->delivery_fee) }}</span>
                                                    </h4>
                                                    @endif
                                                </td>
                                            </tr>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="card-header" style="background-color: rgb(236, 96, 127) ">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-2 heading">#</div>
                                        <div class="col-2 heading">{{ trans('french.Name')}}</div>
                                        <div class="col-2 heading">{{ trans('french.REQUIRED QUANTITY')}}</div>
                                        <div class="col-2 heading">{{ trans('french.MINIMUM QUANTITY')}}</div>
                                        <div class="col-2 heading">{{ trans('french.Total')}}</div>
                                        <div class="col-2 heading">{{ trans('french.Action')}}</div>

                                    </div>
                                </div>
                            </div>

                            <div class="card-body">

                                @foreach ($carts->products as $product)
                                    <div class="col-12">
                                        <div class="row mb-2">
                                            <div class="col-2">{{ $loop->index + 1 }}</div>

                                            <div class="col-2">{{ $product->name }}</div>
                                            <div class="col-2">{{ $product->pivot->quantity }}</div>

                                            <div class="col-2">{{ $product->pivot->min_quantity }}</div>

                                            <div class="col-2">
                                                @if(!empty($c_sup))
                                                    @if($c_sup->minimum_order_amount <= ($product->pivot->unit_price * $product->pivot->quantity))
                                                    {{ getCurrencySign($product->pivot->unit_price * $product->pivot->quantity) }}
                                                    @else
                                                    {{ getCurrencySign(($product->pivot->unit_price * $product->pivot->quantity)+$c_sup->delivery_fee) }}
                                                    @endif
                                                @else
                                                    {{ getCurrencySign($product->pivot->unit_price * $product->pivot->quantity) }}
                                                @endif
                                            </div>
                                            <div class="col-2">
                                                <a href="{{ route('cart.item.remove', [$carts->id, $product->id]) }}"><i
                                                        style="color:red" class="fa fa-times"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($loop->last)
                                        <style>
                                            #fixedbutton {
                                                bottom: 13%;
                                                right: 1.7%;
                                                border: none;
                                                color: white;
                                                padding: 10px;
                                                text-align: center;
                                                text-decoration: none;
                                                display: inline-block;
                                                /* font-size: 10px; */
                                                margin: 5px 2px;
                                                float: right;
                                            }

                                        </style>
                                        {{-- href="{{ route('order.confirmed', $carts->id) }}" --}}
                                        <a class="btn mo" data-toggle="modal"
                                            data-target="#myModal{{ $carts->id . '-' . $supplier->id . '-' . auth()->user()->id }}"
                                            name="{{ $carts->id . '-' . $supplier->id . '-' . auth()->user()->id }}"
                                            style="background-color: #ec607f;" id="fixedbutton">{{ trans('french.Confirm')}}
                                            <i class="fa fa-arrow-right"></i></a>
                                        <a href="{{ url('customer/supplier-cart-modify', $supplier->id) }}"
                                            class="btn btn-info" id="fixedbutton"><i class="fa fa-redo"></i>
                                            {{ trans('french.Modify')}}</a>

                                        <!-- The Modal -->
                                        <div class="modal fade"
                                            id="myModal{{ $carts->id . '-' . $supplier->id . '-' . auth()->user()->id }}"
                                            name="{{ $carts->id . '-' . $supplier->id . '-' . auth()->user()->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" style="color: #000">Delivery Confirmation
                                                        </h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div id="spinner_div" style="text-align: center">
                                                            <div class="spinner-border text-success" id="loading"></div>
                                                        </div>
                                                        <div id="data" style="display: none">
                                                            <div style="padding: 10px">

                                                                <div style="display: flex;justify-content:space-between">
                                                                    <p>Customer</p>
                                                                    <p id="customer">{{ auth()->user()->first_name }}
                                                                        {{ auth()->user()->last_name }}
                                                                    </p>
                                                                </div>
                                                                <div style="display: flex;justify-content:space-between">
                                                                    <p>Supplier</p>
                                                                    <p id="supplier">{{ $supplier->first_name }}
                                                                        {{ $supplier->last_name }}</p>
                                                                </div>
                                                                <div style="display: flex;justify-content:space-between">
                                                                    <p>Treatment Days</p>
                                                                    <p id="treatment_day"></p>
                                                                </div>
                                                                <div style="display: flex;justify-content:space-between">
                                                                    <p>Delivery Day</p>
                                                                    <p id="delivery_day"></p>
                                                                </div>
                                                                <div style="display: flex;justify-content:space-between">
                                                                    <p>Price</p>
                                                                    <p id="price">
                                                                        {{ getCurrencySign($total) }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer" id="modal_footer" style="display: none">
                                                        <a href="#"><button type="button" class="btn btn-success"
                                                                data-dismiss="modal" id="modal_success">Ok</button></a>
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Close</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        function confirm(id) {
                            $.ajax({
                                "url": "{{ route('confirm_order') }}",
                                "method": "POST",
                                "type": "json",
                                "data": {
                                    id: id,
                                    _token: "{{ csrf_token() }}"

                                },
                                success: function(data) {
                                    console.log(data)
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Your Order is confirmed',
                                        text: "Your Order Id is " + data.data,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    window.location = "/customer/cart_page";



                                }
                            });


                        }
                    </script>
                @endforeach
                @if (empty($cart) && $dontPrintEmptyMessage == 0)
                    <div class="row">
                        <div class="col-12 text-center text-muted h4">
                            Cart Empty!
                        </div>
                    </div>
                @endif


            </div>

        </div>
    </div>
    <script>
        $(document).on('show.bs.modal', '.modal', function(e) {
            // run your validation... ( or shown.bs.modal )
            console.log("MODALLLLLLLLLLLLLLL");

            var baseUrl = '<?= url('') ?>';

            $(this).find('#loading').css('display', 'inline-block');
            $(this).find('#data').css('display', 'none');
            $(this).find('#modal_footer').css('display', 'none');
            // console.log("MHGN$TU$%G/", $(this).attr('name'));
            const split_values = $(this).attr('name').split('-');
            // console.log("SSSSSSS", split_values);

            var last_date_data_element = null;

            var rule_data = null;

            var d = new Date();
            var getTot = daysInMonth(d.getMonth(), d.getFullYear());
            // console.log(daysInMonth(d.getMonth(), d.getFullYear()))
            var sat = new Array();
            var sun = new Array();

            for (var i = 1; i <= getTot; i++) {
                var newDate = new Date(d.getFullYear(), d.getMonth(), i)
                // console.log(i + "-" + newDate.getDay());
                if (newDate.getDay() == 0) {
                    sun.push(moment(newDate).format("YYYY-MM-DD"));
                }
                if (newDate.getDay() == 6) {
                    sat.push(moment(newDate).format("YYYY-MM-DD"));
                }

            }

            function daysInMonth(month, year) {
                return new Date(year, month, 0).getDate();
            }


            // $.ajax({
            //     url: 'check_db',
            //     type: "POST",
            //     data: {
            //         "_token": "{{ csrf_token() }}",
            //         date: "2021-12-04",
            //     },
            //     success: function(response) {
            //         console.log("RESSSSS", response);

            //     }
            // });

            var date_data_array = [];

            $.ajax({
                url: 'get_rule',
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    customer_id: split_values[2],
                    supplier_id: split_values[1],
                    cart_id: split_values[0]
                },
                success: function(response) {
                    if (response != "empty") {
                        rule_data = response;
                        console.log("Ressssssss", response);
                        var selected_days = rule_data.delivery_days.split(",");

                        var date_increment = 0;
                        for (var i = 0; i <= parseInt(rule_data.treatment_time); i++) {

                            for (var j = 0; j < 7; j++) {
                                var new_date = new Date();
                                var get_hour = new_date.getHours();
                                var get_minute = new_date.getMinutes();
                                var time = get_hour + ":" + get_minute;
                                new_date.setDate(new_date.getDate() + date_increment);
                                var day_in_words = new_date.toLocaleString('en-us', {
                                    weekday: 'long'
                                });
                                // console.log("DDDDDDDDDD", day_in_words);
                                // console.log("SELECT", selected_days.includes(day_in_words));
                                if (selected_days.includes(day_in_words)) {
                                    var day_format_ymd = moment(new_date).format("YYYY-MM-DD");
                                    // console.log("DYYYY", day_format_ymd);
                                    $.ajax({
                                        url: 'check_db',
                                        type: "POST",
                                        async: false,
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            date: day_format_ymd,
                                        },
                                        success: function(response) {
                                            console.log("RESSSSS DBBBBB", response);
                                            if (response.db == true) {
                                                console.log("INSIDE DB");
                                                if (response.data.status == 1) {
                                                    console.log("INSIDE STATUS", parseFloat(
                                                        time));
                                                    console.log("ACEPT TME", parseFloat(
                                                        rule_data.acceptance_time));
                                                    if (parseFloat(time) <= parseFloat(
                                                            rule_data.acceptance_time)) {
                                                        if (date_data_array.length <=
                                                            parseInt(
                                                                rule_data.treatment_time)) {

                                                            date_data_array.push(response
                                                                .data.c_date);
                                                        }
                                                    } else {
                                                        if (date_data_array.length <=
                                                            parseInt(parseInt(rule_data
                                                                .treatment_time) + 1)) {

                                                            date_data_array.push(
                                                                response.data.c_date);
                                                        }
                                                    }
                                                }
                                            } else {
                                                // console.log("RESSSSSSSSS", response
                                                //     .data);
                                                // console.log("SATTTT INCCCCCCC", !sat
                                                //     .includes(day_format_ymd));
                                                // console.log("SUNN INCCCCCCCCC", !sun
                                                //     .includes(day_format_ymd))
                                                if (!sat.includes(response.data) && !sun
                                                    .includes(
                                                        response.data)) {
                                                    if (parseFloat(time) <= parseFloat(
                                                            rule_data.acceptance_time)) {
                                                        if (date_data_array.length <=
                                                            parseInt(
                                                                rule_data.treatment_time)) {

                                                            date_data_array.push(response
                                                                .data);
                                                        }
                                                    } else {
                                                        if (date_data_array.length <=
                                                            parseInt(parseInt(rule_data
                                                                .treatment_time) + 1)) {

                                                            date_data_array.push(
                                                                response.data);
                                                        }
                                                    }
                                                }
                                            }


                                        }
                                    });
                                }
                                date_increment++;
                            }
                        }
                    }
                    // $('#loading').css('display', 'none');
                    // $('#modal_body').css('display', 'block');
                    // $('#delivery_day').html("Your Order Will be ");
                    console.log("DATE DATAAAAAAAA",
                        date_data_array);
                    last_date_data_element = date_data_array.at(-1);


                }
            });

            setTimeout(() => {
                if (last_date_data_element != null) {
                    // console.log("TTTTTTT", rule_data);
                    $(this).find('#loading').css('display', 'none');
                    $(this).find('#data').css('display', 'block');
                    $(this).find('#modal_footer').css('display', 'flex');
                    $(this).find('#delivery_day').html("Your order will be delivered on " + moment(
                        new Date(
                            last_date_data_element)).format("YYYY-MM-DD"));
                    $(this).find('#treatment_day').html(parseInt(rule_data.treatment_time));

                    $(this).find('#modal_success').on('click', function() {
                        // console.log("OK CLICKED");
                        $.ajax({
                            url: 'submit_delivery_data',
                            type: "POST",
                            async: false,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                delivery_date: date_data_array.at(-1),
                                treatment_time: parseInt(rule_data.treatment_time),
                                customer_id: split_values[2],
                                supplier_id: split_values[1],
                                cart_id: split_values[0],
                            },
                            success: function(response) {
                                if (response.redirect == true) {
                                    window.location.href = baseUrl +
                                        '/order/confirmed/' + response.data;
                                }
                            }
                        })
                    })
                }
            }, 5000, last_date_data_element);


            // console.log(sat);
            // console.log(sun);

        });


        // $('#modal_success').on('click', function() {
        //     console.log("CLICKEDDDDDDDDDDDD");
        // })
    </script>


@endsection
