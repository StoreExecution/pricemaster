<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalepointPriceSurvey extends Model
{
  
    public function user()
    {

        return $this->belongsTo(User::class);
    }
    public function salepoint()
    {

        return $this->belongsTo(Salepoint::class);
    }
    public function product()
    {

        return $this->belongsTo(Product::class);
    }
}
