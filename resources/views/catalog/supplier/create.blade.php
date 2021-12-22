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
                <h3 class="card-title">{{trans('french.supplier')}}</h3>
            </div>
            @if($errors->any())
                <div style="background:red;color:white;padding:20px">
                    {{ implode('', $errors->all(':message')) }}
                </div>
            @endif
            <div class="card-body">
                <form action="{{ isset($supplier)? route('supplier.update',$supplier->id):route('supplier.store') }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($supplier)
                    @method('PUT')
                    @endisset
                    <div class="form-group">
                        <label class="form-label" for="name">{{trans('french.Name')}} </label>
                        <input type="text" class="form-control" name="first_name" id="name" required
                            value="{{ isset($supplier)?$supplier->first_name:''}}" placeholder=" Enter Name">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="name">{{trans('french.Name Abbreviation')}} </label>
                        <input type="text" class="form-control" name="abbrivation" id="name" minlength="2" maxlength="2" required
                            value="{{ isset($supplier)?$supplier->abbrivation:''}}" placeholder=" Enter Abbrivation">
                    </div>
                    {{-- <div class="form-group">
                        <label class="form-label" for="name">Last Name </label>
                        <input type="text" class="form-control" name="last_name" id="name" required
                            value="{{ isset($supplier)?$supplier->last_name:''}}" placeholder=" Enter Last Name">
                    </div> --}}
                    <div class="form-group">
                        <label class="form-label" for="name">{{trans('french.Email')}} </label>
                        <input type="email" class="form-control" name="email" id="name" required
                            value="{{ isset($supplier)?$supplier->email:''}}" placeholder=" Enter Email">
                    </div>

                    {{-- <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required
                            placeholder="*************">
                    </div> --}}

                    <div class="form-group">
                        <label class="form-label" for="name">{{trans('french.Mobile Number')}} </label>
                        <input type="text" class="form-control" name="mobilenumber" id="name"
                            value="{{ isset($supplier)?$supplier->mobilenumber:''}}" placeholder=" Enter Mobile Number">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="name">{{trans('french.Address')}} </label>
                        <input type="text" class="form-control" name="address" id="name"
                            value="{{ isset($supplier)?$supplier->address:''}}" placeholder=" Enter Address">
                    </div>
                    

                    <div class="form-group">
                        <label class="form-label" for="name">{{trans('french.Tax Number')}}</label>
                        <input type="text" class="form-control" name="fax_number" id="name"
                            value="{{ isset($supplier)?$supplier->fax_number:''}}" placeholder=" Enter Fax Number">
                    </div>
                    <div class="form-group">

                    <label class="form-label">{{trans('french.Delivery Companies')}}</label>
                    <select class="form-control glazes" name="company[]"
                        data-placeholder="Choose Browser">
                        <option value="">
                           None
                       </option>
                        @isset($supplier)
                        @foreach ($companies as $company)
                        
                         @php $company_sup = App\Models\CompanySupplier::where('delivery_company_id',$company->id)
                                                    ->where('supplier_id',$supplier->id)->first();
                         @endphp
                         @if(!empty($company_sup))
                        <option value="{{ $company->id }}" selected>
                            {{ $company->name }}
                        </option>
                        @else
                        
                        <option value="{{ $company->id }}">
                           {{ $company->name }}
                       </option>
                        @endif
                        @endforeach
                        @else
                        @foreach ($companies as $company)
                        
                       
                       <option value="{{ $company->id }}">
                           {{ $company->name }}
                       </option>
                       
                       
                        @endforeach
                        @endisset
                    </select>
                    </div>
                    <div class="form-group mb-0">
                        <div class="checkbox checkbox-secondary">
                            <button type="submit" class="btn btn-primary ">{{ isset($supplier)?
                                'Update':'Save'}}</button>
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
