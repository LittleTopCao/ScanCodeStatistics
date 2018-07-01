<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendRecord extends Model
{
    /**
     * 所属用户
     */
    public function scanUser()
    {
        return $this->belongsTo('App\ScanUser');
    }

    /**
     * 所属发放二维码
     */
    public function sendUser()
    {
        return $this->belongsTo('App\SendUser');
    }
}
