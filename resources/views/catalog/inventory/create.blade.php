@extends('admin.layout.app')
@section('css')
<!-- file Uploads -->
<link href="{{asset('admin/assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
<!-- select2 Plugin -->
<link href="{{asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<style>
    textarea:hover {
        background-color: rgb(201, 199, 199)
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card m-b-20">
            <div class="card-header">
                <h3 class="card-title">{{ $view }}</h3>
            </div>
            <div class="card-body">
                @include('message')
                <form action="{{ isset($inventory)? route('inventory.update',$inventory->id):route('inventory.store') }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($inventory)
                    @method('PUT')
                    @endisset
                    <div class="form-group">
                        <label class="form-label" for="name_en">Product</label>
                        <select name="product_id" id="" class="form-control">
                          
                            @isset($inventory)
                            <option disabled selected value="{{$inventory->product_id}}">{{$inventory->product->name}}</option>
                            @endisset
                            @empty($inventory)
                            <option disabled selected value="">-- Select --</option>
                            @endempty
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="quantity">Quantity</label>
                        <input type="number" class="form-control" name="quantity" id="quantity"
                            value="{{ isset($inventory)?$inventory->quantity:''}}" placeholder=" Enter Quantity">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="name_en">Unit</label>
                        <select name="unit_id" id="" class="form-control">
                            @empty($inventory)
                            <option disabled selected value="">-- Select --</option>
                            @endempty
                            @isset($inventory)
                            <option disabled selected value="{{$inventory->unit_id}}">{{$inventory->unit->name }}</option>
                            @endisset
                            @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                 

                    <div class="form-group mb-0">
                        <div class="checkbox checkbox-secondary">
                            <button type="submit"
                                class="btn btn-primary ">{{ isset($inventory)? 'Update':'Save'}}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')


</script>
@isset($product)
<script>
    $('.categories').val({!! json_encode($product->id) !!}).trigger('change');
</script>
@endisset
<!-- Inline js -->
<script src="{{asset('admin/assets/js/formelements.js')}}"></script>

<!-- file uploads js -->
<script src="{{asset('admin/assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<!-- select2 Plugin -->
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

