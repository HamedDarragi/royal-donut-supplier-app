<div class="col-sm-4" style="margin-top:20px;"  >
 <form action="{{url('inventory/search')}}" method="POST" enctype="multipart/form-data">
 @csrf
        <input type="text" id="searchbar" placeholder="Search.." name="search">
        <button type="submit"><i class="fa fa-search"></i></button>
</form>
</div>
<div class="card-header">
    <div class="card-title">Inventories</div>
    <div class="col-md-12">
        <div class="text-right mr-5">
            <a href="{{ route($view.'.create') }}" class="btn btn-primary text-white mr-5"><i class="fa fa-plus"></i>
                {{ $view }}</a>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        @include('message')
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="wd-15p">Product Name</th>
                    <th class="wd-10p">Quantity</th>
                    <th class="wd-10p">Unit</th>
                    <th class="wd-10p">Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($inventories as $inventory)
                <tr>
                 
                    <td>{{ $inventory->product->name}}</td>
                    <td>{{ $inventory->quantity }}</td>
                    <td>{{$inventory->unit->name }}</td>
                 
                        {{-- <td>
                     <a href="{{ route('inventory.status',$inventory->id) }}"><span
                                class="label label-pill label-{{ $inventory->isActive == 1?'success':'danger' }} mt-2">{{ $inventory->isActive == 1? trans('message.isActive.active'):trans('message.isActive.inactive') }}</span>
                        </a>  
                    </td> --}}
                    <td>
                        <div class="row">
                           <div class="col-sm-3">
                            <a href="{{ route('inventory.edit',$inventory->id) }}" class="btn btn-primary btn-sm"><i
                                class="fa fa-edit text-white"></i></a>
                            </div>
                              <div class="col-sm-3">
                                    <form action="{{ route('inventory.destroy',$inventory->id) }}" method="POST" enctype="multipart/form-data"> 
                                        @csrf
                                        @method('DELETE') 
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash text-white"></i></button>
                                    </form>
                                </div>
                        </div>
                                
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
