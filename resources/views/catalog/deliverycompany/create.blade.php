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
                <h3 class="card-title">{{ trans('french.Delivery Company')}}</h3>
            </div>
            <div class="card-body">
                @include('message')
                <form action="{{ isset($company)? route('deliverycompany.update',$company->id):route('deliverycompany.store') }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($company)
                    @method('PUT')
                    @endisset
                    
                    <div class="form-group">
                        
                        <label class="form-label" for="quantity">{{ trans('french.Name')}}</label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="{{ isset($company)?$company->name:''}}" placeholder=" Enter Name">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="quantity">{{ trans('french.Minimum Order Amount')}}</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">€</span>
                            </div>
                            <input type="number" min="0" class="form-control" name="minimum_order_amount" id="minimum_order_amount"
                            value="{{ isset($company)?$company->minimum_order_amount:''}}" placeholder="">
                        </div>
                        
                        
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="quantity">{{ trans('french.Delivery Fee')}}</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">€</span>
                            </div>
                            <input type="number" min="0" class="form-control" name="delivery_fee" id="delivery_fee"
                            value="{{ isset($company)?$company->delivery_fee:''}}" placeholder="">
                        </div>
                        
                    </div>

                   

                 

                    <div class="form-group mb-0">
                        <div class="checkbox checkbox-secondary">
                            <button type="submit"
                                class="btn btn-primary ">{{ isset($company)? trans('french.Update'):trans('french.Save')}}</button>
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
</script>
@endisset
<!-- Inline js -->
<script src="{{asset('admin/assets/js/formelements.js')}}"></script>

<!-- file uploads js -->
<script src="{{asset('admin/assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<!-- select2 Plugin -->
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

