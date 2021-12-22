@extends('admin.layout.app')

@section('content')
<style>
    .card{
        padding:15px;
    }
</style>
@if($back != null)
<div class="row card" style="margin-top:70px;">
    <div class="card-header">
        <div class="card-title"><h2>Search Results for {{ $back }} Object</h2></div>
    </div>
    
</div>
@endif
<div class="row card" style="margin-top:30px;">
    
    <div class="">
        <div class="card-header">
            <div class="card-title"></div>
            <div class="col-md-8">
                <h2>{{ trans('french.Backlogs') }}</h2>
            </div>
            <div class="col-md-2">
                <i style="color:green" class="fa fa-check-circle"></i>&nbsp;<b>Success</b><br>
                <i style="color:red" class="fa fa-bug"></i>&nbsp;<b>Failure</b>
            </div>
            <div class="col-md-1">
                
                    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-filter"></i></button>
                
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ trans('french.Backlogs')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('filter-backlogs') }}" enctype="multipart/form-data" method="post">
                                @csrf
                                <div class="modal-body">
                                    <input type="radio" name="fil" id="all" value="All"> &nbsp;{{ trans('french.All')}}<br>
                                    <input type="radio" name="fil" id="customer" value="Customer"> &nbsp;{{ trans('french.Filter by')}} {{ trans('french.customer')}}<br>
                                    <input type="radio" name="fil" id="order" value="Order"> &nbsp;{{ trans('french.Filter by')}} {{ trans('french.Order')}}<br>
                                    <input type="radio" name="fil" id="email" value="Email"> &nbsp;{{ trans('french.Filter by')}} {{ trans('french.Email')}}<br>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('french.Close')}}</button>
                                    <button type="submit" class="btn btn-primary">{{ trans('french.Search')}}</button>
                                </div>
                            </form>

                            <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
                                <script>
                                    function all(){
                                        alert('dgdf')
                                    }
                                    if($('#all').is(':checked')){
                                        document.getElementById('customer').disabled = true;
                                        document.getElementById('order').disabled = true;
                                        document.getElementById('email').disabled = true;

                                    }else{
                                        document.getElementById('customer').disabled = false;
                                        document.getElementById('order').disabled = false;
                                        document.getElementById('email').disabled = false;
                                    }
                                </script>
                        </div>
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
                            <th class="wd-25p">#</th>
                            <th class="wd-25p">ID</th>
                            <th class="wd-15p">{{ trans('french.User')}}</th>
                            <th class="wd-15p">{{ trans('french.Object')}}</th>
                            <th class="wd-15p">{{ trans('french.Action')}}</th>
                            <th class="wd-15p">{{ trans('french.Action')}} {{ trans('french.Time')}}</th>
                            <th class="wd-10p">Comments</th>

                            <th class="wd-10p">{{ trans('french.status')}}</th>
                            <!-- <th class="wd-10p">{{ trans('french.Action')}}</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @if($logs != null)
                        @foreach ($logs as $log)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$log->subject_id}}</td>
                            <td>{{ $log->causer_type }}</td>
                            <td>{{ $log->subject_type }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->created_at }}</td>
                            <td id="editable{{ $log->id }}" contenteditable>
                                
                                {!! html_entity_decode($log->comments) !!}
                            </td>
                            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                            <script>
                                var input = document.getElementById("editable"+{{ $log->id }});
                                $(input).focusout(function(){
                                    var value = document.getElementById('editable'+{{ $log->id }}).innerHTML;
                                    value = value.replace('<br>','')
                                    
                                    var id = "{{ $log->id }}";
                                    var _token = "{{ csrf_token() }}";
                                    if(value.length <= 100){
                                        $.ajax({
                                            type: 'post',
                                            url: '{{ url("log/update/index/align") }}',
                                            data: {id:id, _token:_token,index:value},
                                            success : function(data){
                                            if(data == 'done')
                                            location.reload();
                                            
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Comments Length should be less or equal to 100',
                                        })
                                        
                                    }
                                    
                                });
                            </script>
                            @if($log->properties[0] == 1)
                            <td><i style="color:green" class="fa fa-check-circle"></i></td>
                            @elseif($log->properties[0] == 0)
                            <td><i style="color:red" class="fa fa-bug"></i></td>
                            @endif

                            
                        </tr>
                        @endforeach
                        @else
                        
                            <p class="text-center"style="color:red">No Record Found !</p>
                        
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        </div>
</div>
@endsection