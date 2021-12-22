<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Sarfraz Ahmed (sarfraznawaz2005@gmail.com)">

    <title>Backup Manager</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap4.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        body {
            /* padding-top: 4rem; */
            font-size: 0.8rem;
            font-family: sans-serif;
            line-height: 1.0;
            margin-bottom: 50px;
            background-color: #cccccc;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3E%3Cg fill='%23dddddd' fill-opacity='0.4'%3E%3Cpath fill-rule='evenodd' d='M0 0h4v4H0V0zm4 4h4v4H4V4z'/%3E%3C/g%3E%3C/svg%3E");
        }

        .table td,
        .table th {
            padding: .50rem;
            vertical-align: middle;
        }

        .table thead {
            background-image: linear-gradient(#eee, #ddd);
        }

        .card-header {
            padding: .40rem 1.25rem;
            line-height: 250%;
        }

        .warning {
            background: #FAF2CC;
        }

        legend {
            border: 0 none;
            font-size: 14px;
            line-height: 20px;
            margin-bottom: 0;
            width: auto;
            padding: 0 10px;
            font-weight: bold;
        }

        fieldset {
            border: 1px solid #e0e0e0;
            padding: 10px;
        }

        /*==================================================
        * Effect 2
        * ===============================================*/
        .shadow {
            position: relative;
        }

        .shadow:before,
        .shadow:after {
            z-index: -1;
            position: absolute;
            content: "";
            bottom: 15px;
            left: 10px;
            width: 50%;
            top: 80%;
            max-width: 300px;
            background: #222222;
            -webkit-box-shadow: 0 15px 10px #222222;
            -moz-box-shadow: 0 15px 10px #222222;
            box-shadow: 0 15px 10px #222222;
            -webkit-transform: rotate(-3deg);
            -moz-transform: rotate(-3deg);
            -o-transform: rotate(-3deg);
            -ms-transform: rotate(-3deg);
            transform: rotate(-3deg);
        }

        .shadow:after {
            -webkit-transform: rotate(3deg);
            -moz-transform: rotate(3deg);
            -o-transform: rotate(3deg);
            -ms-transform: rotate(3deg);
            transform: rotate(3deg);
            right: 10px;
            left: auto;
        }

        .stripe {
            color: white;
            background: repeating-linear-gradient(45deg, #007BFF, #007BFF 20%, #3898ff 10px, #3898ff);
            background-size: 100% 20px;
        }

        nav {
            background-image: radial-gradient(#37ba37, #34a334);
        }

        a:hover {
            text-decoration: none;
        }

    </style>

    @stack('styles')
</head>

<body>


    <div class="app-header1 header py-1 d-flex" style="background:#ec607f !important;margin-bottom:30px;">
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
                    <a class="header-brand" href="{{ url('product') }}">
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
                            $c = bilawalsh\cart\Models\Cart::where('user_id', auth()->user()->id)->count();
                        @endphp
                        <a href="{{ url('customer/cart') }}" class="icon-shopping-cart  text-white"
                            style="font-size: 25px; "><i class="fa fa-shopping-cart" style="font-size: 25px"></i>
                            <label ID="lblCartCount" runat="server" CssClass="badge badge-warning"
                                style="background-color:white; color:black" ForeColor="black" />{{ isset($c) ? $c : '0' }}
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

                </div>

            </div>
        </div>
    </div>

    <main role="main" class="container">

        <div class="card shadow">
            <div class="card-header" style="background:#ec607f;">
                <strong>@yield('title')</strong>

                <div class="float-right">
                    @yield('header')
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="card-body">
                @if (Session::has('messages'))
                    @foreach (Session::get('messages') as $message)
                        <p class="alert alert-{{ $message['type'] }}">
                            <strong>{{ $message['message'] }}</strong>
                        </p>
                    @endforeach
                @endif

                @yield('content')
            </div>

        </div>
    </main>

    <!-- Bootstrap core JavaScript
================================================== -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
    </script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $('[data-toggle="tooltip"]').tooltip();
    </script>

    @stack('scripts')

</body>

</html>
