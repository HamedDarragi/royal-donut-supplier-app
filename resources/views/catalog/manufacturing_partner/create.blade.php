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
                <h3 class="card-title">Manufacturing Partner</h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($manufacturing_partner)? route('manufacturing_partner.update',$manufacturing_partner->id):route('manufacturing_partner.store') }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($manufacturing_partner)
                    @method('PUT')
                    @endisset
                    <div class="form-group">
                        <label class="form-label" for="first_name">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name" required
                            value="{{ isset($manufacturing_partner)?$manufacturing_partner->first_name:''}}" placeholder=" Enter first name">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="last_name">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name" required
                            value="{{ isset($manufacturing_partner)?$manufacturing_partner->last_name:''}}" placeholder=" Enter last name">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required
                            value="{{ isset($manufacturing_partner)?$manufacturing_partner->email:''}}" placeholder=" Enter email">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="mobilenumber">Mobile Number</label>
                        <input type="text" class="form-control" name="mobilenumber" id="mobilenumber" required
                            value="{{ isset($manufacturing_partner)?$manufacturing_partner->mobilenumber:''}}" placeholder=" Enter mobile number">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="address">Address</label>
                        <input type="text" class="form-control" name="address" id="address" required
                            value="{{ isset($manufacturing_partner)?$manufacturing_partner->address:''}}" placeholder=" Enter address">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="company">Company</label>
                        <input type="text" class="form-control" name="company" id="company" required
                            value="{{ isset($manufacturing_partner)?$manufacturing_partner->company:''}}" placeholder=" Enter company">
                    </div>


                    <div class="form-group mb-0">
                        <div class="checkbox checkbox-secondary">
                            <button type="submit"
                                class="btn btn-primary ">{{ isset($manufacturing_partner)? 'Update':'Save'}}</button>
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

@endsection

