@if(session()->has('success'))
<div style="margin-top: 10px" class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif
@if(session()->has('danger'))
<div style="margin-top: 10px;" class="alert alert-danger">
    {{ session()->get('danger') }}
</div>
@endif
<div class="page-header">
    <h4 class="page-title">Category</h4>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Category</li>
    </ol>
</div>
