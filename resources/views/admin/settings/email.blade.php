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
                <h3 class="card-title">Email</h3>
            </div>
            <div class="card-body">
                @include('message')
                <form action="{{ route('email.send') }}"
                    method="post" enctype="multipart/form-data">
                    
                    @csrf
                   
                   <input type="hidden" name="id" value="{{ $setting->id }}">
                   <input type="hidden" name="order" value="{{ $order->id }}">
                   <input type="hidden" name="sup" value="{{ $order->id }}">
                   <input type="hidden" name="message" value="{{ $message }}">



                   <input type="hidden" name="header" value="{{isset($supplier->header)? $supplier->header: 'No header exist'}}
">
                   <input type="hidden" name="footer" value="{{ $setting->description }}">

                    <div class="form-group">
                        <!-- <label class="form-label" for="price">Header</label>
                        <textarea name="header" id="header" cols="30" class="form-control"
                            rows="1"> -->
                            @if(isset($supplier->header))
                            @php
                                
                                $head = str_replace("{suplier_name}",$supplier->first_name,$supplier->header);
                                $head = str_replace("{mobile_number}",$supplier->mobilenumber,$head);
                                $head = str_replace("{address}",$supplier->address,$head);
                                $head = str_replace("{email}",$supplier->email,$head);
                                $head = str_replace("{total}",$order->total,$head);
                                $head = str_replace("{customer_name}",$order->user_name,$head);
                                $head = str_replace("{order_number}",$order->order_number,$head);
                                $head = str_replace("{customer_city}",$customer->city,$head);
                                $head = str_replace("{delivery_date}","",$head);

                            @endphp
                            <p>{!! html_entity_decode($head) !!}</p>
                            @else
                            <p>No Header Exist</p>
                            @endif

                        <!-- </textarea> -->
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="price">{{ trans('french.Content')}}</label>
                        @include('admin.settings.orderview')
                    </div>
                    <div class="form-group">
                        Expected Delivery date for your order is <b>{{$order->delivery_date}}</b>
                    </div>
                    <div class="form-group">
                        <!-- <label class="form-label" for="price">Footer</label>
                        <textarea name="footer" id="footer" cols="30" readonly class="form-control"
                            rows="3"> -->
                            {!! html_entity_decode($setting->description) !!}
                        <!-- </textarea> -->
                    </div>
                    
                   
                    @if(isset($supplier->header))
                    <div class="form-group mb-0">
                        <div class="checkbox checkbox-secondary">
                            <button type="submit" class="btn btn-primary "> <i class="fa fa-paper-plane"></i>&nbsp;{{ trans('french.Send')}}</button>
                            
                        </div>
                    </div>
                    @else
                    <p style="color:red">Please Add Header for supplier <b style="color:black">{{ $supplier->first_name }}</b> before sending email</p>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

<script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js">
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
