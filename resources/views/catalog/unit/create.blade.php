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
                <h3 class="card-title">{{ trans('french.unit')}}</h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($unit)? route('unit.update',$unit->id):route('unit.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @isset($unit)
                    @method('PUT')
                    @endisset
                    <div class="form-group">
                        <label class="form-label" for="name">{{ trans('french.unit')}}</label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="{{ isset($unit)?$unit->name:''}}" placeholder=" Enter Unit Name" required>
                    </div>
                    {{-- <div class="form-group">
                        <label class="form-label" for="symbol">symbol</label>
                        <input type="text" class="form-control" name="symbol" id="symbol"
                            value="{{ isset($unit)?$unit->symbol:''}}" placeholder=" Enter Symbol">
                    </div> --}}
                    <div class="form-group">
                        <label class="form-label" for="abbreviation">{{ trans('french.abbreviation')}}</label>
                        <input type="text" class="form-control" name="abbreviation" id="abbreviation"
                            value="{{ isset($unit)?$unit->abbreviation:''}}" placeholder=" Enter Abbreviation" required>
                    </div>


                    <div class="form-group mb-0">
                        <div class="checkbox checkbox-secondary">
                            <button type="submit" class="btn btn-primary ">{{ isset($unit)? trans('french.Update'):trans('french.Save')}}</button>
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
