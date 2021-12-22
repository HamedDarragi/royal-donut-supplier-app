<!--
<div class="col-sm-4" style="margin-top:20px;"  >
 <form action="{{url('unit/search')}}" method="POST" enctype="multipart/form-data">
 @csrf
        <input type="text" id="searchbar" placeholder="Search.." name="search">
        <button type="submit"><i class="fa fa-search"></i></button>
</form>
</div> -->



<div class="card-header">
    <div class="card-title">{{ trans('french.Units')}}</div>
    <div class="col-md-12">
        <div class="text-right mr-5">
            <a href="{{ route($view.'.create') }}" class="btn btn-primary text-white mr-5"><i class="fa fa-plus"></i>
            {{ trans('french.unit')}}</a>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        @include('message')
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="wd-15p">{{ trans('french.Name')}}</th>
                    {{-- <th class="wd-10p">Symbol</th> --}}
                    <th class="wd-10p">{{ trans('french.Abbreviation')}}</th>
                    {{-- <th class="wd-10p">Status</th> --}}
                    <th class="wd-10p">{{ trans('french.Action')}}</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($units as $unit)
                <tr>
                    <td>{{ $unit->name }}</td>
                    {{-- @isset($unit->symbol)
                    <td>{{ $unit->symbol }}</td>
                    @else
                    <td> -- </td>
                    @endif --}}

                    @isset($unit->abbreviation)
                    <td>{{ $unit->abbreviation }}</td>
                    @else
                    <td> -- </td>
                    @endif

                    {{-- <td>
                        <a href="{{ route('unit.status',$unit->id) }}"><span
                                class="label label-pill label-{{ $unit->isActive == 1?'success':'danger' }} mt-2"
                                style="font-size:11px;">{{ $unit->isActive == 1?
                                trans('message.isActive.active'):trans('message.isActive.inactive') }}</span>
                        </a>
                    </td> --}}
                    <td>
                        <div class="row">
                            <div class="col-sm-3">
                                <a href="{{ route('unit.edit',$unit->id) }}" class="btn btn-primary btn-sm"><i
                                        class="fa fa-edit text-white"></i></a>
                            </div>
                            @if(!in_array($unit->id,$un_arr))
                            <div class="col-sm-2">
                                <form action="{{ route('unit.destroy',$unit->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="fa fa-trash text-white"></i></button>
                                </form>
                            </div>
                            @endif
                        </div>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
