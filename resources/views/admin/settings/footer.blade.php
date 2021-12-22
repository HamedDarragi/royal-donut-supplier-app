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
                <h3 class="card-title">{{ trans('french.Footer Signature')}}</h3>
            </div>
            <div class="card-body">
                @include('message')
                <form action="{{ route('footer.update') }}"
                    method="post" enctype="multipart/form-data">
                    
                    @csrf
                    @if(isset($setting))
                    <input type="hidden" name="update" value="update">
                   <input type="hidden" name="id" value="{{ $setting->id }}">

                    @else
                    <input type="hidden" name="create" value="create">
                    @endif
                   

                    
                    <div class="form-group">
                        <textarea name="description" id="description" cols="30" class="form-control"
                            rows="10">{{ isset($setting)?$setting->description: ""}}</textarea>
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
<script>
    CKEDITOR.replace( 'description', {
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
@isset($product)
<script>
    $('.categories').val({!! json_encode($product->id) !!}).trigger('change');
</script>
@endisset
<!-- Inline js -->
<script src="{{asset('admin/assets/js/formelements.js')}}"></script>

<!-- file uploads js -->
<script src="{{asset('admin/assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<!-- select2 Plugin -->
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection
