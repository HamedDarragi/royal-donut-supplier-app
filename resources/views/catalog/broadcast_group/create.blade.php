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
                <h3 class="card-title">Broadcast Group</h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($broadcast_group)? route('broadcast_group.update',$broadcast_group->id):route('broadcast_group.store') }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($broadcast_group)
                    @method('PUT')
                    @endisset
                    <div class="form-group">
                        <label class="form-label" for="name">Group Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="{{ isset($broadcast_group)?$broadcast_group->name:''}}" placeholder=" Enter Group Name">
                    </div>
                   


                    <div class="form-group mb-0">
                        <div class="checkbox checkbox-secondary">
                            <button type="submit"
                                class="btn btn-primary ">{{ isset($broadcast_group)? 'Update':'Save'}}</button>
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

