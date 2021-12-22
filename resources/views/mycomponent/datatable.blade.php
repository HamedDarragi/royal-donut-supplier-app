@extends('admin.layout.app')
@section('css')
<link href="{{ asset('admin/assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/datatable/jquery.dataTables.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
          
             @if($view=='orders')
            @include('supplier.'.$view)
            @else
            @include('catalog.'.$view.'.index')
            @endif
            
            <!-- table-wrapper -->
        </div>
        <!-- section-wrapper -->
    </div>
</div>
@endsection
@section('script')
<!-- Data tables -->
<script src="{{ asset('admin/assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/datatable.js') }}"></script>

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
@endsection
