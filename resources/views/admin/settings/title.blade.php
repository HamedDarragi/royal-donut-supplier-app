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
                <h3 class="card-title">{{ trans('french.Title')}}</h3>
            </div>
            <div class="card-body">
                @include('message')
                <form action="{{ route('title.update',$setting->id) }}"
                    method="post" enctype="multipart/form-data">
                    
                    @csrf
                    
                   

                   <input type="hidden" name="id" value="{{ $setting->id }}">
                    
                    <div class="form-group">
                        <label class="form-label" for="price">{{ trans('french.Title')}} </label>
                        <input name="title" id="title" type="text" max-length="255" class="form-control" value="{{ $setting->title}}"
                            >
                    </div>
                    
                   
                   
                    <div class="form-group mb-0">
                        <div class="checkbox checkbox-secondary">
                            <button type="submit" class="btn btn-primary ">{{ trans('french.Update')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

<script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js">
</script>

@endsection
