<?php

namespace App\Http\Controllers;

use App\Product;
use App\Purchase;
use App\Salepoint;
use App\SalepointPriceSurvey;
use App\Supplier;
use App\SupplierPriceSurvey;
use Illuminate\Http\Request;

class MobileController extends Controller
{


    public function getBestPrice(Product $product)
    {
        //$products = array();

        $surveys = Purchase::where("product_id", $product->id)
            ->orderBy("price", "DESC")
            ->take(5)
            ->get();
        if ($surveys == null)
            $surveys = array();
        return $surveys;
    }

    public function supplierHistory(Supplier $supplier)
    {

        $surveys = Purchase::where("supplier_id", $supplier->id)
            ->latest()
            ->take(10)
            ->get();
        if ($surveys == null)
            $surveys = array();
        return $surveys;

    }

    public function salepointHistory(Salepoint $salepoint)
    {


        $surveys = SalepointPriceSurvey::where("salepoint_id", $salepoint->id)
            ->latest()
            ->take(5)
            ->get();
        if ($surveys == null)
            $surveys = array();
        return $surveys;

    }

}
