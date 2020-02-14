<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    //

    public function categories()
    {
        return $this->hasMany('App\Model\Category');
    }

    public function brands()
    {
        return $this->hasMany('App\Model\Brand');
    }

    public function processlinks()
    {
        return $this->hasMany('App\Model\Processlink');
    }
}
