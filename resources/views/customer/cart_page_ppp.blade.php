@extends('admin.layout.app')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" rel="stylesheet"
        id="bootstrap-css">
    <style type="text/css">
        /* tr td
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                color: white;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } */
        @media (max-width: 480px) {
            .col-2 {
                -ms-flex: 0 0 16.66666667%;
                flex: 0 0 16.66666667%;
                max-width: 55.666667% !important;
            }
        }


        .heading {
            color: white;
        }

        .thead,
        .card-header {
            background-color: rgb(236, 96, 127);
        }

        /* .table th{
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                color:white !important;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } */

        .table {
            border: 1px solid #ec607f;
            border-radius: 10px;
        }

        .total {
            font-size: 21px;
            color: white;
        }

    </style>
    <?php $associate_rule_number = 0;
    $find_associate_rule = null;
    $find_associate_rule_2 = null;
    $got_asssociation_message = 0;
    $delivery_total = 0;
    ?>
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
                                style="background-color: white;color:black">{{ trans('french.Order for another supplier') }}</a>
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
                    {{-- {{ dump('SUPPLIERRRR---' . $supplier->id) }} --}}
                    @php
                        $carts = bilawalsh\cart\Models\Cart::where(['supplier_id' => $supplier->supplier_id, 'user_id' => Auth::id()])->first();
                        $c_sup = App\Models\DeliveryCompany::join('companies_suppliers', 'companies_suppliers.delivery_company_id', 'delivery_companies.id')
                            ->where('companies_suppliers.supplier_id', $supplier->supplier_id)
                            ->first();
                        $cart_supplier = App\Models\User::find($supplier->supplier_id);
                    @endphp


                    @if (!empty($carts))
                        @php
                            $dontPrintEmptyMessage = 1;
                        @endphp
                        {{-- {{ dump('CART----' . $carts->id) }} --}}
                        @if ($carts->delivery_supplier_id != null && $c_sup != null)
                            <div class="card" id="Supplier{{ $supplier->id }}">
                                @if ($carts->parent == null)
                                    {{-- {{ dump('SSSS-1111--' . $supplier->id) }} --}}
                                    <div class="card-header" style="background-color: rgb(236, 96, 127) ">
                                        <section class="col-md-12">
                                            <div class="row">
                                                <div class="col-7 my-4">
                                                    <h5 class="total" style="float: left;">
                                                        {{ trans('french.Delivery Company') }} :
                                                    </h5>
                                                    <h6 class="total">{{ $c_sup->name }}
                                                    </h6>

                                                </div>
                                                <div class="col-5 my-4">
                                                    <?php $c = bilawalsh\cart\Models\Cart::where('delivery_supplier_id', $c_sup->delivery_company_id)
                                                        ->where('user_id', auth()->user()->id)
                                                        ->get();
                                                    $total = 0;
                                                    foreach ($c as $data) {
                                                        $total = $total + $data->total;
                                                    }
                                                    ?>
                                                    <h4>
                                                        <span class="badge badge-warning">
                                                            {{ trans('french.UnConfirmed') }}</span> <br><br>
                                                    </h4>
                                                    @if (!empty($c_sup))
                                                        @if ($c_sup->minimum_order_amount <= $total)
                                                            <h4 class="total">
                                                                {{ trans('french.Total') }}:
                                                                <span>{{ getCurrencySign($total) }}</span>
                                                            </h4>
                                                            <?php $delivery_total = $total; ?>
                                                        @else
                                                            <h4 class="total">
                                                                {{ trans('french.Total') }}:
                                                                <span>{{ getCurrencySign($total + $c_sup->delivery_fee) }}</span>&nbsp;&nbsp;<span
                                                                    class="badge badge-danger">{{ trans('french.Fee Applied') }}</span>
                                                            </h4>
                                                            <?php $delivery_total = $total + $c_sup->delivery_fee; ?>
                                                            <h4 class="total">
                                                                {{ trans('french.Delivery Minimum Amount') }}:
                                                                <span>{{ getCurrencySign($c_sup->minimum_order_amount) }}</span>
                                                            </h4>
                                                            <h4 class="total">
                                                                {{ trans('french.Delivery Fee') }}:
                                                                <span>{{ getCurrencySign($c_sup->delivery_fee) }}</span>
                                                            </h4>
                                                        @endif
                                                    @else
                                                        <h4 class="total">{{ trans('french.Total') }}:
                                                            <span>{{ getCurrencySign($total) }}</span>
                                                        </h4>
                                                        <?php $delivery_total = $total; ?>
                                                    @endif
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                    <div class="card-body" id="cart_body">
                                        <div id="product_delivery_supplier">
                                            <div class="card">
                                                <div class="card-header" style="background-color: rgb(236, 96, 127) ">
                                                    <section class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-7 my-4">
                                                                <h5 class="total" style="float:left;">
                                                                    {{ trans('french.Supplier') }} :
                                                                </h5>
                                                                <h6 class="total">
                                                                    {{ $cart_supplier->first_name }}
                                                                </h6>
                                                            </div>
                                                            <div class="col-5 my-4">
                                                                <?php $c = bilawalsh\cart\Models\Cart::where('supplier_id', $supplier->supplier_id)
                                                                    ->where('user_id', auth()->user()->id)
                                                                    ->get();
                                                                $total = 0;
                                                                foreach ($c as $data) {
                                                                    $total = $total + $data->total;
                                                                }
                                                                ?>
                                                                <h4 class="total">
                                                                    {{ trans('french.Total') }}:
                                                                    <span>{{ getCurrencySign($total) }}</span>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </div>
                                                <div class="card-header" style="background-color: rgb(236, 96, 127) ">
                                                    <table class="table mb-0" id="order-tab" style="background:white;">
                                                        <thead>
                                                            <tr>
                                                                <th class="heading order_header">#</th>
                                                                <th class="heading order_header">
                                                                    {{ trans('french.Name') }}
                                                                </th>
                                                                <th class="heading order_header">
                                                                    {{ trans('french.REQUIRED QUANTITY') }}
                                                                </th>
                                                                <th class="heading order_header">
                                                                    {{ trans('french.MINIMUM QUANTITY') }}
                                                                </th>
                                                                <th class="heading order_header">
                                                                    {{ trans('french.Total') }}
                                                                </th>
                                                                <th class="heading order_header">
                                                                    {{ trans('french.Action') }}
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <div class="card-body">
                                                                @foreach ($carts->products as $product)
                                                                    <tr>
                                                                        <!-- <div class="col-12">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="row mb-2"> -->
                                                                        <td>{{ $loop->index + 1 }}
                                                                        </td>

                                                                        <td>{{ $product->name }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $product->pivot->quantity }}
                                                                        </td>

                                                                        <td>
                                                                            {{ $product->pivot->min_quantity }}</td>

                                                                        <td>

                                                                            {{ getCurrencySign($product->pivot->unit_price * $product->pivot->quantity) }}
                                                                        </td>
                                                                        <td>
                                                                            <a
                                                                                href="{{ route('cart.item.remove', [$carts->id, $product->id]) }}"><i
                                                                                    style="color:red"
                                                                                    class="fa fa-times"></i></a>
                                                                        </td>
                                                                        <!-- </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div> -->
                                                                    </tr>
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
                                                                        <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>

                                                                            <td colspan="2">

                                                                                <a href="{{ url('customer/supplier-cart-modify', $supplier->supplier_id) }}"
                                                                                    class="btn btn-info"
                                                                                    id="fixedbutton"><i
                                                                                        class="fa fa-redo"></i>
                                                                                    {{ trans('french.Modify') }}</a>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <?php $find_associate_rule = App\Models\AssociateRule::where('supplier_id', $supplier->supplier_id)->first(); ?>
                                        <?php $find_child = null;
                                        $find_child = bilawalsh\cart\Models\Cart::where('parent', $carts->id)->first(); ?>
                                        @if ($find_associate_rule != null)
                                            {{-- {{ dump('SS__1111--' . $supplier->id) }} --}}
                                            <a class="btn mo " data-toggle="modal"
                                                data-target="#myModal{{ $carts->id . '-' . $supplier->supplier_id . '-' . auth()->user()->id . '-' . $c_sup->delivery_company_id }}"
                                                name="{{ $carts->id . '-' . $supplier->supplier_id . '-' . auth()->user()->id . '-' . $c_sup->delivery_company_id }}"
                                                style="background-color: #ec607f"
                                                id="fixedbutton">{{ trans('french.Confirm') }}
                                                <i class="fa fa-arrow-right"></i></a>
                                            <!-- The Modal -->
                                            <div class="modal fade"
                                                id="myModal{{ $carts->id . '-' . $supplier->supplier_id . '-' . auth()->user()->id . '-' . $c_sup->delivery_company_id }}"
                                                name="{{ $carts->id . '-' . $supplier->supplier_id . '-' . auth()->user()->id . '-' . $c_sup->delivery_company_id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" style="color: #000">
                                                                Delivery
                                                                Confirmation
                                                            </h4>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            <div id="spinner_div" style="text-align: center">
                                                                <div class="spinner-border text-success" id="loading">
                                                                </div>
                                                            </div>
                                                            <div id="data" style="display: none">
                                                                <div style="padding: 10px">

                                                                    <div
                                                                        style="display: flex;justify-content:space-between">
                                                                        <p>Customer</p>
                                                                        <p id="customer">
                                                                            {{ auth()->user()->first_name }}
                                                                            {{ auth()->user()->last_name }}
                                                                        </p>
                                                                    </div>
                                                                    <div
                                                                        style="display: flex;justify-content:space-between">
                                                                        <p>Supplier</p>
                                                                        <p id="supplier">
                                                                            {{ $cart_supplier->first_name }}
                                                                        </p>
                                                                    </div>
                                                                    <div
                                                                        style="display: flex;justify-content:space-between">
                                                                        <p>Treatment Days</p>
                                                                        <p id="treatment_day"></p>
                                                                    </div>
                                                                    <div
                                                                        style="display: flex;justify-content:space-between">
                                                                        <p>Delivery Day</p>
                                                                        <p id="delivery_day"></p>
                                                                    </div>
                                                                    <div
                                                                        style="display: flex;justify-content:space-between">
                                                                        <p>Price</p>
                                                                        <p id="price">
                                                                            {{ getCurrencySign($delivery_total) }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="form-group" id="select_delivery_date">
                                                                        <label class="form-label">Select Delivery Date
                                                                        </label>
                                                                        <div class="selectgroup selectgroup-pills">
                                                                            <label class="selectgroup-item">
                                                                                <input type="radio" name="selected_date"
                                                                                    id="date_0_input"
                                                                                    class="selectgroup-input" value=""
                                                                                    checked>
                                                                                <span class="selectgroup-button"
                                                                                    id="date_0"></span>
                                                                            </label>
                                                                            <label class="selectgroup-item">
                                                                                <input type="radio" name="selected_date"
                                                                                    id="date_1_input" value=""
                                                                                    class="selectgroup-input">
                                                                                <span class="selectgroup-button"
                                                                                    id="date_1"></span>
                                                                            </label>
                                                                            <label class="selectgroup-item">
                                                                                <input type="radio" name="selected_date"
                                                                                    id="date_2_input" value=""
                                                                                    class="selectgroup-input">
                                                                                <span class="selectgroup-button"
                                                                                    id="date_2"></span>
                                                                            </label>
                                                                            <label class="selectgroup-item">
                                                                                <input type="radio" name="selected_date"
                                                                                    id="date_3_input" value=""
                                                                                    class="selectgroup-input">
                                                                                <span class="selectgroup-button"
                                                                                    id="date_3"></span>
                                                                            </label>
                                                                            <label class="selectgroup-item">
                                                                                <input type="radio" name="selected_date"
                                                                                    id="date_4_input" value=""
                                                                                    class="selectgroup-input">
                                                                                <span class="selectgroup-button"
                                                                                    id="date_4"></span>
                                                                            </label>
                                                                        </div>

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

                                        @else
                                            @if ($find_child == null)
                                                <p>Supplier Associated Rule Not Found</p>
                                                <?php $got_asssociation_message = 1; ?>
                                            @endif
                                        @endif
                                    </div>
                                @else

                                    {{-- {{ dump('SSS--2--' . $supplier->id) }} --}}
                                    <?php $c = bilawalsh\cart\Models\Cart::where('supplier_id', $supplier->supplier_id)
                                        ->where('user_id', auth()->user()->id)
                                        ->get();
                                    $total = 0;
                                    foreach ($c as $data) {
                                        $total = $total + $data->total;
                                    }
                                    ?>

                                    <script>
                                        var total_price = "<?php echo getCurrencySign($total); ?>";

                                        $('#product_delivery_supplier').append(
                                            "<div class='card'><div class='card-header' style='background-color: rgb(236, 96, 127) '><section class='col-md-12'><div class='row'><div class='col-7 my-4'><table><thead><tr><td class='text-right'><h5 class='total'>{{ trans('french.Supplier') }} :</h5></td><td class='text-left'><h6 class='total'>{{ $cart_supplier->first_name }} {{ $supplier->last_name }}</h6></td></tr></thead></table></div><div class='col-5 my-4'><tr><td><h4 class='total'>{{ trans('french.Total') }}:<span>" +
                                            total_price +
                                            "</span></h4></td></tr></div></div></section></div><div class='card-header' style='background-color: rgb(236, 96, 127) '><table class='table mb-0' id='order-tab' style='background:white;'><tr><th class='heading order_header'>#</th><th class='heading order_header'>{{ trans('french.Name') }}</th><th class='heading order_header'>{{ trans('french.REQUIRED QUANTITY') }}</th><th class='heading order_header'>{{ trans('french.MINIMUM QUANTITY') }}</th><th class='heading order_header'>{{ trans('french.Total') }}</th><th class='heading order_header'>{{ trans('french.Action') }}</th></tr><tbody><div class='card-body'>@foreach ($carts->products as $product)<tr><td >{{ $loop->index + 1 }}</td><td >{{ $product->name }}</td><td >{{ $product->pivot->quantity }}</td><td >{{ $product->pivot->min_quantity }}</td><td >{{ getCurrencySign($product->pivot->unit_price * $product->pivot->quantity) }}</td><td ><a href='{{ route('cart.item.remove', [$carts->id, $product->id]) }}'><i style='color:red' class='fa fa-times'></i></a></td></tr>@if ($loop->last)<style>#fixedbutton {bottom: 13%;right: 1.7%;border: none;color: white;padding: 10px;text-align: center;text-decoration: none;display: inline-block;margin: 5px 2px;float: right;}</style><tr><td></td><td></td><td></td><td></td><td colspan='2'>  <a href='{{ url('customer/supplier-cart-modify', $supplier->supplier_id) }}' class='btn btn-info' id='fixedbutton'><i class='fa fa-redo'></i>{{ trans('french.Modify') }}</a></td></tr> @endif @endforeach </div></tbody></table></div></div>"
                                        );
                                    </script>

                                    <?php $find_associate_rule_2 = App\Models\AssociateRule::where('supplier_id', $supplier->supplier_id)->first();
                                    if ($find_associate_rule_2 != null && $associate_rule_number == 0) {
                                        $associate_rule_number = 1;
                                    }
                                    ?>
                                    {{-- {{ dump('FN' . $find_associate_rule) }}
                                    {{ dump('FN111' . $associate_rule_number) }}
                                    {{ dump('FN2' . $find_associate_rule_2) }} --}}
                                    @if ($find_associate_rule_2 != null && $associate_rule_number == 1 && $find_associate_rule == null)
                                        {{-- <a class="btn mo " data-toggle="modal"
                                            data-target="#myModal{{ $carts->id . '-' . $supplier->supplier_id . '-' . auth()->user()->id . '-' . $c_sup->delivery_company_id }}"
                                            name="{{ $carts->id . '-' . $supplier->supplier_id . '-' . auth()->user()->id . '-' . $c_sup->delivery_company_id }}"
                                            style="background-color: #ec607f;width:12%"
                                            id="fixedbutton">{{ trans('french.Confirm') }}
                                            <i class="fa fa-arrow-right"></i>
                                        </a> --}}
                                        <script>
                                            var modal_data = "<?php echo $carts->id . '-' . $supplier->supplier_id . '-' . auth()->user()->id . '-' . $c_sup->delivery_company_id; ?>";
                                            // console.log("MODALLLLLLL", modal_data);
                                            $('#product_delivery_supplier').append(
                                                "<a class='btn mo' data-toggle='modal' data-target='#myModal" + modal_data + "' name=" + modal_data +
                                                "  style='background-color: #ec607f;width:12%' id='fixedbutton'>{{ trans('french.Confirm') }} <i class='fa fa-arrow-right'></i> </a>"
                                            );
                                        </script>
                                        <!-- The Modal -->
                                        <div class="modal fade"
                                            id="myModal{{ $carts->id . '-' . $supplier->supplier_id . '-' . auth()->user()->id . '-' . $c_sup->delivery_company_id }}"
                                            name="{{ $carts->id . '-' . $supplier->supplier_id . '-' . auth()->user()->id . '-' . $c_sup->delivery_company_id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" style="color: #000">
                                                            Delivery
                                                            Confirmation
                                                        </h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div id="spinner_div" style="text-align: center">
                                                            <div class="spinner-border text-success" id="loading">
                                                            </div>
                                                        </div>
                                                        <div id="data" style="display: none">
                                                            <div style="padding: 10px">

                                                                <div style="display: flex;justify-content:space-between">
                                                                    <p>Customer</p>
                                                                    <p id="customer">
                                                                        {{ auth()->user()->first_name }}
                                                                        {{ auth()->user()->last_name }}
                                                                    </p>
                                                                </div>
                                                                <div style="display: flex;justify-content:space-between">
                                                                    <p>Supplier</p>
                                                                    <p id="supplier">
                                                                        {{ $cart_supplier->first_name }}
                                                                    </p>
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
                                                                        {{ getCurrencySign($delivery_total) }}
                                                                    </p>
                                                                </div>
                                                                <div class="form-group" id="select_delivery_date">
                                                                    <label class="form-label">Select Delivery Date
                                                                    </label>
                                                                    <div class="selectgroup selectgroup-pills">
                                                                        <label class="selectgroup-item">
                                                                            <input type="radio" name="selected_date"
                                                                                id="date_0_input" class="selectgroup-input"
                                                                                value="" checked>
                                                                            <span class="selectgroup-button"
                                                                                id="date_0"></span>
                                                                        </label>
                                                                        <label class="selectgroup-item">
                                                                            <input type="radio" name="selected_date"
                                                                                id="date_1_input" value=""
                                                                                class="selectgroup-input">
                                                                            <span class="selectgroup-button"
                                                                                id="date_1"></span>
                                                                        </label>
                                                                        <label class="selectgroup-item">
                                                                            <input type="radio" name="selected_date"
                                                                                id="date_2_input" value=""
                                                                                class="selectgroup-input">
                                                                            <span class="selectgroup-button"
                                                                                id="date_2"></span>
                                                                        </label>
                                                                        <label class="selectgroup-item">
                                                                            <input type="radio" name="selected_date"
                                                                                id="date_3_input" value=""
                                                                                class="selectgroup-input">
                                                                            <span class="selectgroup-button"
                                                                                id="date_3"></span>
                                                                        </label>
                                                                        <label class="selectgroup-item">
                                                                            <input type="radio" name="selected_date"
                                                                                id="date_4_input" value=""
                                                                                class="selectgroup-input">
                                                                            <span class="selectgroup-button"
                                                                                id="date_4"></span>
                                                                        </label>
                                                                    </div>

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
                                        <?php $associate_rule_number++; ?>
                                    @else
                                        @if ($find_associate_rule == null && $find_associate_rule_2 == null && $got_asssociation_message == 0)
                                            <script>
                                                $('#product_delivery_supplier').append('<p>Supplier Associated Rule Not Found</p>');
                                            </script>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        @else
                            <div class="card" id="Supplier{{ $supplier->id }}">
                                <div class="card-header" style="background-color: rgb(236, 96, 127) ">
                                    <section class="col-md-12">
                                        <div class="row">
                                            <div class="col-7 my-4">
                                                <h5 class="total" style="float:left">
                                                    {{ trans('french.Supplier') }} :
                                                </h5>
                                                <h6 class="total">
                                                    {{ $cart_supplier->first_name }}
                                                </h6>
                                            </div>
                                            <div class="col-5 my-4">
                                                <?php $c = bilawalsh\cart\Models\Cart::where('supplier_id', $supplier->supplier_id)
                                                    ->where('user_id', auth()->user()->id)
                                                    ->get();
                                                $total = 0;
                                                foreach ($c as $data) {
                                                    $total = $total + $data->total;
                                                }
                                                ?>
                                                <h4>
                                                    <span class="badge badge-warning">
                                                        {{ trans('french.UnConfirmed') }}</span> <br><br>
                                                </h4>
                                                @if (!empty($c_sup))
                                                    @if ($c_sup->minimum_order_amount <= $total)
                                                        <h4 class="total">
                                                            {{ trans('french.Total') }}:
                                                            <span>{{ getCurrencySign($total) }}</span>
                                                        </h4>
                                                        <?php $delivery_total = $total; ?>
                                                    @else
                                                        <h4 class="total">
                                                            {{ trans('french.Total') }}:
                                                            <span>{{ getCurrencySign($total + $c_sup->delivery_fee) }}</span>&nbsp;&nbsp;<span
                                                                class="badge badge-danger">{{ trans('french.Fee Applied') }}</span>
                                                        </h4>
                                                        <?php $delivery_total = $total + $c_sup->delivery_fee; ?>
                                                    @endif
                                                @else
                                                    <h4 class="total">{{ trans('french.Total') }}:
                                                        <span>{{ getCurrencySign($total) }}</span>
                                                    </h4>
                                                    <?php $delivery_total = $total; ?>
                                                @endif
                                                @if (!empty($c_sup))
                                                    <h4 class="total">
                                                        {{ trans('french.Delivery Fee') }}:
                                                        <span>{{ getCurrencySign($c_sup->delivery_fee) }}</span>
                                                    </h4>
                                                @endif
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="card-header" style="background-color: rgb(236, 96, 127) ">
                                    <table class="table mb-0" id="order-tab" style="background:white;">
                                        <thead>
                                            <tr>
                                                <th class="heading order_header">#</th>
                                                <th class="heading order_header">{{ trans('french.Name') }}</th>
                                                <th class="heading order_header">
                                                    {{ trans('french.REQUIRED QUANTITY') }}
                                                </th>
                                                <th class="heading order_header">
                                                    {{ trans('french.MINIMUM QUANTITY') }}
                                                </th>
                                                <th class="heading order_header">{{ trans('french.Total') }}</th>
                                                <th class="heading order_header">{{ trans('french.Action') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <div class="card-body">
                                                @foreach ($carts->products as $product)
                                                    <tr>
                                                        <td>{{ $loop->index + 1 }}</td>

                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ $product->pivot->quantity }}
                                                        </td>

                                                        <td>
                                                            {{ $product->pivot->min_quantity }}</td>

                                                        <td>

                                                            {{ getCurrencySign($product->pivot->unit_price * $product->pivot->quantity) }}
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="{{ route('cart.item.remove', [$carts->id, $product->id]) }}"><i
                                                                    style="color:red" class="fa fa-times"></i></a>
                                                        </td>
                                                        <!-- </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div> -->
                                                    </tr>
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
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>

                                                            <td>
                                                                <a class="btn mo" data-toggle="modal"
                                                                    data-target="#myModal{{ $carts->id . '-' . $supplier->supplier_id . '-' . auth()->user()->id }}"
                                                                    name="{{ $carts->id . '-' . $supplier->supplier_id . '-' . auth()->user()->id }}"
                                                                    style="background-color: #ec607f"
                                                                    id="fixedbutton">{{ trans('french.Confirm') }}
                                                                    <i class="fa fa-arrow-right"></i>
                                                                </a>
                                                                <a href="{{ url('customer/supplier-cart-modify', $supplier->supplier_id) }}"
                                                                    class="btn btn-info" id="fixedbutton"><i
                                                                        class="fa fa-redo"></i>
                                                                    {{ trans('french.Modify') }}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <!-- The Modal -->
                                                        <div class="modal fade"
                                                            id="myModal{{ $carts->id . '-' . $supplier->supplier_id . '-' . auth()->user()->id }}"
                                                            name="{{ $carts->id . '-' . $supplier->supplier_id . '-' . auth()->user()->id }}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">

                                                                    <!-- Modal Header -->
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" style="color: #000">
                                                                            Delivery
                                                                            Confirmation
                                                                        </h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <!-- Modal body -->
                                                                    <div class="modal-body">
                                                                        <div id="spinner_div" style="text-align: center">
                                                                            <div class="spinner-border text-success"
                                                                                id="loading">
                                                                            </div>
                                                                        </div>
                                                                        <div id="data" style="display: none">
                                                                            <div style="padding: 10px">

                                                                                <div
                                                                                    style="display: flex;justify-content:space-between">
                                                                                    <p>Customer</p>
                                                                                    <p id="customer">
                                                                                        {{ auth()->user()->first_name }}
                                                                                        {{ auth()->user()->last_name }}
                                                                                    </p>
                                                                                </div>
                                                                                <div
                                                                                    style="display: flex;justify-content:space-between">
                                                                                    <p>Supplier</p>
                                                                                    <p id="supplier">
                                                                                        {{ $cart_supplier->first_name }}
                                                                                    </p>
                                                                                </div>
                                                                                <div
                                                                                    style="display: flex;justify-content:space-between">
                                                                                    <p>Treatment Days</p>
                                                                                    <p id="treatment_day"></p>
                                                                                </div>
                                                                                <div
                                                                                    style="display: flex;justify-content:space-between">
                                                                                    <p>Delivery Day</p>
                                                                                    <p id="delivery_day"></p>
                                                                                </div>
                                                                                <div
                                                                                    style="display: flex;justify-content:space-between">
                                                                                    <p>Price</p>
                                                                                    <p id="price">
                                                                                        {{ getCurrencySign($total) }}
                                                                                    </p>
                                                                                </div>
                                                                                <div class="form-group"
                                                                                    id="select_delivery_date">
                                                                                    <label class="form-label">Select
                                                                                        Delivery Date
                                                                                    </label>
                                                                                    <div
                                                                                        class="selectgroup selectgroup-pills">
                                                                                        <label class="selectgroup-item">
                                                                                            <input type="radio"
                                                                                                name="selected_date"
                                                                                                id="date_0_input"
                                                                                                class="selectgroup-input"
                                                                                                value="" checked>
                                                                                            <span
                                                                                                class="selectgroup-button"
                                                                                                id="date_0"></span>
                                                                                        </label>
                                                                                        <label class="selectgroup-item">
                                                                                            <input type="radio"
                                                                                                name="selected_date"
                                                                                                id="date_1_input" value=""
                                                                                                class="selectgroup-input">
                                                                                            <span
                                                                                                class="selectgroup-button"
                                                                                                id="date_1"></span>
                                                                                        </label>
                                                                                        <label class="selectgroup-item">
                                                                                            <input type="radio"
                                                                                                name="selected_date"
                                                                                                id="date_2_input" value=""
                                                                                                class="selectgroup-input">
                                                                                            <span
                                                                                                class="selectgroup-button"
                                                                                                id="date_2"></span>
                                                                                        </label>
                                                                                        <label class="selectgroup-item">
                                                                                            <input type="radio"
                                                                                                name="selected_date"
                                                                                                id="date_3_input" value=""
                                                                                                class="selectgroup-input">
                                                                                            <span
                                                                                                class="selectgroup-button"
                                                                                                id="date_3"></span>
                                                                                        </label>
                                                                                        <label class="selectgroup-item">
                                                                                            <input type="radio"
                                                                                                name="selected_date"
                                                                                                id="date_4_input" value=""
                                                                                                class="selectgroup-input">
                                                                                            <span
                                                                                                class="selectgroup-button"
                                                                                                id="date_4"></span>
                                                                                        </label>
                                                                                    </div>

                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Modal footer -->
                                                                    <div class="modal-footer" id="modal_footer"
                                                                        style="display: none">
                                                                        <a href="#"><button type="button"
                                                                                class="btn btn-success"
                                                                                data-dismiss="modal"
                                                                                id="modal_success">Ok</button></a>
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-dismiss="modal">Close</button>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

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
            console.log("SSSSSSS", split_values);

            var selected_delivery_date = null;

            var split_delivery_company_id = null;
            var split_cart_id = null;

            if (split_values.length == 4) {
                split_delivery_company_id = split_values[3];
            } else if (split_values.length == 3) {
                split_cart_id = split_values[0];
            }


            var last_date_data_element = null;
            var next_delivery_date = [];

            var rule_data = null;



            function daysInMonth(month, year) {
                return new Date(year, month, 0).getDate();
            }
            var date_data_array = [];

            $.ajax({
                type: "POST",
                url: 'get_rule',
                data: {
                    "_token": "{{ csrf_token() }}",
                    rule_id: $('#rule_select').val(),
                    customer_id: split_values[2],
                    supplier_id: split_values[1],
                },
                success: function(response) {
                    console.log("Ressssssss", response == "empty");
                    if (response != "empty") {

                        rule_data = response;
                        var selected_days = rule_data.delivery_days.split(",");
                        var d = new Date();
                        var getTot = parseInt(rule_data.treatment_time) + 30;
                        var sat = new Array();
                        var sun = new Array();

                        console.log("TOTAL ####", getTot);

                        for (var i = 0; i <= getTot; i++) {
                            // console.log("IIIIIIIIIII", i);
                            var newDate = new Date();
                            newDate.setDate(newDate.getDate() + i);
                            // console.log(i + "-" + newDate.getDay());
                            if (newDate.getDay() == 0) {
                                sun.push(moment(newDate).format("YYYY-MM-DD"));
                            }
                            if (newDate.getDay() == 6) {
                                sat.push(moment(newDate).format("YYYY-MM-DD"));
                            }

                        }

                        console.log("SATURDAYSSSSS", sat);
                        console.log("SUNDAYSSSS", sun);


                        var date_increment = 0;
                        for (var i = 0; i <= parseInt(rule_data.treatment_time); i++) {

                            for (var j = 0; j < 7; j++) {
                                // var select_new_date = $('#delivery_day').val();
                                var new_date = new Date();

                                var selected_days = rule_data.delivery_days.split(",");
                                var get_hour = new_date.getHours();
                                var get_minute = new_date.getMinutes();
                                var time = get_hour + ":" + get_minute;
                                new_date.setDate(new_date.getDate() + date_increment);
                                var day_in_words = new_date.toLocaleString('en-us', {
                                    weekday: 'long'
                                });
                                // console.log("NEW DATEEEE", new_date);
                                // console.log("DDDDDDDDDD", day_in_words);
                                // console.log("SELECT", selected_days.includes(day_in_words));
                                // if (selected_days.includes(day_in_words)) {
                                var day_format_ymd = moment(new_date).format("YYYY-MM-DD");
                                // console.log("DYYYY", day_format_ymd);
                                // console.log("INSIDE TIME", parseFloat(time));
                                // console.log("INSIDE RULE TIME", parseFloat(rule_data.acceptance_time));
                                $.ajax({
                                    url: 'check_db',
                                    type: "POST",
                                    async: false,
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        date: day_format_ymd,
                                    },
                                    success: function(response) {
                                        // console.log("RESSSSS DBBBBB", response);
                                        if (response.db == true) {
                                            // console.log("INSIDE DB", response);
                                            if (response.data.status == 1) {
                                                // console.log("INSIDE STATUS", parseFloat(
                                                //     time));
                                                // console.log("DATE DATA ARRAY",
                                                //     date_data_array
                                                //     .length);

                                                if (parseFloat(time) <= parseFloat(
                                                        rule_data.acceptance_time)) {
                                                    if (date_data_array.length <
                                                        parseInt(
                                                            rule_data.treatment_time)) {

                                                        date_data_array.push(response
                                                            .data.c_date);
                                                    } else {
                                                        if (selected_days.includes(
                                                                day_in_words)) {
                                                            if (next_delivery_date.length <=
                                                                5) {
                                                                next_delivery_date.push(
                                                                    response.data.c_date
                                                                );
                                                            }

                                                        }
                                                    }
                                                } else {
                                                    if (date_data_array.length <
                                                        parseInt(parseInt(rule_data
                                                            .treatment_time) + 1)) {

                                                        date_data_array.push(
                                                            response.data.c_date);
                                                    } else {
                                                        if (selected_days.includes(
                                                                day_in_words)) {
                                                            if (next_delivery_date.length <=
                                                                5) {
                                                                next_delivery_date.push(
                                                                    response.data.c_date
                                                                );
                                                            }

                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            // console.log("RESSSSSSSSS", response
                                            //     .data);
                                            // console.log("SATTTTTTTTTT", sat);
                                            // console.log("DFYYYYYYYYY", day_format_ymd);

                                            // console.log("SATTTT INCCCCCCC", !sat
                                            //     .includes(day_format_ymd));
                                            // console.log("SUNN INCCCCCCCCC", !sun
                                            //     .includes(day_format_ymd))
                                            if (!sat.includes(day_format_ymd) && !sun
                                                .includes(
                                                    day_format_ymd)) {
                                                // console.log("RESSSSSSSS DATEEEEEEEE",
                                                //     response
                                                //     .data);
                                                if (parseFloat(time) <= parseFloat(
                                                        rule_data.acceptance_time)) {

                                                    if (parseInt(date_data_array.length) <
                                                        parseInt(
                                                            rule_data.treatment_time
                                                        )) {
                                                        // console.log(
                                                        //     "RESSSSSSSS DATEEEEEEEE 2222222",
                                                        //     response
                                                        //     .data);
                                                        // console.log("DATE DATA ARRAY",
                                                        //     date_data_array
                                                        //     .length);
                                                        // console.log("TIME TTTTTTTTTTT",
                                                        //     parseInt(
                                                        //         rule_data.treatment_time
                                                        //     ));
                                                        date_data_array.push(
                                                            response
                                                            .data);
                                                    } else {
                                                        // console.log("SELECTED DAYS",
                                                        //     selected_days);
                                                        // console.log("DAY IN WORDS",
                                                        //     day_in_words);
                                                        // console.log("DATEEEEEEEE",
                                                        //     response
                                                        //     .data);
                                                        if (selected_days.includes(
                                                                day_in_words)) {
                                                            if (next_delivery_date.length <=
                                                                5) {
                                                                next_delivery_date.push(
                                                                    response.data);
                                                            }

                                                        }
                                                    }
                                                } else {
                                                    if (date_data_array.length <
                                                        parseInt(parseInt(rule_data
                                                            .treatment_time) + 1)) {
                                                        // console.log(
                                                        //     "RESSSSSSSS DATEEEEEEEE 333333",
                                                        //     response
                                                        //     .data);
                                                        // console.log(
                                                        //     "DATE DATA ARRAY 222222",
                                                        //     date_data_array
                                                        //     .length);
                                                        // console.log(
                                                        //     "TIME TTTTTTTTTTT 22222222",
                                                        //     parseInt(
                                                        //         rule_data.treatment_time
                                                        //     ));
                                                        date_data_array.push(
                                                            response.data);
                                                    } else {
                                                        if (selected_days.includes(
                                                                day_in_words)) {
                                                            if (next_delivery_date.length <=
                                                                5) {
                                                                next_delivery_date.push(
                                                                    response.data);
                                                            }

                                                        }
                                                    }
                                                }
                                            }

                                        }
                                    }
                                });
                                // }
                                date_increment++;
                                //end 1st for loop
                                if (next_delivery_date.length == 5) {
                                    break;
                                }
                            }
                            //end second for loop
                            if (next_delivery_date.length == 5) {
                                break;
                            }
                        }
                        // $('#loading').css('display', 'none');
                        // $('#modal_body').css('display', 'block');
                        // $('#delivery_day').html("Your Order Will be ");
                        if (date_data_array.length == parseInt(parseInt(rule_data.treatment_time) +
                                1)) {
                            date_data_array.shift();
                        }
                        console.log("DATE DATAAAAAAAA",
                            date_data_array);
                        console.log("DELIVERY", next_delivery_date);
                        // last_date_data_element = date_data_array.at(-1);


                    } else {
                        next_delivery_date = [];
                    }
                }
            });
            setTimeout(() => {

                console.log("TTTTTTT", next_delivery_date);
                if (next_delivery_date.length > 0) {
                    // console.log("TTTTTTT", rule_data);
                    $(this).find('#loading').css('display', 'none');
                    $(this).find('#data').css('display', 'block');
                    $(this).find('#modal_footer').css('display', 'flex');
                    if (next_delivery_date.length > 0) {
                        selected_delivery_date = moment(
                            new Date(
                                next_delivery_date[0])).format("YYYY-MM-DD")
                        $(this).find('#delivery_day').html("Your order will be delivered on " + moment(
                            new Date(
                                next_delivery_date[0])).format("YYYY-MM-DD"));
                        $(this).find('#treatment_day').html(parseInt(rule_data.treatment_time));
                        for (var j = 0; j <= next_delivery_date.length; j++) {
                            $(this).find("#date_" + j + "_input").val(next_delivery_date[j]);
                            $(this).find("#date_" + j).html(next_delivery_date[j]);
                        }
                    } else {
                        $(this).find('#delivery_day').html("No Supplier Rule");
                        $(this).find('#treatment_day').html('No Supplier Rule');
                        $(this).find('#loading').css('display', 'none');
                        $(this).find('#data').css('display', 'block');
                        $(this).find('#modal_footer').css('display', 'none');
                        $(this).find('#sub_data').html(
                            "<p>No Customer Supplier Rule Found, So No Delivery Date Found</p>");
                    }

                    $('#select_delivery_date input').on('change', function() {
                        console.log("SELECTED CHECKED VALUEE", $(
                            'input[name=selected_date]:checked').val());
                        selected_delivery_date = moment(new Date($(
                                'input[name=selected_date]:checked').val()))
                            .format("YYYY-MM-DD");
                        $('#delivery_day').html("Your order will be delivered on " +
                            moment(new Date($('input[name=selected_date]:checked').val()))
                            .format("YYYY-MM-DD"));
                    });

                    var cart_id_array = [];
                    if (split_delivery_company_id != null) {
                        $.ajax({
                            url: 'get_cart_from_delivery_supplier',
                            type: "POST",
                            async: false,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                delivery_supp_id: split_delivery_company_id,
                            },
                            success: function(response) {
                                console.log("CCCCCCCCCCCCCRT", response.data);
                                cart_id_array = response.data;
                                console.log("CCCCCCCCCCCCCRT 222222222", cart_id_array);
                            }
                        })
                    } else {
                        cart_id_array.push(parseInt(split_cart_id));
                        console.log("CCCCCCCCCCCCCRT 33333333333", cart_id_array);
                    }

                    $(this).find('#modal_success').on('click', function() {
                        // console.log("OK CLICKED");
                        $.ajax({
                            url: 'submit_delivery_data',
                            type: "POST",
                            async: false,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                delivery_date: selected_delivery_date,
                                treatment_time: parseInt(rule_data.treatment_time),
                                customer_id: split_values[2],
                                supplier_id: split_values[1],
                                cart_id: cart_id_array,
                            },
                            success: function(response) {
                                console.log("ORRRRRRRRRR", response.data);
                                if (response.redirect == true) {
                                    window.location.href = baseUrl +
                                        '/order/confirmed/' + response.data;
                                }
                            }
                        })
                    })
                } else {
                    if (next_delivery_date.length == 0) {
                        $(this).find('#loading').css('display', 'none');
                        $(this).find('#data').css('display', 'block');
                        $(this).find('#modal_footer').css('display', 'none');
                        $(this).find('#sub_data').html(
                            "<p>No Customer Supplier Rule Found, So No Delivery Date Found</p>");
                    }
                }
            }, 5000, next_delivery_date);
        });
    </script>


@endsection
