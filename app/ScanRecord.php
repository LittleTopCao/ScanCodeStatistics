<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScanRecord extends Model
{
    /**
     * 所属用户
     */
    public function scanUser()
    {
        return $this->belongsTo('App\ScanUser');
    }

    /**
     * 所属二维码
     */
    public function code()
    {
        return $this->belongsTo('App\Code');
    }
}
