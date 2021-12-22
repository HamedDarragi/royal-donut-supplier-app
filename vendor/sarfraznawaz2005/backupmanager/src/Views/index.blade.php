@extends('backupmanager::layout.layout')

@section('title', $title)
<style>
    tr.group.group-start {
        display: none;
    }
    .ellipsis {
    position: relative;
    }
    .ellipsis:before {
        content: '&nbsp;';
        visibility: hidden;
    }
    .ellipsis span {
        position: absolute;
        left: 0;
        right: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

</style>
@section('header')
    <button type="button" class="btn btn-sm" style="background:white;" data-toggle="modal" data-target="#myModal">
        <i class="fa fa-plus"></i> Create New Backup
    </button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <form action="{{ route('backupmanager_create') }}" method="post" id="frmNew">
                {{ csrf_field() }}
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Database Information</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <label>Database Name</label>
                        <input type="text" name="db_name" class="form-control" placeholder="Enter Database Name" id="db_name" maxLength="50">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="modal_submit" class="btn btn-success">Ok</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <a href="{{ route('product.index') }}" class="btn btn-sm" style="background:white;"><i
            class="fa fa-arrow-left"></i> Back to Admin</a>

@endsection

@section('content')

    <form id="frm" action="{{ route('backupmanager_restore_delete') }}" method="post"> 
        {!! csrf_field() !!}
        <table class="table" style="font-size: 14px; color: #777777;">
            <thead>
                <tr>
                    <th style="text-align: center;" width="1">#</th>
                    <th>Name</th>
                    <!-- <th>Date</th> -->
                    <th>Size</th>
                    <th style="text-align: center;">Health</th>
                    <th style="text-align: center;">Type</th>
                    <th style="text-align: center;">Download</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;" width="1">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($backups as $index => $backup)
                    <tr>
                        <?php $db_name = App\Models\DatabaseInformation::where('database_storage_name', $backup['name'])->first(); ?>
                        <td style="text-align: center;">{{ ++$index }}</td>
                        {{-- <td>{{ $backup['name'] }}</td> --}}
                        @if ($db_name != null)
                            <td style=" @if ($db_name->status == 1) font-weight:bold; @endif" class="ellipsis"><span>{{ $db_name->name }}</span></td>
                        @else
                            <td class="ellipsis"><span>{{ $backup['name'] }}</span></td>
                        @endif
                        <!-- <td class="date">{{ $backup['date'] }}</td> -->
                        <td>{{ $backup['size'] }}</td>
                        <td style="text-align: center;">
                            <?php
                            $okSizeBytes = 1024;
                            $isOk = $backup['size_raw'] >= $okSizeBytes;
                            $text = $isOk ? 'Good' : 'Bad';
                            $icon = $isOk ? 'success' : 'danger';

                            echo "<span class='col-sm-8 badge badge-$icon'>$text</span>";
                            ?>
                        </td>
                        <td style="text-align: center;">
                            <span
                                class="col-sm-8 badge badge-success ">Database</span>
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('backupmanager_download', [$backup['name']]) }}">
                                <i class="fa fa-download btn btn-primary"></i>
                            </a>
                        </td>
                        <td style="text-align:center;">
                            @if ($db_name != null)
                                @if ($db_name->status == 1)
                                    <span class="badge badge-success" >Active</span>
                                @endif
                            @else
                                <span class="badge badge-danger" >Not Active</span>
                            @endif

                        </td>
                        <td style="text-align: center;width:10%">
                            <input type="radio" name="backups" class="chkBackup" value="{{ $backup['name'] }}"
                                style="float: left">
                                
        </form>
                            <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal_edit_{{ preg_split('/[^\w]/',explode('.',$backup['name'])[0])[0] }}">
                                <i class="fa fa-edit text-white"></i></a>
                            <!-- Modal -->
                            <div class="modal fade" id="myModal_edit_{{ preg_split('/[^\w]/',explode('.',$backup['name'])[0])[0] }}" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                            <div class="modal-content">
                                                <form action="{{route('database_updation')}}" method="POST" id="edit_form{{ explode('.',$backup['name'])[0] }}">
                                                {{ csrf_field() }}
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Database Edit</h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" class="form-control"
                                                            name="db_name"
                                                            placeholder="Enter Database Name"
                                                            value="{{ $backup['name'] }}"
                                                            id="db_name_{{ explode('.',$backup['name'])[0] }}">
                                                        <label>Database Name</label>
                                                        <input type="text" class="form-control" name="db_name_edit"
                                                            placeholder="Enter Database Name"
                                                            maxLength="50" value="{{ explode('.',$backup['name'])[0] }}"
                                                            id="db_name_edit_{{ explode('.',$backup['name'])[0] }}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" id="modal_edit"
                                                            class="btn btn-success" formaction="{{route('database_updation')}}">Ok</button>
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                    
                                                </form>
                                            </div>

                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <br><br>

        @if (count($backups))
            <input type="hidden" name="type" value="restore" id="type">
            <!-- <a href="" class="btn btn-danger" disabled="disabled">
                                                                                                                                                                                                                                                                                                                                                    <i class="fa fa-remove"></i>
                                                                                                                                                                                                                                                                                                                                                    <small><strong>Delete</strong></small>
                                                                                                                                                                                                                                                                                                                                            </a> -->
            <div class="pull-right" style="margin-right: 15px;">
                {{-- <a href="{{ route('reset_data') }}" class="btn btn-danger">
                    <i class="fa fa-remove"></i>
                    <small><strong>Reset</strong></small>
                </a> --}}
                <button type="button" id="btnReset" class="btn btn-danger">
                    <i class="fa fa-remove"></i>
                    <small><strong>Reset</strong></small>
                </button>
                <button type="submit" id="btnSubmit" class="btn btn-success" disabled="disabled" form="frm" formaction="{{ route('backupmanager_restore_delete') }}" >
                    <i class="fa fa-refresh"></i>
                    <small><strong>Restore</strong></small>
                </button>
                <button type="submit" id="btnDelete" class="btn btn-danger" disabled="disabled" form="frm" formaction="{{ route('backupmanager_restore_delete') }}" >
                    <i class="fa fa-remove"></i>
                    <small><strong>Delete</strong></small>
                </button>
            </div>
            <div class="clearfix"></div>
        @endif

    <!--</form>-->

    <div id="overlay">
        <div class="spinner"></div>
        <span class="overlay-message">Working, please wait...</span>
    </div>


