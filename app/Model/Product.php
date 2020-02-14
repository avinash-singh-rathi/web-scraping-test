<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public function variants()
    {
        return $this->hasMany('App\Model\Variant');
    }
}
