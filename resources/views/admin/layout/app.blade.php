<!doctype html>
<html lang="en">

<head>
    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="" name="description">
    <meta content="" name="author">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/Product/royal_donuts.png') }}" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/Product/royal_donuts.png') }}" />
    <link href="{{ asset('assets/plugins/fullcalendar/fullcalendar.css')}}" rel='stylesheet' />
		<link href="{{ asset('/assets/plugins/fullcalendar/fullcalendar.print.min.css')}}" rel='stylesheet' media='print' />

    {{-- owl content slider --}}
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
    <script src="{{ asset('/assets/plugins/fullcalendar/moment.min.js')}}"></script>
		<script src="{{ asset('/assets/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
		<script src="{{ asset('/assets/js/fullcalendar.js')}}"></script>
    {{-- end category slider --}}

    <link rel="stylesheet" href="{{asset('css/slider.css')}}">
    <script src="{{asset('js/slider.js')}}"></script>

    <style>
        #lblCartCount {
            font-size: 12px;
            background: #ff0000;
            color: #fff;
            padding: 0 5px;
            vertical-align: top;
            border-radius: 50%;
        }

        ::marker {
            display: none;
            color: white;
        }

        a.relative.inline-flex.items-center.px-4.py-2.ml-3.text-sm.font-medium.text-gray-700.bg-white.border.border-gray-300.leading-5.rounded-md.hover\:text-gray-500.focus\:outline-none.focus\:ring.ring-gray-300.focus\:border-blue-300.active\:bg-gray-100.active\:text-gray-700.transition.ease-in-out.duration-150 {
    display: none;
}

a.relative.inline-flex.items-center.px-4.py-2.text-sm.font-medium.text-gray-700.bg-white.border.border-gray-300.leading-5.rounded-md.hover\:text-gray-500.focus\:outline-none.focus\:ring.ring-gray-300.focus\:border-blue-300.active\:bg-gray-100.active\:text-gray-700.transition.ease-in-out.duration-150{
    display:none;
}
span.relative.inline-flex.items-center.px-4.py-2.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.leading-5.rounded-md {
    display: none;
}
    </style>

    <!-- bootstrap -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
        integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
    </script>

    <!-- Title -->
    @role('Customer')
    <title>{{ config('app.customer') }}</title>
    @endrole
    @role('Supplier')
    <title>{{ config('app.supplier') }}</title>
    @endrole
    @role('Admin')
    <title>{{ config('app.admin') }}</title>
    @endrole

    @include('admin.partials.basic.head')
    @yield('css')
</head>

<body class="app sidebar-mini">

    <!--Loader-->
    <div id="global-loader">
        <img src="{{asset('admin/assets/images/loader.svg')}}" class="loader-img" alt="">
    </div>
    <!--/Loader-->
    <!--Page-->
    <div class="page">
        <div class="page-main">
            <!--App-Header-->
            @include('admin.partials.basic.nav')
            <!--/App-Header-->
            <!-- Sidebar menu-->
            @include('admin.partials.sidebar')
            <!-- /Sidebar menu-->
            <!--App-Content-->
            <div class="app-content">
                <div class="side-app">
                    @if(session()->has('success'))
                    <div class="alert alert-success mt-1">
                        {{ session()->get('success') }}
                    </div>
                    @endif
                    {{-- @role('Admin')
                    @else
                    <div class="page-header">
                        <h4 class="page-title">
                            @isset($supplier->first_name)
                            {{ $supplier->first_name }} {{ $supplier->last_name }}
                            @else
                            Dashboard
                            @endisset
                        </h4>
                        @role('Customer')
                        <h4 class="page-title">
                            Dashboard
                        </h4>
                        @php
                        $c = bilawalsh\cart\Models\Cart::where('user_id',auth()->user()->id)->count()
                        @endphp
                        <li>

                            <a href="{{url('customer/cart')}}" class="icon-shopping-cart" style="font-size: 25px"><i
                                    class="fa fa-shopping-cart" style="font-size: 25px"></i>
                                <label ID="lblCartCount" runat="server" CssClass="badge badge-warning"
                                    ForeColor="White" />{{isset($c)? $c:'0'}}
                            </a>
                        </li>
                        @endrole
                    </div>
                    @endrole --}}
                    {{-- @include('admin.partials.basic.breadcrum') --}}
                    <!--/Page-Header-->
                    @yield('content')
                    
                    <!--Footer-->
                    @include('admin.partials.footer')
                    <!--/Footer-->
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.basic.script')

    @yield('script')

</body>

</html>
