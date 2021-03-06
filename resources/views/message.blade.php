@if(session()->has('status'))
<div class="alert alert-success">
    {{ session()->get('status') }}
</div>
@endif
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li class="alert alert-danger">
            {{ $error }}
        </li>
        @endforeach
    </ul>
</div>
@endif
