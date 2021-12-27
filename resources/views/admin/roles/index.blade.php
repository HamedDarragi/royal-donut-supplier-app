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
                    <button class="btn btn-info" data-toggle="modal" data-target="#role{{$role->id}}"><i class="fa fa-eye"></i></button>
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
                <div class="modal" id="role{{ $role->id }}" role="dialog" aria-labelledby="exampleModalLongTitle"
                    style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">{{ $role->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @php
                                $rolePermissions = Spatie\Permission\Models\Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
                                ->where("role_has_permissions.role_id",$role->id)
                                ->get();
                            @endphp
                            <div class="modal-body">

                                <div class="row card mt-5 p-2">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Name:</strong>
                                            {{ $role->name }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Permissions:</strong>
                                            @if(!empty($rolePermissions))
                                                @foreach($rolePermissions as $v)
                                                    <label class="label label-success">{{ $v->name }},</label>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('french.Close')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            
                
               
                
        </td>
    </tr>
    @endforeach
</table>
</div>
</div>

{!! $roles->render() !!}


@endsection