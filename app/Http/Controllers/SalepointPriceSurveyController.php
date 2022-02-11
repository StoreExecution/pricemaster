<?php

namespace App\Http\Controllers;

use App\SalepointPriceSurvey;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class SalepointPriceSurveyController extends Controller
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

            if (strlen($filter->query) > 0) {

                return SalepointPriceSurvey::with('product', 'user', 'salepoint')->whereHas("product", function ($q) use ($filter) {
                    $q->where("name", 'like', "%" . $filter->query . "%");
                    $q->orWhere("barcode", 'like', "%" . $filter->query . "%");
                })->latest()->paginate(10);
            }
          else  if (isset($filter->id)) {

                return SalepointPriceSurvey::with('product', 'user', 'salepoint')->where("product_id", $filter->id)->latest()->paginate(10);


            }
          else {
              return SalepointPriceSurvey::with('product', 'user', 'salepoint')->latest()->paginate(10);
          }

        } else {
            return SalepointPriceSurvey::with('product', 'user', 'salepoint')->latest()->paginate(10);
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
            "salepoint_id" => "required|exists:suppliers,id|max:255",
            "price" => "required|numeric",
            "mobile_id" => "nullable",
        ]);

        $survey = new SalepointPriceSurvey();
        $survey->product_id = $data["product_id"];
        $survey->salepoint_id = $data["salepoint_id"];
        $survey->price = $data["price"];
        $survey->user_id = JWTAuth::parseToken()->toUser()->id;
        $survey->mobile_id = $data["mobile_id"];
        $survey->save();
        return "OK";
    }

    /**
     * Display the specified resource.
     *
     * @param \App\SalepointPriceSurvey $salepointPriceSurvey
     * @return \Illuminate\Http\Response
     */
    public function show(SalepointPriceSurvey $salepointPriceSurvey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\SalepointPriceSurvey $salepointPriceSurvey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalepointPriceSurvey $salepointPriceSurvey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\SalepointPriceSurvey $salepointPriceSurvey
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalepointPriceSurvey $salepointPriceSurvey)
    {
        //
    }

    public function count()
    {
        return SalepointPriceSurvey::all()->count();
    }
}
