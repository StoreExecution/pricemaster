<?php

namespace App\Http\Controllers;

use App\Salepoint;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class SalepointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $filter = json_decode($request->input("filter"));

        if ($filter && strlen($filter->query) > 0) {
            return Salepoint::with('user')->where("name","like","%" . $filter->query . "%")->latest()->take(50)->get();

        } else
            return Salepoint::with('user')->latest()->take(50)->get();
    }

    public function all()
    {
        return Salepoint::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|unique:salepoints,name|max:255",
            "adress" => "max:255",
            "phone" => "nullable|unique:salepoints,phone|max:255",
            "latitude" => "nullable|numeric",
            "longitude" => "nullable|numeric",
        ]);
        $supplier = new Salepoint();

        $supplier->name = $data["name"];
        $supplier->adress = $data["adress"];
        $supplier->phone = $data["phone"];

        $supplier->latitude = $data["latitude"] == null ? 0.0 : $data["latitude"];
        $supplier->longitude = $data["longitude"] == null ? 0.0 : $data["longitude"];
        $supplier->user_id = JWTAuth::parseToken()->toUser()->id;
        $supplier->save();
        return "ok";
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Salepoint $salepoint
     * @return \Illuminate\Http\Response
     */
    public function show(Salepoint $salepoint)
    {
        return $salepoint;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Salepoint $salepoint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salepoint $salepoint)
    {
        $data = $request->validate([
            "name" => "required|unique:suppliers,name,$salepoint->id|max:255",
            "adress" => "max:255",
            "phone" => "nullable|unique:suppliers,phone,$salepoint->id|max:255",
            "latitude" => "nullable|numeric",
            "longitude" => "nullable|numeric",
        ]);

        $supplier->name = $data["name"];
        $supplier->adress = $data["adress"];
        $supplier->phone = $data["phone"];
        $supplier->latitude = $data["latitude"] == null ? 0.0 : $data["latitude"];
        $supplier->longitude = $data["longitude"] == null ? 0.0 : $data["longitude"];
        $supplier->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Salepoint $salepoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salepoint $salepoint)
    {
        //
    }

    public function count()
    {
        return Salepoint::all()->count();
    }
}
