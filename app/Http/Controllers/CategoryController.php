<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $col = "sort_num";
            $sortType = "asc";
            $query = Category::query();

            // sắp xếp theo tiêu chí ASC | DESC
            if ($request->has('sort')) {
                // ?sort=id-asc
                $sort = $request->input('sort');
                $colMap = ["id" => "id", "alpha" => "name"];
                $tmp = explode("-", $sort);
                $col = $colMap[$tmp[0]];
                $sortType = $tmp[1];
            }

            // Tìm kiếm theo ID, Name
            if ($request->has('search')) {
                // ?search=Samsung
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where("name", "LIKE", "%$search%")
                        ->orWhere("id", "=", "$search");
                });
            }

            // hiển thị show-count
            $show_count = 5;
            if ($request->has('show-count')) {
                $show_count = $request->input('show-count');
            }

            $categories = $query->orderBy($col, $sortType)->paginate($show_count)->withQueryString();

            $data = [
                'categories' => $categories
            ];

            return view('category.index', $data);
        } catch (\Throwable $th) {

            return redirect()->route('categories.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate
        $request->validate(
            [
                'name' => 'required|unique:categories'
            ],
            [
                'name.required' => 'Category name is required',
                'name.unique' => 'Category name already exists'
            ]
        );

        // success
        $categories = Category::all();
        $count = $categories->count();

        Category::create([
            'name'     => $request->name,
            'sort_num' => $count + 1
        ]);

        $categories = Category::orderBy('sort_num', 'asc')->paginate(5)->withQueryString();

        $item = view('category.item', ["categories" => $categories])->render();
        $pagination = view('category.pagination', ["categories" => $categories])->render();
        $totalItem = $categories->total();

        return response()->json([
            'item' => $item,
            'pagination' => $pagination,
            'totalItem' => $totalItem
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        echo $category->name;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validate
        $request->validate(
            [
                'name' => 'required|unique:categories,name,' . $id
            ],
            [
                'name.required' => 'Category name is required',
                'name.unique' => 'Category name already exists'
            ]
        );

        // success
        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->save();
        request()->session()->put('success', 'Category updated successfully');
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::destroy($id);
        request()->session()->put('success', 'Category deteted successfully');
        return redirect()->route('categories.index');
    }

    public function sort(Request $request)
    {

        $index = 1;
        $sort_data = $request->input('selected');
        if ($sort_data == NULL) {
            request()->session()->put('success', 'Category sorted successfully');
            return redirect()->route('categories.index');
        }

        $sort_data = explode(",", $sort_data);
        for ($i = 0; $i < count($sort_data); $i++) {
            $category = Category::find($sort_data[$i]);
            $category->sort_num = $index++;
            $category->save();
        }
        request()->session()->put('success', 'Category sorted successfully');
        return redirect()->route('categories.index');
    }
}
