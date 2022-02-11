<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public function user()
    {

        return $this->belongsTo(User::class);
    }
    
    public function survey(){
        return $this->hasMany(SupplierPriceSurvey::class);
    }
}
