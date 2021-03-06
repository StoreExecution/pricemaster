<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{


    public function user()
    {

        return $this->belongsTo(User::class);
    }

    public function supplier()
    {

        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {

        return $this->belongsTo(Product::class);
    }
}
