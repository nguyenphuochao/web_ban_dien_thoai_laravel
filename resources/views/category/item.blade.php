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
                <button data-id="{{ $category->id }}" class="btn btn-warning edit" data-bs-target="#editCategoryModal"
                    data-bs-toggle="modal">Edit</button>
                <button data-id="{{ $category->id }}" class="btn btn-danger delete" data-bs-target="#deleteModal"
                    data-bs-toggle="modal">Delete</button>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="4" class="text-center">No data
        <td>
    </tr>
@endif
