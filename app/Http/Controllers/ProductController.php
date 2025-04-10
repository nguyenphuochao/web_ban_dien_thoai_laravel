<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $conds = [];

        $s_product_name = $request->input('s_product_name');
        if ($request->has('s_product_name') && $s_product_name != "") {
            $conds[] = ["name", "LIKE", "%" . $s_product_name . "%"];
        }

        $s_category_id = $request->input('s_category_id');
        if ($request->has('s_category_id') && $s_category_id != "") {
            $conds[] = ["category_id", "=", $s_category_id];
        }

        $s_from_price = $request->input('s_from_price');
        if ($request->has('s_from_price') && $s_from_price != "") {
            $conds[] = ["price", ">=", $s_from_price];
        }

        $s_to_price = $request->input('s_to_price');
        if ($request->has('s_to_price') && $s_to_price != "") {
            $conds[] = ["price", "<=", $s_to_price];
        }

        $products = Product::where($conds)->paginate(5)->withQueryString();
        $categories = Category::orderBy("sort_num", "ASC")->get();

        $data = [
            "products"   => $products,
            "categories" => $categories
        ];
        return view('product.index', $data);
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