@endsection

@push('styles')
    <style>
        #overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 9999999999;
        }

        #overlay .overlay-message {
            position: fixed;
            left: 50%;
            top: 57%;
            height: 100px;
            width: 250px;
            margin-left: -120px;
            margin-top: -50px;
            color: #fff;
            font-size: 20px;
            text-align: center;
            font-weight: bold;
        }

        .spinner {
            position: fixed;
            left: 50%;
            top: 40%;
            height: 80px;
            width: 80px;
            margin-left: -40px;
            margin-top: -40px;
            -webkit-animation: rotation .9s infinite linear;
            -moz-animation: rotation .9s infinite linear;
            -o-animation: rotation .9s infinite linear;
            animation: rotation .9s infinite linear;
            border: 6px solid rgba(255, 255, 255, .15);
            border-top-color: rgba(255, 255, 255, .8);
            border-radius: 100%;
        }

        @-webkit-keyframes rotation {
            from {
                -webkit-transform: rotate(0deg);
            }

            to {
                -webkit-transform: rotate(359deg);
            }
        }

        @-moz-keyframes rotation {
            from {
                -moz-transform: rotate(0deg);
            }

            to {
                -moz-transform: rotate(359deg);
            }
        }

        @-o-keyframes rotation {
            from {
                -o-transform: rotate(0deg);
            }

            to {
                -o-transform: rotate(359deg);
            }
        }

        @keyframes rotation {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(359deg);
            }
        }

        table.dataTable tr.group td {
            background-image: radial-gradient(#fff, #eee);
            border: none;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }

    </style>
@endpush

@push('scripts')
    <script>
        $('.table').DataTable({
            "order": [],
            "responsive": true,
            "pageLength": 10,
            "autoWidth": false,
            aoColumnDefs: [{
                bSortable: false,
                aTargets: [-1]
            }],
            rowGroup: {
                dataSrc: 2
            }
        });

        var $btnSubmit = $('#btnSubmit');
        var $btnDelete = $('#btnDelete');
        var $btnReset = $('#btnReset');
        var $type = $('#type');
        var type = 'restore';

        $btnSubmit.on('click', function() {
            $type.val('restore');
            type = 'restore';
        });

        $btnReset.on('click', function() {
            $type.val('reset');
            type = "reset";
        });

        $btnDelete.on('click', function() {
            $type.val('delete');
            type = 'delete';
        });

        $(document).on('click', '.chkBackup', function() {
            var checkedCount = $('.chkBackup:checked').length;

            if (checkedCount > 0) {
                $btnSubmit.attr('disabled', false);
                $btnDelete.attr('disabled', false);
            } else {
                $btnSubmit.attr('disabled', true);
                $btnDelete.attr('disabled', true);
            }

            if (this.checked) {
                $(this).closest('tr').addClass('warning');
            } else {
                $(this).closest('tr').removeClass('warning');
            }
        });

        $('#frm').submit(function() {
            var $this = this;
            var checkedCount = $('.chkBackup:checked').length;
            var $btn = $('#btnSubmit');

            console.log("TYPEEEEEEE", type);

            if (!checkedCount) {
                swal("Please select backup(s) first!");
                return false;
            }

            if (checkedCount > 2 && type === 'restore') {
                swal("Please select one or two backups max.");
                return false;
            }

            var msg = 'Continue with restoration process ?';

            if (type === 'delete') {
                msg = 'Are you sure you want to delete selected backups ?';
            }




            swal({
                title: "Confirm",
                text: msg,
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then(function(response) {
                if (response) {
                    $btn.attr('disabled', true);

                    $this.submit();

                    showOverlay();
                }
            });

            return false;
        });

        $btnReset.on('click', function() {

            console.log("RESETTTTT", type);
            var msg = "Are you sure you want to reset database ?";
            swal({
                title: "Confirm",
                text: msg,
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then(function(response) {
                if (response) {
                    window.location.href = "{{ route('reset_data') }}";
                    showOverlay();
                }
            });
        });
        
        $('#modal_edit').on('click',function(){
            console.log("CLICKED",$(this).attr('class'));
            // console.log("DB_NAME",$('#db_name').val());
            
            // console.log("EDIT_DB_NAME",$('#db_name_edit').val());
            // $.ajax({
                
            //     type:"POST",
            //     url:"{{route('database_updation')}}",
            //     data:{
            //         "_token":"{{csrf_token()}}",
                    
            //     }
            // })
        });

        // $('#frmNew').submit(function() {
        //     this.submit();

        //     showOverlay();
        // });

        // $('#modal_submit').on('click', function() {
        //     var input_value = $('#db_name').val();
        //     $.ajax({
        //         url: "{{ route('backupmanager_create') }}",
        //         type: "POST",
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //             database_name: input_value
        //         },
        //         success: function() {}
        //     });
        // });


        function showOverlay() {
            $('#overlay').show();
        }

        function hideOverlay() {
            $('#overlay').show();
        }
    </script>
@endpush
