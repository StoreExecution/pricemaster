<?php

namespace App\Http\Controllers;

use App\Purchase;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class PurchaseController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {

        $filter = json_decode($request->input("filter"));

        if ($filter && strlen($filter->query) > 0) {

            return Purchase::with(['product', 'user', 'supplier'])->whereHas("product",function ($q) use($filter){
               $q->where("name", 'like', "%" . $filter->query . "%");
                $q->orWhere("barcode", 'like', "%" . $filter->query . "%");
            })->latest()->paginate(10);


        } else {
            return Purchase::with('product', 'user', 'supplier')->latest()->paginate(10);
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

        $purchase = new Purchase();
        $purchase->product_id = $data["product_id"];
        $purchase->supplier_id = $data["supplier_id"];
        $purchase->price = $data["price"];
        $purchase->user_id = JWTAuth::parseToken()->toUser()->id;
        $purchase->mobile_id = $data["mobile_id"];
        $purchase->save();
        return "OK";
    }

    /**
     * Display the specified resource.
     *
     * @param \App\SupplierPriceSurvey $supplierPriceSurvey
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $supplierPriceSurvey)
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
    public function update(Request $request, Purchase $supplierPriceSurvey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\SupplierPriceSurvey $supplierPriceSurvey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $supplierPriceSurvey)
    {
        //
    }

    public function count()
    {
        return Purchase::all()->count();
    }


}
