@extends('admin.layout.app')

@section('content')
<style>
    .card{
        padding:15px;
    }
</style>
<div class="row card" style="margin-top:70px;">
    <h2>{{ trans('french.Email History') }}</h2>
    <div class="col-xl-12 ">
        <div id="printsection">
            @if(count($emails) == 0)
            <p>No history added in yet</p>
            @else
            <div class="table-responsive">
                @include('message')
                <table id="example" class="table table-striped table-bordered" width=100%>
                    <thead>
                        <tr>
                            <td style="font-weight: bold">#</td>
                            <td style="font-weight: bold">{{ trans('french.Order') }}#</td>
                            <td style="font-weight: bold">{{ trans('french.Supplier') }}</td>
                            <td style="font-weight: bold">{{ trans('french.Subject') }} </td>
                            <td style="font-weight: bold">{{ trans('french.Message') }} </td>
                            <td style="font-weight: bold">{{ trans('french.Date') }}</td>
                            <td style="font-weight: bold">{{ trans('french.status') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @foreach ($emails as $email)
                        @php
                        $o_num = explode('-',$email->order_number);
                        $supplier = App\Models\User::where('abbrivation',$o_num[1])->first();
                        @endphp
                        <tr>
                            <td>
                                {{$i++}}
                            </td>
                            <td>
                                {{ $email->order_number }}
                            </td>
                            <td>
                                {{$supplier->first_name}}
                            </td>
                            <td>{!! html_entity_decode($email->subject) !!}</td>
                            <td>{{ $email->message }}</td>
                            <td>{{ $email->created_at }}</td>
                            <td>
                                @if($email->status == 1)
                                <span class="badge badge-success">Success</span>
                                @elseif($email->status == 0)
                                <span class="badge badge-danger">Failed</span>
                                @endif
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{$emails->links()}}
            @endif
        </div>
    </div>
</div>
@endsection