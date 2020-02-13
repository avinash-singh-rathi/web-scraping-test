<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    public function website()
    {
        return $this->belongsTo('App\Model\Website');
    }
}
