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
                <h3 class="card-title">Admin</h3>
            </div>
            @if($errors->any())
                <div style="background:red;color:white;padding:20px">
                    {{ implode('', $errors->all(':message')) }}
                </div>
            @endif
            <div class="card-body">
                <form action="{{ isset($admin)? route('admins.update',$admin->id):route('admins.store') }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($admin)
                    @method('PUT')
                    @endisset
                    <div class="form-group">
                        <label class="form-label" for="first_name">{{ trans('french.Name')}}</label>
                        <input type="text" class="form-control" name="first_name" id="first_name" required
                            value="{{ isset($admin)?$admin->first_name:''}}" placeholder=" Enter Name">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="email">{{ trans('french.Email')}}</label>
                        <input type="email" class="form-control" name="email" id="email" required
                            value="{{ isset($admin)?$admin->email:''}}" placeholder=" Enter email">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">{{ trans('french.Password')}}</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="***************">
                    </div>
                    <input type="hidden" value="adm" name="adm">
                    <div class="form-group">
                        <label class="form-label" for="address">Role</label>
                        <select name="user_type" id="user_type" class="form-control" required>
                            <option value="none">None</option>
                            @foreach($roles as $role)
                            @if(isset($admin))
                                @if($admin->hasRole($role->name))
                                    <option value="{{$role->name}}" selected>{{$role->name}}</option>
                                @else
                                    <option value="{{$role->name}}">{{$role->name}}</option>
                                @endif
                            @else
                                <option value="{{$role->name}}">{{$role->name}}</option>
                            @endif
                            
                            @endforeach
                        </select>
                    </div>

                   


                    <div class="form-group mb-0">
                        <div class="checkbox checkbox-secondary">
                            <button type="submit" class="btn btn-primary ">{{ isset($admin)?
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
