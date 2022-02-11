<?php

namespace App\Http\Controllers;

use App\SupplierPriceSurvey;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class SupplierPriceSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {


        $filter = json_decode($request->input("filter"));

        if ($filter) {

            if (strlen($filter->query) > 0)
                return SupplierPriceSurvey::with('product', 'user', 'supplier')->whereHas("product", function ($q) use ($filter) {
                    $q->where("name", 'like', "%" . $filter->query . "%");
                    $q->orWhere("barcode", 'like', "%" . $filter->query . "%");
                })->latest()->paginate(10);

            if (isset($filter->id)) {

                return SupplierPriceSurvey::with('product', 'user', 'supplier')->where("product_id",$filter->id)->latest()->paginate(10);

            }


        } else {
            return SupplierPriceSurvey::with('product', 'user', 'supplier')->latest()->paginate(10);


        }
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
            "product_id" => "required|exists:products,id||max:255",
            "supplier_id" => "required|exists:suppliers,id|max:255",
            "price" => "required|numeric",
            "mobile_id" => "nullable",
        ]);

        $survey = new SupplierPriceSurvey();
        $survey->product_id = $data["product_id"];
        $survey->supplier_id = $data["supplier_id"];
        $survey->price = $data["price"];
        $survey->user_id = JWTAuth::parseToken()->toUser()->id;
        $survey->mobile_id = $data["mobile_id"];
        $survey->save();
        return "OK";
    }

    /**
     * Display the specified resource.
     *
     * @param \App\SupplierPriceSurvey $supplierPriceSurvey
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierPriceSurvey $supplierPriceSurvey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\SupplierPriceSurvey $supplierPriceSurvey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupplierPriceSurvey $supplierPriceSurvey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\SupplierPriceSurvey $supplierPriceSurvey
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplierPriceSurvey $supplierPriceSurvey)
    {
        //
    }

    public function count()
    {
        return SupplierPriceSurvey::all()->count();
    }
}
