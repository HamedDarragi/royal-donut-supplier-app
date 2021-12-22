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
                <h3 class="card-title">Broadcast</h3>
            </div>
            <div class="card-body">
                @include('message')
                <form action="{{ isset($broadcast)? route('broadcast.update',$broadcast->id):route('broadcast.store') }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($broadcast)
                    @method('PUT')
                    @endisset

                    <div class="form-group">
                        <label class="form-label" for="title">Title </label>
                        <input type="text" class="form-control" name="title" id="title"
                            value="{{ isset($broadcast)?$broadcast->title:''}}" placeholder=" Enter Title">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="">Message </label>
                        <textarea name="message" id="message" cols="30" class="form-control"
                            rows="10">{{ isset($broadcast)?$broadcast->message:''}}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="expiry_date">Expiry Date</label>
                        <input type="date" class="form-control" name="expiry_date" id="expiry_date"
                            value="{{ isset($broadcast)?$broadcast->expiry_date:''}}">
                    </div>

                   
                    <div class="form-group">
                        <label class="form-label" for="">Status</label>
                        <select name="isActive" id="" class="form-control">
                            @empty($broadcast)
                            <option disabled selected value="">-- Select --</option>
                            @else
                            @if($broadcast->isActive == 1)
                            <?php
                            $status='Active';
                            ?>
                            @else
                            <?php
                            $status='In-Active';
                            ?>
                            @endif
                            <option disabled selected value="{{$broadcast->isActive}}">{{$status}}</option>
       
                            @endempty
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                            
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="file">Image</label>
                        <input type="file" class="dropify" name="image"
                            data-default-file="{{ isset($broadcast)? asset('images/broadcast/'.$broadcast->image):asset('admin/assets/images/media/media1.jpg')}}"
                            data-height="180" />
                    </div>

                    <div class="form-group mb-0">
                        <div class="checkbox checkbox-secondary">
                            <button type="submit"
                                class="btn btn-primary ">{{ isset($broadcast)? 'Update':'Save'}}</button>
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
<script>
    CKEDITOR.replace( 'message', {
                                                        toolbar: [
                                                        // { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview',
                                                        // 'Print', '-', 'Templates' ] },
                                                        { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord',
                                                        '-', 'Undo', 'Redo' ] },
                                                        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-',
                                                        'Scayt' ] },
                                                        { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton',
                                                        'HiddenField' ] },
                                                        { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                                                        // '/',
                                                        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike',
                                                        'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                                                        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList',
                                                        '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight',
                                                        'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                                                        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                                                        // { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ]
                                                        // },
                                                        // '/',
                                                        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                                                        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                                                        { name: 'others', items: [ '-' ] },
                                                        // { name: 'about', items: [ 'About' ] }
                                                        ],
                                                            filebrowserUploadUrl: "",
                                                            filebrowserUploadMethod: 'form'
                                						});
</script>

<!-- Inline js -->
<script src="{{asset('admin/assets/js/formelements.js')}}"></script>

<!-- file uploads js -->
<script src="{{asset('admin/assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<!-- select2 Plugin -->
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

