<!DOCTYPE html>
                                <html lang=&quot;en-US&quot;>
                                    <head>
                                    <meta charset=&quot;utf-8&quot;>

                                    <!-- head links -->
                                    <!-- Bootstrap css -->
                                    <link href="{{asset('admin/assets/plugins/bootstrap-4.3.1/css/bootstrap.min.css')}}" rel="stylesheet" />

                                    <!-- Sidemenu Css -->
                                    <link href="{{asset('admin/assets/css/sidemenu.css')}}" rel="stylesheet" />

                                    <!-- Dashboard Css -->
                                    <link href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet" />
                                    <link href="{{asset('admin/assets/css/admin-custom.css')}}" rel="stylesheet" />

                                    <!-- c3.js Charts Plugin -->
                                    <link href="{{asset('admin/assets/plugins/charts-c3/c3-chart.css')}}" rel="stylesheet" />

                                    <!-- Data table css -->
                                    <!-- <link href="{{asset('admin/assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
                                    <link href="{{asset('admin/assets/plugins/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" /> -->

                                    <!-- Slect2 css -->
                                    <link href="{{asset('admin/assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />

                                    <!-- p-scroll bar css-->
                                    <link href="{{asset('admin/assets/plugins/pscrollbar/pscrollbar.css')}}" rel="stylesheet" />

                                    <!---Font icons-->
                                    <link href="{{asset('admin/assets/css/icons.css')}}" rel="stylesheet" />

                                    <!---P-scroll Bar css -->
                                    <link href="{{asset('admin/assets/plugins/pscrollbar/pscrollbar.css')}}" rel="stylesheet" />

                                    <!-- Color Skin css -->
                                    <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{asset('admin/assets/color-skins/color7.css')}}" />
                                    <!-- End head links -->
                                
                                    <style>
                                        .card-header{
                                            background: #ec607f;
                                            color:white;
                                        }
                                    </style>
                                
                                </head>


                                    
                                    <body>
                                        @php
                                            $date = explode(" ",$order->created_at);
                                        @endphp
                                        <section class="orderdetails my-2 col-md-12">
                                            <div class="card">
                                               
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
                                                                <td scope="row">{{ $product->pivot->product_name }} €</td>
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
                                                
                                            </div>
                                        </section>

                                        <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>

<!-- JQuery js-->
<script src="{{asset('admin/assets/js/jquery-3.2.1.min.js')}}"></script>

<!-- Bootstrap js -->
<script src="{{asset('admin/assets/plugins/bootstrap-4.3.1/js/popper.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/bootstrap-4.3.1/js/bootstrap.min.js')}}"></script>

<!--JQuery Sparkline Js-->
<script src="{{asset('admin/assets/js/jquery.sparkline.min.js')}}"></script>

<!-- Circle Progress Js-->
<script src="{{asset('admin/assets/js/circle-progress.min.js')}}"></script>

<!-- Star Rating Js-->
<script src="{{asset('admin/assets/plugins/rating/jquery.rating-stars.js')}}"></script>

<!-- Fullside-menu Js-->
<script src="{{asset('admin/assets/plugins/sidemenu/sidemenu.js')}}"></script>

<!-- Data tables -->
<!-- <script src="{{asset('admin/assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable.js')}}"></script> -->

<!-- Select2 js -->
<script src="{{asset('admin/assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('admin/assets/js/select2.js')}}"></script>

<!-- p-scroll bar Js-->
<script src="{{asset('admin/assets/plugins/pscrollbar/pscrollbar.js')}}"></script>
<script src="{{asset('admin/assets/plugins/pscrollbar/pscroll.js')}}"></script>

<!--Counters -->
<script src="{{asset('admin/assets/plugins/counters/counterup.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/counters/waypoints.min.js')}}"></script>


<!-- Inline js -->
<script src="{{asset('admin/assets/js/formelements.js')}}"></script>

<!-- file uploads js -->
<script src="{{asset('admin/assets/plugins/fileuploads/js/fileupload.js')}}"></script>


<!-- Custom Js-->
<script src="{{asset('admin/assets/js/admin-custom.js')}}"></script>

<!-- Sweet alert Plugin -->
<script src="{{ asset('admin/assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
<script src="{{ asset('admin/assets/js/sweet-alert.js')}}"></script>


<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

                                    </body>
                                </html>