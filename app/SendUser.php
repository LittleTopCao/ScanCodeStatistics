<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendUser extends Model
{
    /**
     * 拥有 领取 记录
     */
    public function sendRecords()
    {
        return $this->hasMany('App\SendRecord');
    }
}
