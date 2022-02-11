<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->double("weight")->default(0);
            $table->double("selling_price")->default(0);
            $table->double("stock")->default(0);
            $table->string("barcode")->unique();

            $table->unsignedBigInteger("category_id");
            $table->unsignedBigInteger("subcategory_id");
            $table->unsignedBigInteger("brand_id");
            $table->string("image")->nullable();
            $table->timestamps();


            $table->foreign("category_id")->references("id")->on("categories");
            $table->foreign("subcategory_id")->references("id")->on("sub_categories");
            $table->foreign("brand_id")->references("id")->on("brands");

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
