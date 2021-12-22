
<div class="card-header">
    <div class="card-title">{{ trans('french.Delivery Companies')}}</div>
    <div class="col-md-11">
        <div class="text-right mr-5">
            <a href="{{ route($view.'.create') }}" class="btn btn-primary text-white mr-5"><i class="fa fa-plus"></i>
            {{ trans('french.Delivery Company')}}</a>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        @include('message')
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="wd-15p">#</th>
                    <th class="wd-10p">{{ trans('french.Name')}}</th>
                    <th class="wd-10p">{{ trans('french.Minimum Order Amount')}}</th>
                    <th class="wd-10p">{{ trans('french.Delivery Fee')}}</th>

                    <th class="wd-10p">Action</th>

                </tr>
            </thead>
            <tbody>
                @php $i=1; @endphp
                @foreach ($companies as $company)
                <tr>
                 
                    <td>{{ $i++ }}</td>
                    <td>{{ substr($company->name, 0, 20); }}</td>
                    <td>{{ $company->minimum_order_amount }} €</td>
                    <td>{{ $company->delivery_fee }} €</td>

                 
                        {{-- <td>
                     <a href="{{ route('inventory.status',$inventory->id) }}"><span
                                class="label label-pill label-{{ $inventory->isActive == 1?'success':'danger' }} mt-2">{{ $inventory->isActive == 1? trans('message.isActive.active'):trans('message.isActive.inactive') }}</span>
                        </a>  
                    </td> --}}
                    <td>
                        <div class="row">
                           <div class="col-sm-3">
                            <a href="{{ route('deliverycompany.edit',$company->id) }}" class="btn btn-primary btn-sm"><i
                                class="fa fa-edit text-white"></i></a>
                            </div>
                              <div class="col-sm-3">
                                    <form action="{{ route('deliverycompany.destroy',$company->id) }}" method="POST" enctype="multipart/form-data"> 
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
