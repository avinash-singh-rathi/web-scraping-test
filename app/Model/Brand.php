<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //

    public function website()
    {
        return $this->belongsTo('App\Model\Website');
    }
    
}
