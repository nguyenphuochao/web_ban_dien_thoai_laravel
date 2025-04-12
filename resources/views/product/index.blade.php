@extends('layout.app')

@section('title', 'Category')

@push('styles')
    <style>
        table thead th {
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="mt-2">
        <h1>Product</h1>

        <button class="btn btn-primary">Add</button>
        <br>
        @php
            $s_product_name = request()->has('s_product_name') ? request()->input('s_product_name') : null;
            $s_category_id = request()->has('s_category_id') ? request()->input('s_category_id') : null;
            $s_from_price = request()->has('s_from_price') ? request()->input('s_from_price') : null;
            $s_to_price = request()->has('s_to_price') ? request()->input('s_to_price') : null;

            $checked = false;
            if ($s_product_name || $s_category_id || $s_from_price || $s_to_price) {
                $checked = true;
            }
        @endphp

        <button class="btn btn-success mt-3 search"><i class="fa-solid {{ $checked ? 'fa-minus' : 'fa-plus' }}"></i> Search</button>

        {{-- Form mutiple search --}}
        <form id="form-search" action="#" class="w-50 mt-2" style="display: {{ $checked ? 'block' : 'none' }}">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Product Name</label>
                    <input type="text" name="s_product_name" class="form-control" value="{{ $s_product_name }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Category Name</label>
                    <select name="s_category_id" class="form-select form-control">
                        <option value=""></option>
                        @foreach ($categories as $category)
                            <option {{ $s_category_id == $category->id ? 'selected' : null }} value="{{ $category->id }}">
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Price</label>
                    <div class=" d-flex align-items-center">
                        <input type="text" name="s_from_price" class="form-control flex-grow-1"
                            value="{{ $s_from_price }}">
                        <span class="mx-2">~</span>
                        <input type="text" name="s_to_price" class="form-control flex-grow-1"
                            value="{{ $s_to_price }}">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Status</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                            <label class="form-check-label" for="inlineCheckbox1">Activate</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option1" checked>
                            <label class="form-check-label" for="inlineCheckbox2">Deactivate</label>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <button class="btn btn-success btn-sm px-4"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>

            </div>
        </form>

        @php
            $showCount = request()->has('show-count') ? request()->input('show-count') : 5;
        @endphp
        <form action="{{ request()->fullUrlWithQuery(['show-count' => '']) }}" class="mt-4">
            <label>Show-entries :</label>
            <select name="show-count" id="show-count" style="width: 60px;padding-left: 5px">
                <option {{ $showCount == 5 ? 'selected' : null }} value="5">5</option>
                <option {{ $showCount == 10 ? 'selected' : null }} value="10">10</option>
                <option {{ $showCount == 20 ? 'selected' : null }} value="20">20</option>
                <option {{ $showCount == 30 ? 'selected' : null }} value="30">30</option>
                <option {{ $showCount == 40 ? 'selected' : null }} value="40">40</option>
                <option {{ $showCount == 50 ? 'selected' : null }} value="50">50</option>
            </select>
        </form>

        <table class="table table-hover mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category Name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if ($products->count() > 0)
                    @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td></td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input fs-5" type="checkbox" data-id="{{ $product->id }}"
                                        {{ $product->status == 1 ? 'checked' : null }}>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">No data</td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{-- Total Items --}}
        <div class="total-items">
            Total : {{ $products->total() }}
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-end">
            {{ $products->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $(".search").click(function() {
                $("#form-search").toggle(300);
                $(this).children("i").toggleClass("fa-plus fa-minus");
            })
        });
    </script>
@endpush
