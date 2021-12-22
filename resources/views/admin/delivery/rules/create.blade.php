@extends('admin.layout.app')
@section('content')
            <div class="card m-b-20">
                <div class="card-header">
                    <h3 class="card-title">{{ trans('french.Rule')}}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('rule.store') }}" method="POST">
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
                                    <label>{{ trans('french.Name')}}</label>
                                    <input type="text" name="name" required class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('french.Acceptance Time')}}</label>
                                    <input type="time" name="acceptance" required class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('french.Treatment Day')}}</label>
                                    <input type="number" name="treatment" pattern="^[0-9]+$" min="1" required class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('french.Delivery Days')}}</label>
                                    <select multiple name="delivery[]" class="form-control select2">
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                        <option value="Sunday">Sunday</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p class="text-center">
                                    <button type="submit" class="btn btn-primary">{{ trans('french.Save')}}</button>
                                </p>
                                 
                            </div>
                            
                            
                        </div>
                        
                        
                        
                    </form>
                </div>
            </div>
@section('script')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection
@endsection
