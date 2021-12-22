
<div class="col-sm-4" style="margin-top:20px;"  >
 <form action="{{url('broadcast/search')}}" method="POST" enctype="multipart/form-data">
 @csrf
        <input type="text" id="searchbar" placeholder="Search.." name="search">
        <button type="submit"><i class="fa fa-search"></i></button>
</form>
</div>


<div class="card-header">
    <div class="card-title">{{ $view}}</div>
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
                
                    <th class="wd-15p">Title</th>
                    <th class="wd-10p">Expiry date</th>
                    <th class="wd-10p">Status</th>
                    <th class="wd-10p">Group</th>    
                    <th class="wd-15p">Message</th>
                    <th class="wd-10p">Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($broadcasts as $broadcast)
                <tr>
               
                    <td>{{ $broadcast->title }}</td>
                    <td>{{ $broadcast->expiry_date }}</td>
                    @if($broadcast->isActive == 0)
                    <td>In-Active</td>
                    @else
                    <td>Active</td>
                    @endif

                    <td>
                        <select class="form-control">
                            <option value="">--select--</option>
                            @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        </td>

                    <td>
                        @if($broadcast->isActive == 1)
                        <button id="start_button{{$broadcast->id}}" onclick="sendAnnouncement({{$broadcast->id}})">Start</button>
                        @elseif($broadcast->isActive == 0)
                        <span>Inactive</span>
                        @endif
                        </td>
                    <td>
                      
                                
                    {{-- <td>
                     <a href="{{ route('broadcast.status',$broadcast->id) }}"><span
                                class="label label-pill label-{{ $broadcast->isActive == 1?'success':'danger' }} mt-2">{{ $broadcast->isActive == 1? trans('message.isActive.active'):trans('message.isActive.inactive') }}</span>
                        </a>  
                    </td> --}}
                 
                        <div class="row">
                        <div class="col-sm-3">
                        <a type="button" data-toggle="modal" data-target="#Show{{ $broadcast->id }}"><span
                        class="label label-pill label-success mt-2" style="font-size:11px;"><i class="fa fa-eye"></i> view</span>
                        </a>
                         </div>
                         &emsp;

                           <div class="col-sm-3">
                            <a href="{{ route('broadcast.edit',$broadcast->id) }}" class="btn btn-primary btn-sm"><i
                                class="fa fa-edit text-white"></i></a>
                            </div>
                              <div class="col-sm-3">
                                    <form action="{{ route('broadcast.destroy',$broadcast->id) }}" method="POST" enctype="multipart/form-data"> 
                                        @csrf
                                        @method('DELETE') 
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash text-white"></i></button>
                                    </form>
                                </div>
                        </div>
                                
                    </td>
                </tr>



                {{-- Show Modal --}}
                <div class="modal" id="Show{{ $broadcast->id }}" role="dialog" aria-labelledby="exampleModalLongTitle"
                    style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">{{ $broadcast->title }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-header">
                                        Message
                                    </div>
                                    <div class="card-body">
                                    {!! $broadcast->message !!}
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        File
                                    </div>
                                    <div class="card-body">
                                        <img src="{{ asset('images/Broadcast/'.$broadcast->image) }}" style="height: 80px; width:150px"
                                        alt="">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>

                $('select').on('change', function() {
                    
                    var id = this.value;
                   
                    $.ajax({
                    type:'POST',
                    url: "{{ url('broadcast/groupId') }}",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        id : id
                    },
                     success:function(data) {
                      console.log(data.success);
                     }
                });
                    });


    function sendAnnouncement(id)
    {
        // alert(id);
        document.getElementById("start_button"+id).innerHTML = "Sending...";
            $.ajax({
                type:'GET',
                url: "{{ url('broadcast/status') }}",
                data:{
                   id : id
                },
                success:function(data)
                {
                    console.log(data);
                    if((data =='sent')||(data =='not sent'))
                        document.getElementById("start_button"+id).innerHTML = data;
                    else
                    {
                        alert(data);
                        document.getElementById("start_button"+id).innerHTML = 'start';
                    }

                }
            });

    }
</script>


