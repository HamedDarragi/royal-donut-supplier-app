<div class="app-header1 header py-1 d-flex" style="background:#ec607f !important;">
    <div class="container-fluid">
        <div class="d-flex">
        @role('Customer')
            <a class="header-brand" href="/customer/suppliers">
                {{-- <img src="{{asset('admin/assets/images/brand/logo1.png')}}" class="header-brand-img" alt="Lmslist
                logo"> --}}
                <h2 style='color:white; margin-top:12px;'>
                   
                    {{ config('app.customer') }}
                   
                   
                </h2>
            </a>
            @endrole
            @role('Admin')
            <a class="header-brand" href="/product">
                {{-- <img src="{{asset('admin/assets/images/brand/logo1.png')}}" class="header-brand-img" alt="Lmslist
                logo"> --}}
                <h2 style='color:white; margin-top:12px;'>
                
                    {{ config('app.admin') }}
                   
                   
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
