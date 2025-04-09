@php
    $currentRouteName = Route::currentRouteName();
@endphp

<div class="mt-2">
    <a href="#" class="btn btn-primary {{ $currentRouteName == 'dashboard.index' ? 'active' : '' }}">Dashboard</a>
    <a href="{{ route('categories.index') }}"
        class="btn btn-primary {{ $currentRouteName == 'categories.index' ? 'active' : '' }}">Category</a>
    <a href="{{ route('products.index') }}" class="btn btn-primary {{ $currentRouteName == 'products.index' ? 'active' : '' }}">Product</a>
</div>


<div class="d-flex justify-content-end align-items-center mt-4">
    <div class="user">
        Hello : <span class="fw-bold" style="margin-right: 10px">{{ Auth::user()->name }}</span>
    </div>

    <div class="dropdown">

        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
            data-bs-toggle="dropdown" aria-expanded="false">
            Logout
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <li>
                <a class="dropdown-item" href="#"
                    onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                    <form id="logoutForm" method="POST" action="{{ route('logout') }}">@csrf Exit</form>
                </a>
            </li>
        </ul>
    </div>
</div>
