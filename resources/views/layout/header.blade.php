@php
    $currentRouteName = Route::currentRouteName();
@endphp

<div class="container mt-2">
    <a href="#" class="btn btn-primary {{ $currentRouteName == 'dashboard.index' ? 'active' : ''}}">Dashboard</a>
    <a href="{{ route('categories.index') }}" class="btn btn-primary {{ $currentRouteName == 'categories.index' ? 'active' : ''}}">Category</a>
    <a href="#" class="btn btn-primary {{ $currentRouteName == 'products.index' ? 'active' : ''}}">Product</a>
</div>
