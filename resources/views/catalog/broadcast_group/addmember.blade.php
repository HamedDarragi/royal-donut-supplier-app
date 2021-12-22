@extends('admin.layout.app')
@section('css')
<!-- file Uploads -->
<link href="{{asset('admin/assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
<!-- select2 Plugin -->
<link href="{{asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<style>
  .checked {
  color: orange;
}
.selected_user:hover
{
    background-color: #e2e1e1;
}
.selected_user:active
{
    background-color: #e2e1e1;
}
div#loggedInUserMessage {
    /* position: absolute; */
    /* bottom: 0px; */
    max-height: 445px;
    min-height: 445px;
    overflow: auto;
}
.users_list{
    max-height: 445px;
    min-height: 445px;
    overflow: auto;
}

</style>
@endsection
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <div class="row">
       <div class="col-xl-12">
           <div class="card m-b-20">
                <div class="card-header">
                    <h3 class="card-title">customer</h3>
                </div>
          
                    <div class="card-body">
       
                            <form action="{{route('addmembers.store')}}" method="POST">
                                            @csrf
                                <div class="col-md-12">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <div class="msg_history"  id="loggedInUserMessage">
                                                <h3>Add User</h3>



                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="role_id">Role: </label>
                                                        <select id="role_id" class="form-control js-example-basic-single" required name="role_id" onchange="getUsers()">
                                                            <option value="">Select Role</option>
                                                       
                                                                <option   value="customer">Customer</option>
                                                        
                                                        </select>
                                                    </div>



                                                    <div class="col-md-3">
                                                        <label for="group_id">Group: </label>
                                                        <select id="group_id" class="form-control" name="group_id" required>
                                                            <option value="">Select Group</option>
                                                         @foreach($groups as $group)
                                                                <option  value="{{$group->id}}">{{$group->name}}</option>
                                                        @endforeach 
                                                        </select>

                                                        <script>
                                                            $('#group_id').on('change',function(){
                                                                var id =  this.value;
                                                                // alert(id);

                                                            $.ajax({
                                                                            type:'POST',
                                                                            url: "{{ url('admins/announcement/getGroupId') }}",
                                                                            data:{
                                                                                "_token": "{{ csrf_token() }}",
                                                                                id : id
                                                                            },
                                                                            success:function(data) {
                                                                            console.log(data.success);
                                                                            }
                                                                        });
                                                            });
                                                        </script>
                                                    </div>
                                                </div >
                                                <p id="users"></p>
                                                <div style="float: left;">
                                                    <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-plus-circle"></i> Add User</button> </a>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            </form>

        
                    </div> 
                
            </div> 
        </div> 
    </div> 
    
    
    <script>


        function getUsers()  //
        {
                  var role_id=$("#role_id").val();
                //   alert(role_id);
            $.ajax({
                    type:'GET',
                    url: "{{url('users')}}",
                    data:{
                       role_id : role_id
                    },
                    success:function(data) {
                        console.log(data);
                    document.getElementById("users").innerHTML = '' ;
                    data.forEach(function(value) 
                    {
                       $("#users").append(' <input type="checkbox" id="username" name="username[]" value="'+value.id+'"><label for="username"> &nbsp; &nbsp; ' + value.first_name  +  '</label><br>');
                    });

                    }
                });

        }

</script>

@endsection

