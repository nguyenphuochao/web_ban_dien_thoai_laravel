@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (request()->session()->has('success'))
    <div class="alert alert-success">
        {{ request()->session()->pull('success') }}
    </div>
@endif
