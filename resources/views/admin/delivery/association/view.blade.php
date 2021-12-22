@extends('admin.layout.app')

@section('css')
    <link href="{{ asset('admin/assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/plugins/datatable/jquery.dataTables.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <style>
        .card {
            padding: 15px;
        }

    </style>
    <div class="row">
        <div class="col-xl-12">
            <div class="card m-b-20">
                <div class="card-header">
                    <div class="col-md-2">
                        <div class="card-title">Associated Rules</div>
                    </div>
                    <div class="col-md-10">
                        <div class="row pull-right">
                            {{-- <div class="col-md-3 ">
                                <a href="javascript:void(0);" onClick="printPage(printsection.innerHTML)"
                                    class="btn btn-primary text-white"><i class="fa fa-print"></i> Print</a>
                            </div> --}}
                            <div class="col-md-3" style="">
                                <a href="{{ route('associate_rule.create') }}" class="btn btn-primary text-white"
                                    style="margin-right:100px"><i class="fa fa-plus"></i>
                                    Associate Rule</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" width=100%>
                            <thead>
                                <tr>
                                    <td style="font-weight: bold">#</td>
                                    <td style="font-weight: bold">Customer Name</td>
                                    <td style="font-weight: bold">Supplier Name</td>
                                    <td style="font-weight: bold">Rule Name </td>
                                    <td style="font-weight: bold">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($associate) == 0)
                                    <td colspan="5" style="text-align: center">No Data Available</td>
                                @else
                                    @foreach ($associate as $associate_item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ App\Models\User::find($associate_item->customer_id)->first_name }}</td>
                                            <td>{{ App\Models\User::find($associate_item->supplier_id)->first_name }}</td>
                                            <td>{{ App\Models\Rule::find($associate_item->rule_id)->name }}</td>
                                            <td>
                                                <div class="row" style="margin-left: 5px">
                                                    <a href="{{ route('associate_rule.edit', $associate_item->id) }}"><button
                                                            class="btn btn-primary"><i
                                                                class="fa fa-edit"></i></button></a>
                                                    <form
                                                        action="{{ route('associate_rule.destroy', $associate_item->id) }}"
                                                        method="POST">
                                                        @method("DELETE")
                                                        {{ csrf_field() }}
                                                        <button class="btn btn-danger" style="margin-left: 5px"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('script')
    <script src="{{ asset('admin/assets/plugins/datatable/jquery.dataTables.min.js') }}">
    </script>
    <script src="{{ asset('admin/assets/plugins/datatable/dataTables.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('admin/assets/js/datatable.js') }}">
    </script>

@endsection
@endsection
