<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendCode extends Model
{
    /**
     * 拥有 领取 记录
     */
    public function sendRecords()
    {
        return $this->hasMany('App\SendRecord');
    }
}
