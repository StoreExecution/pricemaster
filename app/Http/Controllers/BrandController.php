<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\InputArgument;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //


        return Brand::latest()->paginate(10);

    }

    /**
     * Display a listing of the resource without pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        //

        return Brand::all();
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
            "name" => "required|unique:brands|max:255",
        ]);

        $brand = new Brand();
        $brand->name = $data["name"];
        $brand->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        return $brand;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            "name" => "required|unique:brands,name,$brand->id|max:255",
        ]);

      
        $brand->name = $data["name"];
        $brand->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
