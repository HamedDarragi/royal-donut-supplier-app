<div class="card-header">
    <div class="card-title">{{ trans('french.Products')}}</div>
    <div class="col-md-12">
        <div class="row pull-right">
            <div class="col-md-4 ">
                <select name="cats" id="cat" class="form-control">
                    <option value="all">{{ trans('french.All')}}</option>
                    <option value="null">{{ trans('french.No')}} {{ trans('french.category')}}</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <!-- <div class="col-md-3 ">
                <a href="javascript:void(0);" onClick="printPage(printsection.innerHTML)" class="btn btn-primary text-white"><i class="fa fa-print"></i> {{ trans('french.Print')}}</a>
            </div> -->
            <div class="col-md-3" style="">
                <a href="{{ route($view.'.create') }}" class="btn btn-primary text-white" style="margin-right:100px"><i
                        class="fa fa-plus"></i>
                        {{ trans('french.product')}}</a>
            </div>
        </div>
    </div>
</div>

<div class="card-body">
    <div class="table-responsive">
        @include('message')
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="wd-10p">#</th>
                    <th class="wd-25p">{{ trans('french.Image')}}</th>
                    <th class="wd-15p">{{ trans('french.Name')}} </th>
                    <th class="wd-15p">{{ trans('french.category')}} </th>
                    <th class="wd-15p">{{ trans('french.Supplier')}} </th>
                    <th class="wd-15p">{{ trans('french.Price')}} (€)</th>
                    <th class="wd-10p">{{ trans('french.status')}}</th>
                    <th class="wd-10p">{{ trans('french.Action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td id="editable{{ $product->id }}" contenteditable>
                        {{-- <input type="text"> --}}
                        {{$product->index}}
                    </td>
                    <script>
                        var input = document.getElementById("editable"+{{ $product->id }});
                        input.addEventListener("keyup", function(event) {
                      if (event.keyCode === 13) {
                       event.preventDefault();
                       var value = document.getElementById('editable'+{{ $product->id }}).innerHTML;
                       value = value.replace('<br>','')
                       var id = "{{ $product->id }}";
                       var _token = "{{ csrf_token() }}";
                       $.ajax({
                            type: 'post',
                            url: '{{ url("product/update/index/align") }}',
                            data: {id:id, _token:_token,index:value},
                            success : function(data){
                            if(data == 'done')
                            location.reload();
                            else
                            alert('Duplicate ID');
                            }
                        });
                      }
                    });
                    </script>
                    <td><img src="{{ asset('images/Product/'.$product->image) }}" style="height: 80px; width:150px"
                            alt="">
                    </td>
                    <td>{{ $product->name }}</td>
                    <td><i>{{ isset($product->category->name)? $product->category->name : 'No category' }}</i></td>
                    <td>{{ isset($product->supplier->first_name)?
                        $product->supplier->first_name.'
                        '.$product->supplier->last_name :
                        'No
                        supplier' }}</td>
                    <td>{{ getCurrencySign($product->price) }} </td>
                    <td>
                        <a href="{{ route('product.status',$product->id) }}"><span
                                class="label label-pill label-{{ $product->isActive == 1?'success':'danger' }} mt-2"
                                style="font-size:11px;">{{ $product->isActive == 1?
                                trans('message.isActive.active'):trans('message.isActive.inactive') }}</span>
                        </a>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-sm-3">
                                <a type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                    data-target="#Show{{ $product->id }}"><i class="fa fa-eye text-white"></i>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="{{ route('product.edit',$product->id) }}" class="btn btn-primary btn-sm"><i
                                        class="fa fa-edit text-white"></i></a>
                            </div>
                            <div class="col-sm-3">
                                <form action="{{ route('product.destroy',$product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="fa fa-trash text-white"></i></button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                {{-- Show Modal --}}
                <div class="modal" id="Show{{ $product->id }}" role="dialog" aria-labelledby="exampleModalLongTitle"
                    style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">{{ $product->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6>{{ trans('french.category')}}</h6>
                                    </div>
                                    <div class="col-sm-5">
                                        {{ optional($product->category)->name }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6> {{ trans('french.Description')}} </h6>
                                    </div>
                                    <div class="col-sm-5">
                                        {!! html_entity_decode($product->description) !!}
                                    </div>
                                </div>
                                <hr>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('french.Close')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="printsection" style="display:none">
    @if(count($products) == 0)
    <p>No product added in yet</p>
    @else
    <div class="table-responsive">
        @include('message')
        <table id="example" class="table table-striped table-bordered" width=100%>
            <thead>
                <tr>
                    <td style="font-weight: bold">Image</td>
                    <td style="font-weight: bold">Name </td>
                    <td style="font-weight: bold">Category </td>
                    <td style="font-weight: bold">Supplier </td>
                    <td style="font-weight: bold">Price</td>
                    <td style="font-weight: bold">Quantity</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td><img src="{{ asset('images/Product/'.$product->image) }}" style="height: 80px; width:150px"
                            alt="">
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ isset($product->category->name)? $product->category->name :
                        'No category' }}</td>
                    <td>{{ $product->supplier->first_name .'
                        '.$product->supplier->last_name }}</td>
                    <td>{{ getCurrencySign($product->price) }}</td>
                    <td>{{ $product->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<script language="javascript">
    function printPage(printContent) {
var display_setting="toolbar=yes,menubar=yes,";
display_setting+="scrollbars=yes,width=1000, height=1000, left=100, top=25";
var printpage=window.open("","",display_setting);
printpage.document.open();
printpage.document.write('<html><head><title>Print Page</title></head>');
printpage.document.write('<body onLoad="self.print()" align="center">'+ printContent );
printpage.document.close();
printpage.focus();
}
$('select').on('change', function() {
  var id = this.value;
  $.ajax({
            type:'GET',
            url: "{{route('getproducts')}}",
            data:{
               id : id
            },
            success:function(data) {
            var all_data = "";
            $('tbody').empty();
            console.log(data)
            data.forEach(function(value)
            {
                var img = 'http://royal-marketing.services/images/Product/'+value.image;
                var url = '{{ route("product.edit", ":id") }}';
                url = url.replace(':id', value.id);
                // window.location.href=url;
               all_data +=
                    '<tr><td>'+ value.index +'</td>'+
                    '<td><img src="'+img+'" style="height: 80px; width:150px" alt="">'
                    +'</td>'+
                    '<td>'+ value.name +'</td>';
                    if(value.category == null){
                        all_data +='<td>No Category</td>';
                    }else{
                        all_data +='<td>'+value.category.name+'</td>';
                    }
                    all_data +='<td>'+value.supplier.first_name+' '+value.supplier.last_name+'</td>'+
                    '<td>'+value.price+'</td>';
                    if(value.isActive == 0){
                        all_data+='<td> <span class="label label-pill label-danger">In Active</span></td>';
                    }else{
                        all_data+='<td> <span class="label label-pill label-success">Actice</span></td>';
                    }
                    all_data+='<td><div class="row"><div class="col-sm-3"><a type="button" data-toggle="modal" class="btn btn-success btn-sm" data-target="#Show'+value.id+'"><i class="fa fa-eye text-white"></i></a></div><div class="col-sm-3"><a href="'+url+'" class="btn btn-primary btn-sm"><i class="fa fa-edit text-white"></i></a></div><div class="col-sm-3"><form action={{ route("product.destroy",'+value.id+') }}" method="POST" enctype="multipart/form-data">@csrf @method("DELETE")<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash text-white"></i></button></form></div></div></td></tr>';
            });
            
            $('tbody').append(all_data);
            }
        });
});

</script>
</div>
