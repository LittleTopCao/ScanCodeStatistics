<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FactoryCode extends Model
{

    /**
     * 拥有多个 code 二维码
     */
    public function codes()
    {
        return $this->hasMany('App\Code');
    }



}
