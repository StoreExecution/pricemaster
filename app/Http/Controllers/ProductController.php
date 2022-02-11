<?php

namespace App\Http\Controllers;

use App\Product;
use App\Purchase;
use Aspera\Spreadsheet\XLSX\Reader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductController extends Controller
{

    protected $guard = [];

    public function __construct()
    {
        //   $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = json_decode($request->input("filter"));
        if ($filter) {
            if (strlen($filter->query) > 0) {
             return   Product::with('brand', 'category')->where(function ($q) use ($filter) {
                    // dd($filter->query);
                    $q->where("name", "like", "%" . $filter->query . "%");
                    $q->orWhere("barcode", "like", "%" . $filter->query . "%");
                })->latest()->paginate(10);

            } else
                return Product::with('brand', 'category')->latest()->paginate(10);

        } else ;
        return Product::with('brand', 'category')->latest()->paginate(10);

    }

    /**
     * Display a listing of the resource without pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            "name" => "required|unique:products|max:255",
            "barcode" => "required|unique:products|max:255",
            "brand" => ['required', "exists:brands,id"],
            "category" => ['required', "exists:categories,id"],
            "weight" => "numeric"

        ]);

        $product = new Product();
        $product->name = $data["name"];
        $product->barcode = $data["barcode"];
        $product->weight = $data["weight"];
        $product->brand_id = $data["brand"];
        $product->category_id = $data["category"];
        $product->subcategory_id = 1;
        $product->save();


        return redirect("/products");
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

        return response($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = request()->validate([
            "name" => "required|unique:products,name,$product->id|max:255",
            "barcode" => "required|unique:products,barcode,$product->id|max:255",
            "brand" => ['required', "exists:brands,id"],
            "category" => ['required', "exists:categories,id"],
            "weight" => "numeric"

        ]);
        //    return response()->json(['error' => true,"message"=>"Bad Request"], 400);
        //$product = new Product();
        $product->name = $data["name"];
        $product->barcode = $data["barcode"];
        $product->weight = $data["weight"];
        $product->brand_id = $data["brand"];
        $product->category_id = $data["category"];
        $product->save();
        return response()->json(['error' => false, "message" => "Product updated"], 200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function count()
    {
        return Product::all()->count();
    }

    public function parse(Request $request)
    {

        ini_set("memory_limit", "1000M");

        ini_set('max_execution_time', '300');
        set_time_limit(300);

        $file = $request->file;
        $filename = Carbon::now() . "_" . 1;

        $path = public_path('/upload/xlsx/');

        $file->move($path, $filename);
        $reader = new Reader();
        $reader->open($path . $filename);


        $index = 0;

        foreach ($reader as $row) {


            if ($index > 2) {

                $product = Product::where("barcode", $row[0])->first();
                if ($product == null) {

                    $product = new Product();
                    $product->name = $row[1];
                    $product->barcode = $row[0];
                    $product->selling_price = doubleval($row[2]);
                    $product->purchase_price = doubleval($row[3]);
                    $product->stock = doubleval($row[4]);
                    $product->weight = 0;
                    $product->brand_id = 1;
                    $product->category_id = 1;
                    $product->subcategory_id = 1;
                    $product->save();

                    if ($row[3] != 0) {
                        $purchase = new Purchase();
                        $purchase->product_id = $product->id;
                        $purchase->supplier_id = 1;
                        $purchase->price = doubleval($row[3]);

                        $purchase->user_id = 1;
                        $purchase->mobile_id = uniqid();
                        $purchase->save();
                    }

                } else {

                    $product->name = $row[1];
                    $product->barcode = $row[0];
                    $product->selling_price = doubleval($row[2]);
                    $product->purchase_price = doubleval($row[3]);
                    $product->weight = 0;
                    $product->brand_id = 1;
                    $product->stock = doubleval($row[4]);
                    $product->category_id = 1;
                    $product->subcategory_id = 1;
                    $product->save();
                    if ($row[3] != 0) {
                        $purchase = Purchase::where("product_id", $product->id)->where("supplier_id", 1)->orderBy('created_at', 'desc')->first();
                        if ($purchase != null && $purchase->price != $row[3]) {

                            $newPurchase = new Purchase();
                            $newPurchase->product_id = $product->id;
                            $newPurchase->supplier_id = 1;
                            $newPurchase->price = doubleval($row[3]);

                            $newPurchase->user_id = 1;
                            $newPurchase->mobile_id = uniqid();
                            $newPurchase->save();


                        }
                    }

                }


            }

            $index++;


        }

        return $index;

    }

    public function parseEdit(Request $request)
    {


        $file = $request->file;
        $filename = Carbon::now() . "_" . 1;

        $path = public_path('/upload/xlsx/');

        $file->move($path, $filename);
        $reader = new Reader();
        $reader->open($path . $filename);


        $index = 0;
        $edited = 0;

        foreach ($reader as $row) {

//dd(Product::where("barcode", $row[0])->first());
            if (Product::where("barcode", $row[0])->count() > 0) {
                $product = Product::where("barcode", $row[0])->first();


                $purchase = new Purchase();
                $purchase->product_id = $product->id;
                $purchase->supplier_id = 1;
                $purchase->price = $row[1];
                $purchase->user_id = 1;
                $purchase->mobile_id = uniqid();
                $purchase->save();

                $edited++;


            }
            $index++;


        }

        return $edited;

    }

}
