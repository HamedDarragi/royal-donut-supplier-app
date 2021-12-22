@extends('admin.layout.app')
@section('css')
<!-- file Uploads -->
<link href="{{asset('admin/assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card m-b-20">
            <div class="card-header">
                <h3 class="card-title">{{ trans('french.customer')}}</h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($customer)? route('customer.update',$customer->id):route('customer.store') }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($customer)
                    @method('PUT')
                    @endisset
                    <div class="form-group">
                        <label class="form-label" for="first_name">{{ trans('french.Name')}}</label>
                        <input type="text" class="form-control" name="first_name" id="first_name" required
                            value="{{ isset($customer)?$customer->first_name:''}}" placeholder=" Enter Name">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="email">{{ trans('french.Email')}}</label>
                        <input type="email" class="form-control" name="email" id="email" required
                            value="{{ isset($customer)?$customer->email:''}}" placeholder=" Enter email">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">{{ trans('french.Password')}}</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="***************">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="franchise_name">{{ trans('french.Franchise Name')}}</label>
                        <input type="text" class="form-control" name="franchise_name" id="franchise_name" required
                            value="{{ isset($customer)?$customer->franchise_name:''}}"
                            placeholder=" Enter Franchise name">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="mobilenumber">{{ trans('french.Mobile Number')}}</label>
                        <input type="text" class="form-control" name="mobilenumber" id="mobilenumber" required
                            value="{{ isset($customer)?$customer->mobilenumber:''}}" placeholder=" Enter mobile number">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="mobilenumber">City</label>
                        <input type="text" class="form-control" name="city" id="city" required
                            value="{{ isset($customer)?$customer->city:''}}" placeholder="City">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="address">{{ trans('french.Address')}}</label>
                        <input type="text" class="form-control" name="address" id="address" required
                            value="{{ isset($customer)?$customer->address:''}}" placeholder=" Enter address">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="address">{{ trans('french.Zip Code')}}</label>
                        <input type="number" class="form-control" name="zip_code" id="zip_code" required
                            value="{{ isset($customer)?$customer->zip_code:''}}" placeholder="">
                    </div>

                    <input type="hidden" name="user_type" value="Customer">


                    <div class="form-group mb-0">
                        <div class="checkbox checkbox-secondary">
                            <button type="submit" class="btn btn-primary ">{{ isset($customer)?
                                trans('french.Update'):trans('french.Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

<!-- Inline js -->
<script src="{{asset('admin/assets/js/formelements.js')}}"></script>

<!-- file uploads js -->
<script src="{{asset('admin/assets/plugins/fileuploads/js/fileupload.js')}}"></script>

<script>
    $("#zip_code").focusout(function(){
        var val = $("#zip_code").val();
        if(val.length < 5 || val.length > 5){
            alert('Value of zip code must contain 5 digit');
        }
    });
</script>

@endsection
