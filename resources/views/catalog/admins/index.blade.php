<div class="card-header">
    <div class="card-title">Admins</div>
    <div class="col-md-12">

        <div class="row pull-right">
            
            <div class="col-sm-4 " style="margin-left:10px;">
                <a href="{{ route($view.'.create') }}" class="btn btn-primary text-white mr-5"><i
                        class="fa fa-plus"></i>
                        Admin</a>
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
                    <th>#</th>
                    <th class="wd-15p">{{ trans('french.Name')}}</th>
                    <!-- <th class="wd-10p">Last Name</th> -->
                    <th class="wd-10p">{{ trans('french.Email')}}</th>
                    <th class="wd-10p">Role</th>
                    {{-- <th class="wd-10p">Status</th> --}}
                    <th class="wd-10p">{{ trans('french.Action')}}</th>

                </tr>
            </thead>
            <tbody>
                @php $i=1; @endphp
                @foreach ($admins as $admin)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $admin->first_name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        @if(!empty($admin->getRoleNames()->first()))
                            <label class="badge badge-success">{{ $admin->getRoleNames()->first() }}</label>
                        @else
                        <label class="badge badge-danger">None</label>
                        @endif
                    </td>
                    {{-- <td>
                        <a href="{{ route('admins.status',$admin->id) }}"><span
                                class="label label-pill label-{{ $admin->isActive == 1?'success':'danger' }} mt-2"
                                style="font-size:11px;">{{ $admin->isActive == 1?
                                trans('message.isActive.active'):trans('message.isActive.inactive') }}</span>
                        </a>
                    </td> --}}
                    {{-- <td>
                        <a href="{{ route('admins.status',$admin->id) }}"><span
                                class="label label-pill label-{{ $admin->isActive == 1?'success':'danger' }} mt-2">{{
                                $admin->isActive == 1?
                                trans('message.isActive.active'):trans('message.isActive.inactive') }}</span>
                        </a>
                    </td> --}}
                    <td>
                        <div class="row">
                            <div class="col-sm-3">
                                <a type="button" data-toggle="modal" data-target="#Show{{ $admin->id }}"><span
                                        class="label label-pill label-success mt-2"><i class="fa fa-eye"></i>
                                        {{trans('french.View')}}</span>
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <a href="{{ route('admins.edit',$admin->id) }}" class="btn btn-primary btn-sm"><i
                                        class="fa fa-edit text-white"></i></a>
                            </div>
                            <div class="col-sm-2">
                                <form action="{{ route('admins.destroy',$admin->id) }}" method="POST"
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
                <div class="modal" id="Show{{ $admin->id }}" role="dialog" aria-labelledby="exampleModalLongTitle"
                    style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">{{ $admin->first_name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-header">
                                    {{ trans('french.Mobile Number')}}
                                    </div>
                                    <div class="card-body">
                                        {{ $admin->mobilenumber }}
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header"> {{ trans('french.Address')}}</div>
                                    <div class="card-body">


                                        {{ $admin->address }}
                                    </div>
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
<div id="printsection" style="display:none">
    @if(count($admins) == 0)
    <p>No admin registered yet</p>
    @else
    <div class="table-responsive">
        @include('message')
        <table id="example" class="table table-striped table-bordered" style="width: 100%">
            <thead>
                <tr>
                    <td style="font-weight: bold" class="wd-25p">First Name</td>
                    <td style="font-weight: bold" class="wd-15p">Last Name </td>
                    <td style="font-weight: bold" class="wd-15p">Email</td>
                    <td style="font-weight: bold" class="wd-15p">Mobile Number</td>
                    <td style="font-weight: bold" class="wd-15p">Address</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                <tr>
                    <td>{{ $admin->first_name }}</td>
                    <td>{{ $admin->last_name}}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->mobilenumber}}</td>
                    <td>{{ $admin->address}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

<script>
    console.log(printsection.innerHTML)
    function printPage(printContent) {
    var display_setting="toolbar=yes,menubar=yes,";
    display_setting+="scrollbars=yes,width=1000, height=1000, left=100, top=25";
    var printpage=window.open("","",display_setting);
    printpage.document.open();
    printpage.document.write('<html><head><title>Print Page</title></head><body onLoad="self.print()" align="center">'+ printContent +'</body>');
    printpage.document.close();
    printpage.focus();
}
</script>
