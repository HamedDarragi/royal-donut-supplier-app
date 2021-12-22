@extends('admin.layout.app')
@section('css')
<!-- file Uploads -->
<link href="{{asset('admin/assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        @if ($errors->any())
        <div class="alert alert-danger">
            <div>
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
        @endif
        <div class="card m-b-20">
            <div class="card-header">
                <h3 class="card-title">{{ trans('french.category')}}</h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($category)? route('category.update',$category->id):route('category.store') }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($category)
                    @method('PUT')
                    @endisset
                    <div class="form-group">
                        <label class="form-label" for="name">{{ trans('french.category')}} </label>
                        <input type="text" class="form-control" name="name" id="name" required
                            value="{{ isset($category)?$category->name:''}}" placeholder=" Enter Name">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="name">Image</label>
                        <input type="file" class="dropify" name="image"
                            data-default-file="{{ isset($category)? asset('images/Category/'.$category->image):asset('admin/assets/images/media/media1.jpg')}}"
                            data-height="180" />
                    </div>
                    <div class="form-group mb-0">
                        <div class="checkbox checkbox-secondary">
                            <button type="submit" class="btn btn-primary ">{{ isset($category)?
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

@endsection
