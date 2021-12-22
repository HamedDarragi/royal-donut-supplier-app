@extends('admin.layout.app')
<style>
        body {
            padding-top: 4rem;
            font-size: 0.8rem;
            font-family: sans-serif;
            line-height: 1.0;
            margin-bottom: 50px;
            background-color: #cccccc;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3E%3Cg fill='%23dddddd' fill-opacity='0.4'%3E%3Cpath fill-rule='evenodd' d='M0 0h4v4H0V0zm4 4h4v4H4V4z'/%3E%3C/g%3E%3C/svg%3E");
        }

        .table td, .table th {
            padding: .50rem;
            vertical-align: middle;
        }

        .table thead {
            background-image: linear-gradient(#eee, #ddd);
        }

        .card-header {
            padding: .40rem 1.25rem;
            line-height: 250%;
        }

        .warning {
            background: #FAF2CC;
        }

        legend {
            border: 0 none;
            font-size: 14px;
            line-height: 20px;
            margin-bottom: 0;
            width: auto;
            padding: 0 10px;
            font-weight: bold;
        }

        fieldset {
            border: 1px solid #e0e0e0;
            padding: 10px;
        }

        /*==================================================
        * Effect 2
        * ===============================================*/
        .shadow {
            position: relative;
        }

        .shadow:before, .shadow:after {
            z-index: -1;
            position: absolute;
            content: "";
            bottom: 15px;
            left: 10px;
            width: 50%;
            top: 80%;
            max-width: 300px;
            background: #222222;
            -webkit-box-shadow: 0 15px 10px #222222;
            -moz-box-shadow: 0 15px 10px #222222;
            box-shadow: 0 15px 10px #222222;
            -webkit-transform: rotate(-3deg);
            -moz-transform: rotate(-3deg);
            -o-transform: rotate(-3deg);
            -ms-transform: rotate(-3deg);
            transform: rotate(-3deg);
        }

        .shadow:after {
            -webkit-transform: rotate(3deg);
            -moz-transform: rotate(3deg);
            -o-transform: rotate(3deg);
            -ms-transform: rotate(3deg);
            transform: rotate(3deg);
            right: 10px;
            left: auto;
        }

        .stripe {
            color: white;
            background: repeating-linear-gradient(45deg, #007BFF, #007BFF 20%, #3898ff 10px, #3898ff);
            background-size: 100% 20px;
        }

        nav {
            background-image: radial-gradient(#37ba37, #34a334);
        }
    </style>

@section('header')
    <form action="{{route('backupmanager_create')}}" method="post" id="frmNew">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Create New Backup</button>
    </form>
@endsection

@section('content')

    <form id="frm" action="{{route('backupmanager_restore_delete')}}" method="post">
        {!! csrf_field() !!}

        <table class="table" style="font-size: 14px; color: #777777;">
            <thead>
            <tr>
                <th style="text-align: center;" width="1">#</th>
                <th>Name</th>
                <th>Date</th>
                <th>Size</th>
                <th style="text-align: center;">Health</th>
                <th style="text-align: center;">Type</th>
                <th style="text-align: center;">Download</th>
                <th style="text-align: center;" width="1">Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach($backups as $index => $backup)
                <tr>
                    <td style="text-align: center;">{{++$index}}</td>
                    <td>{{$backup['name']}}</td>
                    <td class="date">{{$backup['date']}}</td>
                    <td>{{$backup['size']}}</td>
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
                        <span class="col-sm-8 badge badge-{{$backup['type'] === 'Files' ? 'primary' : 'success'}}">{{$backup['type']}}</span>
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('backupmanager_download', [$backup['name']])  }}">
                            <i class="fa fa-download btn btn-primary"></i>
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <input type="checkbox" name="backups[]" class="chkBackup" value="{{$backup['name']}}">
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <br><br>

        @if (count($backups))
            <input type="hidden" name="type" value="restore" id="type">

            <div class="pull-right" style="margin-right: 15px;">
                <button type="submit" id="btnSubmit" class="btn btn-success" disabled="disabled">
                    <i class="fa fa-refresh"></i>
                    <small><strong>Restore</strong></small>
                </button>
                <button type="submit" id="btnDelete" class="btn btn-danger" disabled="disabled">
                    <i class="fa fa-remove"></i>
                    <small><strong>Delete</strong></small>
                </button>
            </div>
            <div class="clearfix"></div>
        @endif

    </form>

    <div id="overlay">
        <div class="spinner"></div>
        <span class="overlay-message">Working, please wait...</span>
    </div>



<style>
        body {
            padding-top: 4rem;
            font-size: 0.8rem;
            font-family: sans-serif;
            line-height: 1.0;
            margin-bottom: 50px;
            background-color: #cccccc;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3E%3Cg fill='%23dddddd' fill-opacity='0.4'%3E%3Cpath fill-rule='evenodd' d='M0 0h4v4H0V0zm4 4h4v4H4V4z'/%3E%3C/g%3E%3C/svg%3E");
        }

        .table td, .table th {
            padding: .50rem;
            vertical-align: middle;
        }

        .table thead {
            background-image: linear-gradient(#eee, #ddd);
        }

        .card-header {
            padding: .40rem 1.25rem;
            line-height: 250%;
        }

        .warning {
            background: #FAF2CC;
        }

        legend {
            border: 0 none;
            font-size: 14px;
            line-height: 20px;
            margin-bottom: 0;
            width: auto;
            padding: 0 10px;
            font-weight: bold;
        }

        fieldset {
            border: 1px solid #e0e0e0;
            padding: 10px;
        }

        /*==================================================
        * Effect 2
        * ===============================================*/
        .shadow {
            position: relative;
        }

        .shadow:before, .shadow:after {
            z-index: -1;
            position: absolute;
            content: "";
            bottom: 15px;
            left: 10px;
            width: 50%;
            top: 80%;
            max-width: 300px;
            background: #222222;
            -webkit-box-shadow: 0 15px 10px #222222;
            -moz-box-shadow: 0 15px 10px #222222;
            box-shadow: 0 15px 10px #222222;
            -webkit-transform: rotate(-3deg);
            -moz-transform: rotate(-3deg);
            -o-transform: rotate(-3deg);
            -ms-transform: rotate(-3deg);
            transform: rotate(-3deg);
        }

        .shadow:after {
            -webkit-transform: rotate(3deg);
            -moz-transform: rotate(3deg);
            -o-transform: rotate(3deg);
            -ms-transform: rotate(3deg);
            transform: rotate(3deg);
            right: 10px;
            left: auto;
        }

        .stripe {
            color: white;
            background: repeating-linear-gradient(45deg, #007BFF, #007BFF 20%, #3898ff 10px, #3898ff);
            background-size: 100% 20px;
        }

        nav {
            background-image: radial-gradient(#37ba37, #34a334);
        }
    </style>

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
<script
        src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous">
</script>
<script
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous">
</script>
<script
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous">
</script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $('[data-toggle="tooltip"]').tooltip();
</script>

@stack('scripts')

@push('scripts')
    <script>

        $('.table').DataTable({
            "order": [],
            "responsive": true,
            "pageLength": 10,
            "autoWidth": false,
            aoColumnDefs: [
                {
                    bSortable: false,
                    aTargets: [-1]
                }
            ],
            rowGroup: {
                dataSrc: 2
            }
        });

        var $btnSubmit = $('#btnSubmit');
        var $btnDelete = $('#btnDelete');
        var $type = $('#type');
        var type = 'restore';

        $btnSubmit.on('click', function () {
            $type.val('restore');
            type = 'restore';
        });

        $btnDelete.on('click', function () {
            $type.val('delete');
            type = 'delete';
        });

        $(document).on('click', '.chkBackup', function () {
            var checkedCount = $('.chkBackup:checked').length;

            if (checkedCount > 0) {
                $btnSubmit.attr('disabled', false);
                $btnDelete.attr('disabled', false);
            }
            else {
                $btnSubmit.attr('disabled', true);
                $btnDelete.attr('disabled', true);
            }

            if (this.checked) {
                $(this).closest('tr').addClass('warning');
            }
            else {
                $(this).closest('tr').removeClass('warning');
            }
        });

        $('#frm').submit(function () {
            var $this = this;
            var checkedCount = $('.chkBackup:checked').length;
            var $btn = $('#btnSubmit');

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
            }).then(function (response) {
                if (response) {
                    $btn.attr('disabled', true);

                    $this.submit();

                    showOverlay();
                }
            });

            return false;
        });

        $('#frmNew').submit(function () {
            this.submit();

            showOverlay();
        });

        function showOverlay() {
            $('#overlay').show();
        }

        function hideOverlay() {
            $('#overlay').show();
        }

    </script>
@endpush


@endsection