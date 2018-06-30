<?php

namespace App\Http\Controllers;

use DebugBar\DebugBar;
use Illuminate\Http\Request;

/**
 * Class ScanCodeController
 * @package App\Http\Controllers
 * 扫码控制器
 * 拿到 用户 和 二维码 信息
 * 判断是否第一次, 插入数据库
 * 重定向到 厂家二维码 url
 *
 */
class ScanCodeController extends Controller
{

    public function show($id)
    {
        DebugBar::info(session('wechat.oauth_user'));
        return 'xxx';
    }

}
