<div class="card-header">
    <div class="card-title">{{ trans('french.Categories')}}</div>
    <div class="col-md-12">
        <div class="text-right mr-5">
            <a href="{{ route($view.'.create') }}" class="btn btn-primary text-white mr-6"><i class="fa fa-plus"></i>
            {{ trans('french.category')}}</a>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        @include('message')
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="wd-25p">{{ trans('french.Image')}}</th>
                    <th class="wd-15p">{{ trans('french.Name')}}</th>
                    {{-- <th class="wd-10p">Status</th> --}}
                    <th class="wd-10p">{{ trans('french.Action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td><img src="{{ asset('images/Category/'.$category->image) }}" style="height: 80px; width:150px"
                            alt="">
                    </td>
                    <td>{{ $category->name }}</td>
                    {{-- <td>
                        <a href="{{ route('category.status',$category->id) }}"><span
                                class="label label-pill label-{{ $category->isActive == 1?'success':'danger' }} mt-2"
                                style="font-size:11px;">{{ $category->isActive == 1?
                                trans('message.isActive.active'):trans('message.isActive.inactive') }}</span>
                        </a>
                    </td> --}}
                    <td>
                        <div class="row">
                            <div class="col-sm-2">
                                <a href="{{ route('category.edit',$category->id) }}" class="btn btn-primary btn-sm"><i
                                        class="fa fa-edit text-white"></i></a>
                            </div>
                            <div class="col-sm-2">
                                <form action="{{ route('category.destroy',$category->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="fa fa-trash text-white"></i></button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
