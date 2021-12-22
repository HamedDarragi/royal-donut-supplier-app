@extends('admin.layout.app')
@section('css')
<!-- file Uploads -->
<link href="{{asset('admin/assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card m-b-20">
            
            @if($errors->any())
                <div style="background:red;color:white;padding:20px">
                    {{ implode('', $errors->all(':message')) }}
                </div>
            @endif
            <div class="card-body">
                <form action="{{ isset($supplier->header)? route('header.update'):route('header.store') }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                    <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{$supplier->header}}</textarea>
                    <input type="hidden" name="id" value="{{$supplier->id}}" >

                    </div>
                    <div class="form-group mb-0">
                        <div class="checkbox checkbox-secondary">
                            <button type="submit" class="btn btn-primary ">{{ isset($supplier->header)?
                                trans('french.Update'):trans('french.Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container">
<div class="row short-codes">
    <div class="col-lg-6">
        <h4><i class="fa fa-code"></i> SHORT CODES</h4>
    </div>
    <div class="col-lg-6">
       
            
            <button type="button" class="short-code-button" id="open" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-plus"></i>
            </button>
            <button class="short-code-button" style="display:none" id="close" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-minus"></i>
            </button>
            <!-- <button type="button" class="" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                
            </button> -->
        
    </div>
</div>
<hr>
<div class="collapse" id="collapseExample">
            <div class="card card-body">
                <h5 style="margin-bottom:5px">Supplier</h5>
                <div class="short-code-data">
                    {suplier_name} , {mobile_number} , {address} , {email}
                </div>
                <h5 style="margin-top:10px;margin-bottom:5px">Order</h5>
                <div class="short-code-data">
                     {total}, {order_number}
                </div>
                <h5 style="margin-top:10px;margin-bottom:5px">Customer</h5>
                <div class="short-code-data">
                    {customer_name} ,{customer_city}
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
<!-- Inline js -->
<script src="{{asset('admin/assets/js/formelements.js')}}"></script>

<!-- file uploads js -->
<script src="{{asset('admin/assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<script>
    $("#zip_code").focusout(function(){
        var val = $("#zip_code").val();
        if(val.length < 5 || val.length > 5){
            alert('Value of zip code must contain 5 digit');
        }
    });

    
    $("#close").click(function(){
        $(".collapse.show").css('display','none');
        $("#open").css('display','block');
        $("#close").css('display','none');

    });

    $("#open").click(function(){
        
        $(".collapse").css('display','block');
        $("#open").css('display','none');
        $("#close").css('display','block');
    });

</script>

@endsection
