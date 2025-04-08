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
            $col = "order_by";
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

            $categories = $query->orderBy($col, $sortType)->paginate(5)->withQueryString();

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
        Category::create([
            'name' => $request->name
        ]);
        request()->session()->put('success', 'Category created successfully');
        return redirect()->route('categories.index');
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
        $sort_data = $request->selected;
        $sort_data = explode(",", $sort_data);
        if (count($sort_data) == 1) {
            request()->session()->put('success', 'Category sorted successfully');
            return redirect()->route('categories.index');
        }

        for ($i = 0; $i < count($sort_data); $i++) {
            $category = Category::find($sort_data[$i]);
            $category->order_by = $index++;
            $category->save();
        }
        request()->session()->put('success', 'Category sorted successfully');
        return redirect()->route('categories.index');
    }
}
