
<div class="col-sm-4" style="margin-top:20px;"  >
 <form action="{{url('broadcast_group/search')}}" method="POST" enctype="multipart/form-data">
 @csrf
        <input type="text" id="searchbar" placeholder="Search.." name="search">
        <button type="submit"><i class="fa fa-search"></i></button>
</form>
</div>

<div class="card-header">
    <div class="card-title">{{'Group'}}</div>
    <div class="col-md-12">
       
        <div class="row pull-right">
        <div class="col-sm-4 " >
           <a href="{{ route($view.'.create') }}" class="btn btn-primary text-white mr-5"><i class="fa fa-plus"></i>
            Add Group</a>
        </div>
        <div class="col-sm-4 " style="margin-left:10px;">
            <a href="{{ route('addmembers') }}" class="btn btn-primary text-white mr-5"><i class="fa fa-plus"></i>
                Add Members</a>
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
                    <th class="wd-15p">Name</th>
                    <th class="wd-10p">Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($broadcast_groups as $broadcast_group)
                <tr>
                    <td>{{ $broadcast_group->name }}</td>
    
                    
                    {{-- <td>
                      <a href="{{ route('broadcast_group.status',$broadcast_group->id) }}"><span
                                class="label label-pill label-{{ $broadcast_group->isActive == 1?'success':'danger' }} mt-2">{{ $broadcast_group->isActive == 1? trans('message.isActive.active'):trans('message.isActive.inactive') }}</span>
                        </a>   
                    </td>--}}
                    <td>
                        <div class="row">
                           <div class="col-sm-1">
                            <a href="{{ route('broadcast_group.edit',$broadcast_group->id) }}" class="btn btn-primary btn-sm"><i
                                class="fa fa-edit text-white"></i></a>
                            </div>
                              <div class="col-sm-1">
                                    <form action="{{ route('broadcast_group.destroy',$broadcast_group->id) }}" method="POST" enctype="multipart/form-data"> 
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
