@extends('admin.layout.app')


@section('content')
<div class="row card mt-5 p-2" style="">
    <div class="col-md-12 margin-tb mt-5 p-2" >
        <div class="pull-left">
            <h2>Role Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
        </div>
    </div>

    <div class="col-md-12">




<table class="table table-bordered">
  <tr>
     <th>No</th>
     <th>Name</th>
     <th width="280px">Action</th>
  </tr>
    @foreach ($roles as $key => $role)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $role->name }}</td>
        <td>
            <div class="row">
                <div class="col-lg-4">
                    <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}"><i class="fa fa-eye"></i></a>
                </div>
                <div class="col-lg-4">
                    <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}"><i class="fa fa-edit"></i></a>
                </div>
                @if($role->name != "SuperAdmin")
                <div class="col-lg-4">
                    <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                        @Method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                    </form>
                </div>
                @endif
            </div>
            
                
               
                
        </td>
    </tr>
    @endforeach
</table>
</div>
</div>

{!! $roles->render() !!}


@endsection