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
        <button class="btn btn-success mt-3 search"><i class="fa-solid fa-plus"></i> Search</button>

        <form id="form-search" action="#" class="w-50 mt-2" style="display: none">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>ID</label>
                    <input type="text" name="ID" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Product Name</label>
                    <input type="text" name="product_name" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Category Name</label>
                    <select name="category_name" class="form-select form-control">
                        <option value=""></option>
                        <option value="1">Cat1</option>
                        <option value="2">Cat2</option>
                        <option value="3">Cat3</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Price</label>
                    <div class=" d-flex align-items-center">
                        <input type="text" name="from_price" class="form-control flex-grow-1">
                        <span class="mx-2">~</span>
                        <input type="text" name="to_price" class="form-control flex-grow-1">
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
                    @foreach ($products as $product)
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category Name</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Status</th>
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
