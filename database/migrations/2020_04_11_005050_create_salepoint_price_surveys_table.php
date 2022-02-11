<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalepointPriceSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salepoint_price_surveys', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("salepoint_id");
            $table->double("price");
            $table->string("mobile_id")->nullable()->unique();
            $table->timestamps();

            $table->foreign("salepoint_id")->references("id")->on("salepoints");
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("product_id")->references("id")->on("products");
      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salepoint_price_surveys');
    }
}
