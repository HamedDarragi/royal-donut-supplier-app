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
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('french.Rule')}}</div>
                    <div class="col-md-12">
                        <div class="row pull-right">
                            {{-- <div class="col-md-3 ">
                                <a href="javascript:void(0);" onClick="printPage(printsection.innerHTML)"
                                    class="btn btn-primary text-white"><i class="fa fa-print"></i> Print</a>
                            </div> --}}
                            <div class="col-md-3" style="">
                                <a href="{{ route($view . '.create') }}" class="btn btn-primary text-white"
                                    style="margin-right:100px"><i class="fa fa-plus"></i>
                                    {{ trans('french.Rule')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td style="font-weight: bold">#</td>
                                    <td style="font-weight: bold">{{ trans('french.Name')}}</td>
                                    <td style="font-weight: bold">{{ trans('french.Acceptance Time')}}</td>
                                    <td style="font-weight: bold">{{ trans('french.Treatment Day')}}</td>
                                    <td style="font-weight: bold">{{ trans('french.Delivery Days')}} </td>
                                    <td style="font-weight: bold">{{ trans('french.Action')}}</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($rule) == 0)
                                    <td colspan="5" style="text-align: center">No Data Available</td>
                                @else
                                    @foreach ($rule as $rule_item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ substr($rule_item->name, 0, 20) }}</td>
                                            <td>{{ $rule_item->acceptance_time }}</td>
                                            <td>{{ $rule_item->treatment_time }}</td>
                                            <td>{{ $rule_item->delivery_days }}</td>
                                            <td>
                                                <div class="row" style="margin-left: 5px">
                                                    <a href="{{ route('rule.edit', $rule_item->id) }}"><button
                                                            class="btn btn-primary"><i
                                                                class="fa fa-edit"></i></button></a>
                                                    <form action="{{ route('rule.destroy', $rule_item->id) }}"
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
