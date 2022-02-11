<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salepoint extends Model
{
    public function survey(){
        return $this->hasMany(SalepointPriceSurvey::class);
    }
    public function user()
    {

        return $this->belongsTo(User::class);
    }
}
