<!doctype html>

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
            <div class="app-header1 header py-1 d-flex" style="background:#ec607f !important;">
    <div class="container-fluid">
        <div class="d-flex">
        @role('Customer')
            <a class="header-brand" href="/customer/suppliers">
                {{-- <img src="{{asset('admin/assets/images/brand/logo1.png')}}" class="header-brand-img" alt="Lmslist
                logo"> --}}
                <h2 class="cust" style='color:white; margin-top:12px;'>
                   
                {{ trans("french.Royal Donut's Customer") }}
                   
                   
                </h2>
            </a>
            @endrole
            @role('Admin')
            <a class="header-brand" href="/product">
                {{-- <img src="{{asset('admin/assets/images/brand/logo1.png')}}" class="header-brand-img" alt="Lmslist
                logo"> --}}
                <h2 style='color:white; margin-top:12px;'>
                
                {{ trans("french.Royal Donut's Admin") }}
                   
                   
                </h2>
            </a>
            @endrole
            @role('Supplier')
            <a class="header-brand" href="/supplier/orders">
                {{-- <img src="{{asset('admin/assets/images/brand/logo1.png')}}" class="header-brand-img" alt="Lmslist
                logo"> --}}
                <h2 style='color:white; margin-top:12px;'>
                
                    {{ config('app.supplier') }}
                   
                   
                </h2>
            </a>
            @endrole
                   

            <!--<a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>-->

            <div class="header-navicon">
                {{-- <a href="#" data-toggle="search" class="nav-link d-lg-none navsearch-icon">
                    <i class="fe fe-search"></i>
                </a> --}}
            </div>
            <div class="header-navsearch">
                <form class="form-inline mr-auto">
                    <div class="nav-search">
                        {{-- <input type="search" class="form-control header-search" placeholder="Search…"
                            aria-label="Search"> --}}
                        {{-- <button class="btn" type="submit"><i class="fe fe-search"></i></button> --}}
                    </div>
                </form>
            </div>
            <div class="d-flex order-lg-2 ml-auto">
                @role('Customer')
                @php
                $c = bilawalsh\cart\Models\Cart::where('user_id',auth()->user()->id)->count()
                @endphp
                <a href="{{url('customer/cart')}}" class="icon-shopping-cart  text-white" style="font-size: 25px; "><i
                        class="fa fa-shopping-cart" style="font-size: 25px"></i>
                    <label ID="lblCartCount" runat="server" CssClass="badge badge-warning" style="background-color:white; color:black"
                        ForeColor="black" />{{isset($c)? $c:'0'}}
                </a>
                @endrole
                <div class="dropdown d-none d-md-flex">
                    <a class="nav-link icon full-screen-link">
                        <i class="fe fe-maximize-2" id="fullscreen-button"></i>
                    </a>
                </div>
                {{-- <div class="dropdown d-none d-md-flex country-selector">
                    <a href="#" class="d-flex nav-link leading-none" data-toggle="dropdown">
                        <img src="{{asset('admin/assets/images/flags/us_flag.jpg')}}" alt="img"
                            class="avatar avatar-xs mr-1 align-self-center">
                        <div>
                            <span class="text-white">English</span>
                        </div>
                    </a>
                    <div class="language-width dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <img src="{{asset('admin/assets/images/flags/french_flag.jpg')}}" alt="flag-img"
                                class="avatar  mr-3 align-self-center">
                            <div>
                                <strong>French</strong>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <img src="{{asset('admin/assets/images/flags/germany_flag.jpg')}}" alt="flag-img"
                                class="avatar  mr-3 align-self-center">
                            <div>
                                <strong>Germany</strong>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <img src="{{asset('admin/assets/images/flags/italy_flag.jpg')}}" alt="flag-img"
                                class="avatar  mr-3 align-self-center">
                            <div>
                                <strong>Italy</strong>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <img src="{{asset('admin/assets/images/flags/russia_flag.jpg')}}" alt="flag-img"
                                class="avatar  mr-3 align-self-center">
                            <div>
                                <strong>Russia</strong>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <img src="{{asset('admin/assets/images/flags/spain_flag.jpg')}}" alt="flag-img"
                                class="avatar  mr-3 align-self-center">
                            <div>
                                <strong>Spain</strong>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="dropdown d-none d-md-flex">
                    <a class="nav-link icon" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class=" nav-unread badge badge-danger  badge-pill">4</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a href="#" class="dropdown-item text-center">You have 4 notification</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <div class="notifyimg">
                                <i class="fa fa-envelope-o"></i>
                            </div>
                            <div>
                                <strong>2 new Messages</strong>
                                <div class="small text-muted">17:50 Pm</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <div class="notifyimg">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div>
                                <strong> 1 Event Soon</strong>
                                <div class="small text-muted">19-10-2019</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <div class="notifyimg">
                                <i class="fa fa-comment-o"></i>
                            </div>
                            <div>
                                <strong> 3 new Comments</strong>
                                <div class="small text-muted">05:34 Am</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <div class="notifyimg">
                                <i class="fa fa-exclamation-triangle"></i>
                            </div>
                            <div>
                                <strong> Application Error</strong>
                                <div class="small text-muted">13:45 Pm</div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-center">See all Notification</a>
                    </div>
                </div>
                <div class="dropdown d-none d-md-flex">
                    <a class="nav-link icon" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class=" nav-unread badge badge-warning  badge-pill">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <img src="{{asset('admin/assets/images/users/male/41.jpg')}}" alt="avatar-img"
                                class="avatar brround mr-3 align-self-center">
                            <div>
                                <strong>Blake</strong> I've finished it! See you so.......
                                <div class="small text-muted">30 mins ago</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <img src="{{asset('admin/assets/images/users/female/1.jpg')}}" alt="avatar-img"
                                class="avatar brround mr-3 align-self-center">
                            <div>
                                <strong>Caroline</strong> Just see the my Admin....
                                <div class="small text-muted">12 mins ago</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <img src="{{asset('admin/assets/images/users/male/18.jpg')}}" alt="avatar-img"
                                class="avatar brround mr-3 align-self-center">
                            <div>
                                <strong>Jonathan</strong> Hi! I'am singer......
                                <div class="small text-muted">1 hour ago</div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item d-flex pb-3">
                            <img src="{{asset('admin/assets/images/users/female/18.jpg')}}" alt="avatar-img"
                                class="avatar brround mr-3 align-self-center">
                            <div>
                                <strong>Emily</strong> Just a reminder you have.....
                                <div class="small text-muted">45 mins ago</div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-center">View all Messages</a>
                    </div>
                </div>
                <div class="dropdown d-none d-md-flex">
                    <a class="nav-link icon" data-toggle="dropdown">
                        <i class="fe fe-grid"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow  app-selector">
                        <ul class="drop-icon-wrap">
                            <li>
                                <a href="#" class="drop-icon-item">
                                    <i class="icon icon-speech text-dark"></i>
                                    <span class="block"> E-mail</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="drop-icon-item">
                                    <i class="icon icon-map text-dark"></i>
                                    <span class="block">map</span>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="drop-icon-item">
                                    <i class="icon icon-bubbles text-dark"></i>
                                    <span class="block">Messages</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="drop-icon-item">
                                    <i class="icon icon-user-follow text-dark"></i>
                                    <span class="block">Followers</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="drop-icon-item">
                                    <i class="icon icon-picture text-dark"></i>
                                    <span class="block">Photos</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="drop-icon-item">
                                    <i class="icon icon-settings text-dark"></i>
                                    <span class="block">Settings</span>
                                </a>
                            </li>
                        </ul>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-center">View all</a>
                    </div>
                </div> --}}
                <div class="dropdown ">
                    <a href="#" class="nav-link pr-0 leading-none user-img" data-toggle="dropdown">
                        <img src="{{ asset('images/Product/royal_donuts.png') }}" style="background-color: white"
                            alt="profile-img" class="avatar avatar-md brround">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
                        <!--<a class="dropdown-item" href="#">-->
                        <!--    <i class="dropdown-icon icon icon-user"></i> My Profile-->
                        <!--</a>-->
                        <!--<a class="dropdown-item" href="emailservices.html">-->
                        <!--    <i class="dropdown-icon icon icon-speech"></i> Inbox-->
                        <!--</a>-->
                        <!--<a class="dropdown-item" href="editprofile.html">-->
                        <!--    <i class="dropdown-icon  icon icon-settings"></i> Account Settings-->
                        <!--</a>-->
                        <a class="dropdown-item" href="{{ route('logout') }}">
                            <i class="dropdown-icon icon icon-power"></i> Log out
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

            <!--/App-Header-->
            <!-- Sidebar menu-->
            
<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar doc-sidebar">
    <div class="app-sidebar__user clearfix">
        <div class="dropdown user-pro-body">
            <div>
                {{--<img src="{{ asset('images/User/'. Auth::user()->image) }}" alt="user-img"
                    class="avatar avatar-lg brround">--}}
                <img src="{{ asset('images/Product/royal_donuts.png') }}" alt="user-img"
                    class="avatar avatar-lg brround">
                <!--<a href="#"  class="profile-img">-->
                <!--    <span class="fa fa-pencil" aria-hidden="true"></span>-->
                <!--</a>-->

            </div>
            <div class="user-info">
                <h2>{{ Auth::user()->name }}</h2>
                <span>{{ Auth::user()->email }}</span>
            </div>
        </div>
    </div>



    {{-- <ul class="side-menu">
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fe fe-airplay"></i><span
                    class="side-menu__label">Catalog</span><i class="angle fa fa-angle-right"></i></a> --}}
            {{-- <ul class="slide-menu">--}}
                <ul class="p-5">
                    @role('Admin')
                    <li><a class="slide-item" href="{{ route('product.index') }}">{{ trans('french.Products') }}</a></li>
                    <li><a class="slide-item" href="{{ route('category.index') }}">{{ trans('french.Categories') }}</a></li>
                    <li><a class="slide-item" href="{{url('orders')}}">{{ trans('french.Orders') }}</a></li>
                    <li><a class="slide-item" href="{{ route('unit.index') }}">{{ trans('french.Units') }}</a></li>
                    {{-- <li><a class="slide-item" href="{{ route('inventory.index') }}">Inventory</a></li> --}}
                    <li><a class="slide-item" href="{{ route('customer.index') }}">{{ trans('french.Customers') }}</a></li>
                    {{-- <li><a class="slide-item" href="{{ route('broadcast.index') }}">Broadcast Email</a></li>
                    <li><a class="slide-item" href="{{ route('broadcast_group.index') }}">Email Group</a></li> --}}
                    {{-- <li><a class="slide-item" href="{{ route('manufacturing_partner.index') }}">Manufacturers</a>
                    </li> --}}
                    <li><a class="slide-item" href="{{ route('supplier.index') }}">{{ trans('french.Suppliers') }}</a></li>
                    <li><a class="slide-item" href="{{ route('deliverycompany.index') }}">{{ trans('french.Delivery Companies') }}</a></li>

                    <li><a class="slide-item" href="{{ route('calendar') }}">{{ trans('french.Calendar') }}</a></li>
                    <li><a class="slide-item" href="{{ route('rule.index') }}">{{ trans('french.Rules')}}</a></li>
                    <li><a class="slide-item" href="{{ route('backlogs.index') }}">{{ trans('french.Backlogs')}}</a></li>
                    
            <li><a class="slide-item" href="{{ route('associate_rule.index') }}">{{ trans('french.Associate Rule')}}</a></li>
            <li><a class="slide-item" href="{{ route('backupmanager') }}">Backups</a></li>

                    <li>
                    <details>
                        <summary class="mt-2">{{ trans('french.Email Settings') }}</summary>
                        <a class="slide-item ml-5" href="{{ route('footer') }}"><i class="fa fa-sliders-h"></i>&nbsp;{{ trans('french.Email Footer') }}</a>
                            <!-- <li><a class="slide-item ml-5" href="{{ route('title') }}"><i class="fa fa-sliders-h"></i>&nbsp;{{ trans('french.Title') }}</a></li> -->
                            <a class="slide-item ml-5" href="{{ route('emailhistory') }}"><i class="fa fa-sliders-h"></i>&nbsp;{{ trans('french.Email History') }}</a>
                        
                    </details>
                    </li>
                    @endrole

                    @role('Customer')
                    <li><a class="slide-item" href="{{ url('customer/suppliers') }}">{{ trans('french.Suppliers') }}</a></li>
                    <!-- <li><a class="slide-item" href="{{url('customer/cart_page')}}">Cart</a></li> -->
                    <li><a class="slide-item" href="{{url('customer/myorders')}}">{{ trans('french.Orders') }}</a></li>
                    @endrole

                    @role('Supplier')
                    <li><a class="slide-item" href="{{ url('supplier/orders') }}">Orders</a></li>
                    @endrole
                </ul>
                {{--
        </li>
    </ul> --}}



</aside>
<!-- /Sidebar menu-->

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

    

</body>

</html>
