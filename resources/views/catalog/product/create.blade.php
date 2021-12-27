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
                <h3 class="card-title">{{ trans('french.product')}}</h3>
            </div>
            <div class="card-body">
                @include('message')
                <form action="{{ isset($product)? route('product.update',$product->id):route('product.store') }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($product)
                    @method('PUT')
                    @endisset
                    <div class="form-group">
                        <label class="form-label" for="name_en">{{ trans('french.category')}}</label>
                        <select name="category_id" id="" class="form-control">  
                            <option value="">-- Select --</option>
                            @foreach ($categories as $category)
                            @if(isset($product))
                            @if($product->category_id == $category->id)
                            <option value="{{  $category->id }}" selected>{{ $category->name }} </option>
                            @else
                            <option value="{{  $category->id }}">{{ $category->name }} </option>
                            @endif
                            @else
                            <option value="{{  $category->id }}">{{ $category->name }} </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <!--<input type="hidden" value="2" name="index">-->
                    <div class="form-group">
                        <label class="form-label" for="name"> {{ trans('french.Name')}} </label>
                        <input type="text" class="form-control" name="name" id="name" required
                            value="{{ isset($product)?$product->name:''}}" placeholder=" Enter Name">
                    </div>

                    {{-- <div class="form-group">
                        <label class="form-label" for="name_en">Manufacturer</label>
                        <select name="manufacturing_partner_id" id="manufacturer" class="form-control">
                            <option value="">-- Select --</option>
                            @foreach ($manufacturers as $manufacturer)
                            @if(isset($product))
                            @if($product->manufacturing_partner_id == $manufacturer->id)
                            <option value="{{  $manufacturer->id }}" selected>{{ $manufacturer->first_name }} </option>
                            @else
                            <option value="{{  $manufacturer->id }}">{{ $manufacturer->first_name }} </option>
                            @endif
                            @else
                            <option value="{{  $manufacturer->id }}">{{ $manufacturer->first_name }} </option>
                            @endif
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="form-group">
                        <label class="form-label" for="name_en">{{ trans('french.Supplier')}}</label>
                        <select name="supplier_id" id="supplier" class="form-control" required>
                            @empty($product)
                            <option disabled selected value="">-- Select --</option>
                            @endempty
                            @foreach ($suppliers as $supplier)
                            @if(isset($product))
                            @if($product->supplier_id == $supplier->id)
                            <option value="{{  $supplier->id }}" selected>{{ $supplier->first_name }} </option>
                            @else
                            <option value="{{  $supplier->id }}">{{ $supplier->first_name }} </option>
                            @endif
                            @else
                            <option value="{{  $supplier->id }}">{{ $supplier->first_name }} </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="price">{{ trans('french.Price')}} (€)</label>
                        <input type="number" class="form-control" name="price" min="1" required
                            value="{{ isset($product)?$product->price:''}}" placeholder=" Enter Price ">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="price">Package item </label>
                        <input type="number" class="form-control" name="package"  required
                        value="{{ isset($product)?$product->package:''}}"     placeholder=" Enter Package item ">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="price">{{ trans('french.Description')}} </label>
                        <textarea name="description" id="description" cols="30" class="form-control"
                            rows="10">{{ isset($product)?$product->description:''}}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="name">{{ trans('french.Image')}}</label>
                        <input type="file" class="dropify" name="image"
                            data-default-file="{{ isset($product)? asset('images/Product/'.$product->image):asset('admin/assets/images/media/media1.jpg')}}"
                            data-height="180" />
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="name_en">{{ trans('french.unit')}}</label>
                        <select name="unit_id" id="unit" class="form-control" required>
                            @empty($product)
                            <option disabled selected value="">-- Select --</option>
                            @endempty
                            @foreach ($units as $unit)
                            @if(isset($product))
                            @if($product->unit_id == $unit->id)
                            <option value="{{  $unit->id }}" selected>{{ $unit->name }} </option>
                            @else
                            <option value="{{  $unit->id }}">{{ $unit->name }} </option>
                            @endif
                            @else
                            <option value="{{  $unit->id }}">{{ $unit->name }} </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="price">{{ trans('french.Quantity')}}</label>
                        <input type="text" class="form-control" name="quantity" id="quantity" required
                            value="{{ isset($product)?$product->quantity:''}}" placeholder=" Enter quantity ">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="name_en">{{ trans('french.MINIMUM QUANTITY')}}</label>
                        <select name="min_req_qty" id="min_req_qty" class="form-control">
                            <option @isset($product) @if($product->min_req_qty == 1)
                                selected
                                @endif
                                @endisset
                                value="1">Active</option>
                            <option @isset($product) @if($product->min_req_qty == 0)
                                selected
                                @endif
                                @endisset
                                value="0">In-Active</option>
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <div class="checkbox checkbox-secondary">
                            <button type="submit" class="btn btn-primary ">{{ isset($product)?
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
