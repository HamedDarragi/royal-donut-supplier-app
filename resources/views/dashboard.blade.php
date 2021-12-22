@extends('admin.layout.app')
@section('content')

<div class="card" style="height: 100%">
    @role('Admin')
    <div class="h2 p-5">Admin</div>
    @endrole
    @role('Customer')
    <div class="h2 p-5">Customer</div>
    @endrole
    @role('Supplier')
    <div class="h2 p-5">Supplier</div>
    @endrole
    @role('Manufacturer')
    <div class="h2 p-5">Manufacturer</div>
    @endrole
</div>
@endsection
