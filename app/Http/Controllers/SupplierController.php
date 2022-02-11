<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class SupplierController extends Controller
{
    public function index(Request $request)
    {

        $filter = json_decode($request->input("filter"));

        if ($filter && strlen($filter->query) > 0) {

            return Supplier::with('user')->where("name","like","%" . $filter->query . "%")->latest()->take(50)->get();
        }
        return Supplier::with('user')->latest()->take(50)->get();
    }

    public function all()
    {
        //
        return Supplier::all();
    }

    public function show(Supplier $supplier)
    {

        return $supplier;
    }

    public function update(Request $request, Supplier $supplier)
    {

        $data = $request->validate([
            "name" => "required|unique:suppliers,name,$supplier->id|max:255",
            "adress" => "max:255",
            "phone" => "nullable|unique:suppliers,phone,$supplier->id|max:255",
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

    public function store(Request $request)
    {

        $data = $request->validate([
            "name" => "required|unique:suppliers,name|max:255",
            "adress" => "max:255",
            "phone" => "nullable|unique:suppliers,phone|max:255",
            "latitude" => "nullable|numeric",
            "longitude" => "nullable|numeric",
        ]);
        $supplier = new Supplier();

        $supplier->name = $data["name"];
        $supplier->adress = $data["adress"];
        $supplier->phone = $data["phone"];

        $supplier->latitude = $data["latitude"] == null ? 0.0 : $data["latitude"];
        $supplier->longitude = $data["longitude"] == null ? 0.0 : $data["longitude"];
        $supplier->user_id = JWTAuth::parseToken()->toUser()->id;
        $supplier->save();
        return "OK";

    }

    public function count()
    {
        return Supplier::all()->count();
    }


}
