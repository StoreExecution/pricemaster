<?php

namespace App\Http\Controllers;

use App\Models\CocaColaFridge;
use App\Models\Salepoint;
use App\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StockController extends Controller
{


    public function store(Request $request)
    {
        $stock = new Stock();

        $data = $request->validate([
            "mobile_id" => "string",
            "date" => "string",
            "quantity" => "required|numeric",
            "barcode" => "string",
        ]);

        if (Stock::where("mobile_id", $data["mobile_id"])->count() == 0) {

            $stock->date = $data["date"];
            $stock->mobile_id = $data["mobile_id"];
            $stock->quantity = $data["quantity"];
            $stock->barcode = $data["barcode"];
            $stock->save();
        }

        return "OK";


    }

    public function export(Request $request)
    {

        $delimiter = ",";
        $date= Carbon::today()->toDateString();

        //return "";
        ini_set("memory_limit", "15000M");
        ini_set("max-execution_time", "5000");


        $headers = array(
            "Content-Encoding" => "utf-8",
            "Content-type" => "text/html charset=utf-8",

            "Content-Disposition" => "attachment; filename=".$date.".txt",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );


        $response = new StreamedResponse(function () use ($date, $delimiter) {

            // Open output stream
            //  $handle = fopen('php://output', 'w');

            // Add CSV headers
            $columns = array(
                'Barcode Scanned', 'Qty'

            );

            $file = fopen('php://output', 'w+');
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns, $delimiter);


            // Get all users
            Stock::where(function ($q) use ($date, $delimiter) {


                $q->where("date", $date);

            })

//                ->where("backoffice", 1)
                ->chunk(400, function ($datas) use ($file, $columns, $delimiter) {


                    foreach ($datas as $data) {


                        fputcsv($file, array(

                            $data->barcode,
                            $data->quantity


                        ), $delimiter);

                    }


                });

            // Close the output stream
            fclose($file);
        }, 200, $headers);
        return $response;

    }
}
