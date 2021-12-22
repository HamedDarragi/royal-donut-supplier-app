<!-- <div class="col-sm-4" style="margin-top:20px;"  >
 <form action="{{url('manufacturer/search')}}" method="POST" enctype="multipart/form-data">
 @csrf
        <input type="text" id="searchbar" placeholder="Search.." name="search">
        <button type="submit"><i class="fa fa-search"></i></button>
</form>
</div> -->


<div class="card-header">
    <div class="card-title">Manufacturers</div>
    <div class="col-md-11">
        <div class="text-right mr-5">
            <a href="{{ route($view.'.create') }}" class="btn btn-primary text-white mr-5"><i class="fa fa-plus"></i>
                Manufacturing partner</a>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        @include('message')
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="wd-15p">First Name</th>
                    <th class="wd-10p">Last Name</th>
                    <th class="wd-10p">Email</th>
                    <th class="wd-10p">Products</th>
                    {{-- <th class="wd-10p">Status</th> --}}
                    <th class="wd-10p">Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($manufacturing_partners as $manufacturing_partner)
                <tr>
                    <td>{{ $manufacturing_partner->first_name }}</td>
                    <td>{{ $manufacturing_partner->last_name }}</td>
                    <td>{{ $manufacturing_partner->email }}</td>
                    @php
                    $products=App\Models\Product::where('manufacturing_partner_id',
                    $manufacturing_partner->id)->pluck('name');
                    $all_products=$products->implode(', ');
                    @endphp
                    <td class="col-sm-2">
                        {{$all_products}}
                    </td>
                    {{-- <td>
                        <a href="{{ route('manufacturing_partner.status',$manufacturing_partner->id) }}"><span
                                class="label label-pill label-{{ $manufacturing_partner->isActive == 1?'success':'danger' }} mt-2"
                                style="font-size:11px;">{{ $manufacturing_partner->isActive == 1?
                                trans('message.isActive.active'):trans('message.isActive.inactive') }}</span>
                        </a>
                    </td> --}}


                    {{-- <td>
                        <a href="{{ route('manufacturing_partner.status',$manufacturing_partner->id) }}"><span
                                class="label label-pill label-{{ $manufacturing_partner->isActive == 1?'success':'danger' }} mt-2">{{
                                $manufacturing_partner->isActive == 1?
                                trans('message.isActive.active'):trans('message.isActive.inactive') }}</span>
                        </a>
                    </td> --}}
                    <td>
                        <div class="row">
                            <div class="col-sm-3">
                                <a type="button" data-toggle="modal"
                                    data-target="#Show{{ $manufacturing_partner->id }}"><span
                                        class="label label-pill label-success mt-2" style="font-size:11px;"><i
                                            class="fa fa-eye"></i> view</span>
                                </a>
                            </div>

                            <div class="col-sm-2">
                                <a href="{{ route('manufacturing_partner.edit',$manufacturing_partner->id) }}"
                                    class="btn btn-primary btn-sm"><i class="fa fa-edit text-white"></i></a>
                            </div>
                            <div class="col-sm-2">
                                <form action="{{ route('manufacturing_partner.destroy',$manufacturing_partner->id) }}"
                                    method="POST" enctype="multipart/form-data">
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
                <div class="modal" id="Show{{ $manufacturing_partner->id }}" role="dialog"
                    aria-labelledby="exampleModalLongTitle" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLongTitle">{{ $manufacturing_partner->first_name
                                    }}</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="card">
                                    <div class="card-header">
                                        Detail
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <h6>Mobile Number</h6>
                                            </div>
                                            <div class="col-sm-5">
                                                {{ $manufacturing_partner->mobilenumber }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <h6> Company</h6>
                                            </div>
                                            <div class="col-sm-5">
                                                {{ $manufacturing_partner->company }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <h6> Address</h6>
                                            </div>
                                            <div class="col-sm-5">
                                                {{ $manufacturing_partner->address }}
                                            </div>
                                        </div>


                                    </div>
                                </div>


                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
