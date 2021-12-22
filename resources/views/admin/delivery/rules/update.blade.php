@extends('admin.layout.app')
@section('content')
    
            <div class="card m-b-20">
                <div class="card-header">
                    <h3 class="card-title">{{ trans('french.Update')}} {{ trans('french.Rule')}}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('rule.update', $rule->id) }}" method="POST">
                        @method("PATCH")
                        {{ csrf_field() }}
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    <strong>Danger!</strong> {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> {{ trans('french.Name')}}</label>
                                    <input type="text" name="name" required value="{{ $rule->name }}" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('french.Acceptance Time')}}</label>
                                    <input type="time" name="acceptance" required value="{{ $rule->acceptance_time }}"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('french.Treatment Day')}}</label>
                                    <input type="number" min="1" name="treatment" pattern="^[0-9]+$" required
                                        value="{{ $rule->treatment_time }}" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('french.Delivery Days')}}</label>
                                    <select multiple name="delivery[]" id="delivery" class="form-control select2">
                                        <option value="Monday">Monday
                                        </option>
                                        <option value="Tuesday">
                                            Tuesday
                                        </option>
                                        <option value="Wednesday">
                                            Wednesday
                                        </option>
                                        <option value="Thursday">
                                            Thursday
                                        </option>
                                        <option value="Friday">Friday
                                        </option>
                                        <option value="Saturday">
                                            Saturday
                                        </option>
                                        <option value="Sunday">Sunday
                                        </option>
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
    <script>
        $('#delivery').select2().val({!! json_encode($delivery_days_array) !!}).trigger('change');
        // console.log("LLLL", {!! json_encode($delivery_days_array) !!});
    </script>
@endsection
@endsection
