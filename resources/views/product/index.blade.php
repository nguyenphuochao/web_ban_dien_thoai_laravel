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
        <h1>Category</h1>

        <button class="btn btn-primary">Add</button>

        @php
            $showCount = request()->has('show-count') ? request()->input('show-count') : 5;
        @endphp
        <form action="{{ request()->fullUrlWithQuery(['show-count' => '']) }}">
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
                @php
                    $sort = request()->has('sort') ? request('sort') : null;
                @endphp
                <tr>
                    <th>#</th>
                    <th data-url="{{ request()->fullUrlWithQuery(['sort' => 'id']) }}">ID <i
                            class="fa-solid {{ $sort == 'id-asc' ? 'fa-arrow-up' : null }} {{ $sort == 'id-desc' ? 'fa-arrow-down' : null }}"></i>
                    </th>
                    <th data-url="{{ request()->fullUrlWithQuery(['sort' => 'alpha']) }}">Name <i
                            class="fa-solid {{ $sort == 'alpha-asc' ? 'fa-arrow-up' : null }} {{ $sort == 'alpha-desc' ? 'fa-arrow-down' : null }}"></i>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if ($categories->count() > 0)
                    @php
                        $index = 1;
                    @endphp
                    @foreach ($categories as $category)
                        <tr>
                            <th scope="row">{{ $index++ }}</th>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <button data-id="{{ $category->id }}" class="btn btn-warning edit"
                                    data-bs-target="#editCategoryModal" data-bs-toggle="modal">Edit</button>
                                <button data-id="{{ $category->id }}" class="btn btn-danger delete"
                                    data-bs-target="#deleteModal" data-bs-toggle="modal">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">No data
                        <td>
                    </tr>
                @endif


            </tbody>
        </table>
        {{-- Total Items --}}
        <div class="total-items">
            Total : {{ $categories->total() }}
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-end">
            {{ $categories->links() }}
        </div>
    </div>

    {{-- POPUP FORM ADD --}}
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="categoryAddForm" action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">Name</label>
                            <input type="name" class="form-control" id="nameInput" name="name"
                                placeholder="Enter name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button"
                        onclick="event.preventDefault(); document.getElementById('categoryAddForm').submit();"
                        class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- POPUP FORM EDIT --}}
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="categoryEditForm" action="#" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">Name</label>
                            <input type="name" class="form-control" id="nameInput" name="name"
                                placeholder="Enter name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button"
                        onclick="event.preventDefault(); document.getElementById('categoryEditForm').submit();"
                        class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- POPUP FORM SORT --}}
    <div class="modal fade" id="sortCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Sort Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="categorySortForm" action="{{ route('categories.sort') }}" method="POST">
                        @csrf
                        <div id="sortable">
                            @php
                                $categories = App\Models\Category::orderBy('sort_num')->get();
                            @endphp
                            @foreach ($categories as $category)
                                <div data-id="{{ $category->id }}" class="bg-success p-2 mb-2 text-light">
                                    {{ $category->name }}</div>
                            @endforeach
                        </div>
                        <input type="text" name="selected" hidden>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button"
                        onclick="event.preventDefault(); document.getElementById('categorySortForm').submit();"
                        class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(function() {
            // Sort columns category
            $('.table th').click(function() {
                var data_url = $(this).data('url');
                if (!data_url) {
                    return;
                }
                if (!$(this).children("i").hasClass("fa-arrow-up")) {
                    $(this).children("i").addClass("fa-arrow-up");
                    window.location.href = data_url + "-asc";
                } else {
                    $(this).children("i").addClass("fa-arrow-down");
                    $(this).children("i").removeClass("fa-arrow-up");
                    window.location.href = data_url + "-desc";
                }
            });

            // Edit Category
            $(".edit").click(function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "/categories/" + id + "/edit",
                    success: function(data) {
                        $("#categoryEditForm input[name=name]").val(data); // update input name
                        $("#categoryEditForm").attr("action", "/categories/" +
                            id); // update action
                    }
                });
            });
        });

        // Delete Category
        $(".delete").click(function() {
            var id = $(this).data('id');
            $("#delete-id").text(id);
            $("#deleteForm").attr("action", "/categories/" + id);
        });

        // Sortable
        $("#sortable").sortable({
            update: function(e, ui) {
                var selected = [];
                var sortable = $("#sortable div");
                for (let index = 0; index < sortable.length; index++) {
                    var element = sortable[index];
                    selected.push($(element).data('id'));
                }
                $("input[name=selected]").val(selected);
            }
        });

        // show-entries
        $("#show-count").change(function() {
            var data_url = $(this).parent().attr('action');
            var show_count = $(this).val();
            var url = data_url.replace('show-count=',"show-count=" + show_count);
            window.location.href = url;
        });
    </script>
@endpush
