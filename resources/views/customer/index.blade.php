@extends('admin.layout.app')
@section('content')

<div class="card my-5">
    <div class="card-header">
        <h3 class="card-title">{{ trans('french.Suppliers') }}</h3>
        <div class="card-options">
            <span class="input-group-btn mx-2">
                <!-- <a class="btn">
                            <span class="fe fe-filter text-white" type="datepicker"></span>
                        </a> -->
            </span>
        </div>
    </div>
</div>
<section class="orderdetails my-2">
    <section class="col-md-12">
        <div class="row">
            @foreach ($suppliers as $supplier)
            @php
                $products=App\Models\Product::where('supplier_id',$supplier->id)->get();
                $cartcheck2=
                bilawalsh\cart\Models\Cart::where(['supplier_id'=>$supplier->id,'user_id'=>Auth::id()])->get()
                ->first();
            @endphp
            @if(count($products) > 0) 
            <div class="col-lg-4">
                @if(!empty($cartcheck2))
            
                
                <a href="{{ url('customer/cart') }}#Supplier{{ $supplier->id }}">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title text-center">{{$supplier->first_name}}
                                {{$supplier->last_name}}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                            $names =[];
                                            $categories=App\Models\Product::where('supplier_id',$supplier->id)->pluck('category_id');
                                            foreach($categories as $category)
                                            {
                                                $name= App\Models\Category::find($category);
                                                if(!in_array($name,$names)){
                                                    array_push($names,$name);
                                                }
                                            }
                                            ?>
                                <div class="col">
                                    @foreach($names as $name)
                                    <span class="badge badge-success">{{ isset($name)?optional($name)->name:'No
                                        Category' }}</span>
                                    @endforeach

                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                    </a>
                    @else
                    <a href="{{route('supplierdetails', $supplier->id)}}">
                        <div class="card m-b-20">
                            <div class="card-header">
                                <h3 class="card-title text-center">{{$supplier->first_name}}
                                    {{$supplier->last_name}}
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php
                                $names =[];
                                $categories=App\Models\Product::where('supplier_id',$supplier->id)->pluck('category_id');
                                foreach($categories as $category)
                                {
                                    $name= App\Models\Category::find($category);
                                    if(!in_array($name,$names)){
                                        array_push($names,$name);
                                    }
                                }
                                ?>
                                    <div class="col">

                                        @foreach($names as $name)
                                        <span class="badge badge-success">{{
                                            isset($name)?optional($name)->name:'No
                                            Category' }}</span>
                                        @endforeach

                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </a>
                    @endif

            </div>
            @endif
            @endforeach

        </div>
    </section>
</section>
@endsection
