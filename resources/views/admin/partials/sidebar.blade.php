
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
                <!-- Super Admin -->

                @role('SuperAdmin')
                    @can('Products')
                    <li><a class="slide-item" href="{{ route('product.index') }}">{{ trans('french.Products') }}</a></li>
                    @endcan
                    @can('Categories')
                    <li><a class="slide-item" href="{{ route('category.index') }}">{{ trans('french.Categories') }}</a></li>
                    @endcan
                    @can('Orders')
                    <li><a class="slide-item" href="{{url('orders')}}">{{ trans('french.Orders') }}</a></li>
                    @endcan
                    @can('Units')
                    <li><a class="slide-item" href="{{ route('unit.index') }}">{{ trans('french.Units') }}</a></li>
                    
                    {{-- <li><a class="slide-item" href="{{ route('inventory.index') }}">Inventory</a></li> --}}
                    @endcan
                    @can('Admins')
                    <li><a class="slide-item" href="{{ route('admins.index') }}">Admins</a></li>
                   
                    @endcan
                    @can('Customers')
                    <li><a class="slide-item" href="{{ route('customer.index') }}">{{ trans('french.Customers') }}</a></li>
                   
                    @endcan
                    @can('Suppliers')
                    
                    <li><a class="slide-item" href="{{ route('supplier.index') }}">{{ trans('french.Suppliers') }}</a></li>
                    @endcan
                    @can('DeliveryCompanies')
                    <li><a class="slide-item" href="{{ route('deliverycompany.index') }}">{{ trans('french.Delivery Companies') }}</a></li>
                    @endcan
                    @can('Calendar')
                    <li><a class="slide-item" href="{{ route('calendar') }}">{{ trans('french.Calendar') }}</a></li>
                    @endcan
                    @can('Rules')
                    <li><a class="slide-item" href="{{ route('rule.index') }}">{{ trans('french.Rules')}}</a></li>
                    @endcan
                    @can('Backlogs')
                    <li><a class="slide-item" href="{{ route('backlogs.index') }}">{{ trans('french.Backlogs')}}</a></li>
                    @endcan
                    @can('Associate Rule')
            <li><a class="slide-item" href="{{ route('associate_rule.index') }}">{{ trans('french.Associate Rule')}}</a></li>
            @endcan
                    @can('ManageRoles')
            <li><a class="slide-item" href="{{ route('roles.index') }}">Manage Role</a></li>
            @endcan
                    @can('Backups')
            <li><a class="slide-item" href="{{ route('backupmanager') }}">Backups</a></li>
            @endcan
                    @can('EmailSettings')
                    <li>
                    <details>
                        <summary class="mt-2">{{ trans('french.Email Settings') }}</summary>
                        <a class="slide-item ml-5" href="{{ route('footer') }}"><i class="fa fa-sliders-h"></i>&nbsp;{{ trans('french.Email Footer') }}</a>
                            <!-- <li><a class="slide-item ml-5" href="{{ route('title') }}"><i class="fa fa-sliders-h"></i>&nbsp;{{ trans('french.Title') }}</a></li> -->
                            <a class="slide-item ml-5" href="{{ route('emailhistory') }}"><i class="fa fa-sliders-h"></i>&nbsp;{{ trans('french.Email History') }}</a>
                        
                    </details>
                    </li>
                    @endcan
                    @endrole

                <!-- End Super Admin -->
                @role('Admin')
                    @can('Products')
                    <li><a class="slide-item" href="{{ route('product.index') }}">{{ trans('french.Products') }}</a></li>
                    @endcan
                    @can('Categories')
                    <li><a class="slide-item" href="{{ route('category.index') }}">{{ trans('french.Categories') }}</a></li>
                    @endcan
                    @can('Orders')
                    <li><a class="slide-item" href="{{url('orders')}}">{{ trans('french.Orders') }}</a></li>
                    @endcan
                    @can('Units')
                    <li><a class="slide-item" href="{{ route('unit.index') }}">{{ trans('french.Units') }}</a></li>
                    
                    {{-- <li><a class="slide-item" href="{{ route('inventory.index') }}">Inventory</a></li> --}}
                    @endcan
                    @can('Admins')
                    <li><a class="slide-item" href="{{ route('admins.index') }}">Admins</a></li>
                   
                    @endcan
                    @can('Customers')
                    <li><a class="slide-item" href="{{ route('customer.index') }}">{{ trans('french.Customers') }}</a></li>
                   
                    @endcan
                    @can('Suppliers')
                    
                    <li><a class="slide-item" href="{{ route('supplier.index') }}">{{ trans('french.Suppliers') }}</a></li>
                    @endcan
                    @can('DeliveryCompanies')
                    <li><a class="slide-item" href="{{ route('deliverycompany.index') }}">{{ trans('french.Delivery Companies') }}</a></li>
                    @endcan
                    @can('Calendar')
                    <li><a class="slide-item" href="{{ route('calendar') }}">{{ trans('french.Calendar') }}</a></li>
                    @endcan
                    @can('Rules')
                    <li><a class="slide-item" href="{{ route('rule.index') }}">{{ trans('french.Rules')}}</a></li>
                    @endcan
                    @can('Backlogs')
                    <li><a class="slide-item" href="{{ route('backlogs.index') }}">{{ trans('french.Backlogs')}}</a></li>
                    @endcan
                    @can('Associate Rule')
            <li><a class="slide-item" href="{{ route('associate_rule.index') }}">{{ trans('french.Associate Rule')}}</a></li>
            @endcan
                    @can('ManageRoles')
            <li><a class="slide-item" href="{{ route('roles.index') }}">Manage Role</a></li>
            @endcan
                    @can('Backups')
            <li><a class="slide-item" href="{{ route('backupmanager') }}">Backups</a></li>
            @endcan
                    @can('EmailSettings')
                    <li>
                    <details>
                        <summary class="mt-2">{{ trans('french.Email Settings') }}</summary>
                        <a class="slide-item ml-5" href="{{ route('footer') }}"><i class="fa fa-sliders-h"></i>&nbsp;{{ trans('french.Email Footer') }}</a>
                            <!-- <li><a class="slide-item ml-5" href="{{ route('title') }}"><i class="fa fa-sliders-h"></i>&nbsp;{{ trans('french.Title') }}</a></li> -->
                            <a class="slide-item ml-5" href="{{ route('emailhistory') }}"><i class="fa fa-sliders-h"></i>&nbsp;{{ trans('french.Email History') }}</a>
                        
                    </details>
                    </li>
                    @endcan
                    @endrole

                    @role('Customer')
                    
                    @can('Suppliers')
                    <li><a class="slide-item" href="{{ url('customer/suppliers') }}">{{ trans('french.Suppliers') }}</a></li>
                    <!-- <li><a class="slide-item" href="{{url('customer/cart_page')}}">Cart</a></li> -->
                    @endcan
                    @can('Orders')
                    <li><a class="slide-item" href="{{url('customer/myorders')}}">{{ trans('french.Orders') }}</a></li>
                    @endcan
                    
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
