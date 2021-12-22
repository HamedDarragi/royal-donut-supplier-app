<!--
<div class="col-sm-4" style="margin-top:20px;"  >
 <form action="{{url('supplier/search')}}" method="POST" enctype="multipart/form-data">
 @csrf
        <input type="text" id="searchbar" placeholder="Search.." name="search">
        <button type="submit"><i class="fa fa-search"></i></button>
</form>
</div> -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">
<div class="card-header">
    <div class="card-title">{{trans('french.Suppliers')}}</div>
    <div class="col-md-11">
        <div class="text-right mr-5">
            <a href="{{ route($view.'.create') }}" class="btn btn-primary text-white mr-5"><i class="fa fa-plus"></i>
            {{trans('french.Supplier')}}</a>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        @include('message')
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="wd-25p">{{trans('french.Name')}}</th>
                    <th class="wd-15p">{{trans('french.Email')}}</th>
                    <th class="wd-10p">{{trans('french.Mobile Number')}}</th>
                    {{-- <th class="wd-10p">Status</th> --}}
                    <th class="wd-10p">{{trans('french.Action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->first_name }} {{ $supplier->last_name }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td>{{ $supplier->mobilenumber }}</td>
                    {{-- <td>
                        <a href="{{ route('supplier.status',$supplier->id) }}"><span
                                class="label label-pill label-{{ $supplier->isActive == 1?'success':'danger' }} mt-2"
                                style="font-size:11px;">{{ $supplier->isActive == 1?
                                trans('message.isActive.active'):trans('message.isActive.inactive') }}</span>
                        </a>
                    </td> --}}

                    {{-- <td>
                        <a href="{{ route('supplier.status',$supplier->id) }}"><span
                                class="label label-pill label-{{ $supplier->isActive == 1?'success':'danger' }} mt-2"
                                style="font-size:11px;">{{ $supplier->isActive == 1?
                                trans('message.isActive.active'):trans('message.isActive.inactive') }}</span>
                        </a>
                    </td> --}}
                    <td>
                        <div class="row">
                            <div class="col-sm-4">
                                <a type="button" data-toggle="modal" data-target="#Show{{ $supplier->id }}"><span
                                        class="label label-pill label-success mt-2" style="font-size:11px;"><i
                                            class="fa fa-eye"></i> {{trans('french.View')}}</span>
                                </a>
                            </div>

                            <div class="col-sm-3">
                                <a href="{{ route('supplier.edit',$supplier->id) }}" class="btn btn-primary btn-sm"><i
                                        class="fa fa-edit text-white"></i></a>
                            </div>
                            <div class="col-sm-2">
                                <a href="{{ route('getheader',$supplier->id) }}" class="btn btn-default"><i class="fa fa-heading"></i></a>
                            </div>

                            <div class="modal" id="exampleModal{{$supplier->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <form action="" method="post" enctype="multipart/form-data">
                                @csrf  
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content" style="margin-top:-600px">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Header for {{$supplier->first_name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{$supplier->header}}</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                            <!-- <div class="col-sm-3">
                                    <form action="{{ route('supplier.destroy',$supplier->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash text-white"></i></button>
                                    </form>
                            </div> -->
                        </div>
                    </td>
                </tr>



                {{-- Show Modal --}}
                <div class="modal" id="Show{{ $supplier->id }}" role="dialog" aria-labelledby="exampleModalLongTitle"
                    style="display: none;" aria-hidden="true">
                     
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">{{ $supplier->first_name }} {{
                                    $supplier->last_name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6> {{ trans('french.Address')}}</h6>
                                    </div>
                                    <div class="col-sm-5">
                                        {{ $supplier->address}}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6>  {{ trans('french.Fax Number')}} </h6>
                                    </div>
                                    <div class="col-sm-5">
                                        {{ $supplier->fax_number }}
                                    </div>
                                </div>



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


