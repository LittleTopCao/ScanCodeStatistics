<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{

    /**
     * 所属厂家 二维码
     */
    public function factoryCode()
    {
        return $this->belongsTo('App\FactoryCode');
    }

    /**
     * 拥有多个扫码记录
     */
    public function scanRecords()
    {
        return $this->hasMany('App\ScanRecord');
    }

}
