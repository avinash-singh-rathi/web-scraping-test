<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Processproduct extends Model
{
    //
    public function processlink()
    {
        return $this->belongsTo('App\Model\Processlink');
    }

}
