@extends('admin.layout.app')
@section('content')

            <div class="card m-b-20">
                <div class="card-header">
                    <h3 class="card-title">{{ trans('french.Update')}} {{ trans('french.Associate Rule')}}</h3>
                </div>
                <div class="card-body">
                    @if (session()->has('danger'))
                        <div class="alert alert-danger">
                            <strong>Danger!</strong> {{ session()->get('danger') }}
                        </div>
                    @endif
                    <form action="{{ route('associate_rule.update', $associate->id) }}" method="POST">
                        @method("PATCH")
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('french.Customer Name')}}</label>
                                    <select name="customer" class="form-control">
                                        <option disabled selected>Select Customer</option>
                                        @foreach ($customer as $customer_item)
                                            <option value={{ $customer_item->id }}
                                                {{ $customer_item->id == $associate->customer_id ? 'selected' : '' }}>
                                                {{ $customer_item->first_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('french.Supplier Name')}}</label>
                                    <select name="supplier" class="form-control">
                                        <option disabled selected>Select Supplier</option>
                                        @foreach ($supplier as $supplier_item)
                                            <option value={{ $supplier_item->id }}
                                                {{ $supplier_item->id == $associate->supplier_id ? 'selected' : '' }}>
                                                {{ $supplier_item->first_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('french.Rule Name')}}</label>
                                    <select name="rule" class="form-control">
                                        <option disabled selected>Select Rule</option>
                                        @foreach ($rule as $rule_item)
                                            <option value={{ $rule_item->id }}
                                                {{ $rule_item->id == $associate->rule_id ? 'selected' : '' }}>
                                                {{ substr($rule_item->name ,0,20)}} Where Acceptance Time
                                                {{ $rule_item->acceptance_time }} And Delivery Days are
                                                {{ $rule_item->delivery_days }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <button type="submit" class="btn btn-primary">{{ trans('french.Update')}}</button>
                                </center>
                            </div>
                        </div>
                        
                        
                        
                       
                    </form>
                </div>
            </div>
@section('script')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection
@endsection
