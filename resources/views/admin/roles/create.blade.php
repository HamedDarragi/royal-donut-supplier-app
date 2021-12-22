@extends('admin.layout.app')


@section('content')
<div class="row card mt-5 margin-tb p-2">
    <div class="col-lg-12">
        <div class="pull-left">
            <h2>Create New Role</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
        </div>
    </div>
</div>


@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif


<form action="{{ route('roles.store') }}" method="post" enctype="multipart/form-data">
    @csrf
<div class="row card mt-5 p-2">
    <div class="col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            <input type="text" name="name" class="form-control">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <strong>Permission:</strong>
            <br/>
            <div class="row">
            @foreach($permission as $value)
                
                    <div class="col-lg-4">
                        <label><input type="checkbox" name="permission[]" value="{{$value->id}}">
                        
                        {{ $value->name }}</label>
                        <br/>
                    </div>
                
                
            @endforeach
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</form>


@endsection