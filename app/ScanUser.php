<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScanUser extends Model
{

    protected $fillable = ['open_id', 'name', 'nick_name', 'avatar'];

    /**
     * 拥有多个扫码记录
     */
    public function scanRecords()
    {
        return $this->hasMany('App\ScanRecord');
    }

    /**
     * 拥有 领取 记录
     */
    public function sendRecords()
    {
        return $this->hasMany('App\SendRecord');
    }
}
