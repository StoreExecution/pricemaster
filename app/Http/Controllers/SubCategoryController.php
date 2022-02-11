<?php

namespace App\Http\Controllers;

use App\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SubCategory::with('category')->latest()->paginate(10);


    }


    /**
     * Display a listing of the resource witout pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return   SubCategory::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|unique:sub_categories|max:255",
            "category" => ['required', "exists:categories,id"],

        ]);

        $subCategory = new SubCategory();
        $subCategory->name = $data["name"];
        $subCategory->category_id = $data["category"];
        $subCategory->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubCategory $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        // return '{"test":"test"}';
        return $subCategory;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\SubCategory $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        $data = $request->validate([
            "name" => "required|unique:sub_categories,name,$subCategory->id|max:255",
            "category" => ['required', "exists:categories,id"],

        ]);

        // $subCategory = new SubCategory();
        $subCategory->name = $data["name"];
        $subCategory->category_id = $data["category"];
        $subCategory->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubCategory $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        //
    }
}
