<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Debugbar;
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
        // 拿到用户
        $user = session('wechat.oauth_user.default');
        // 判断用户是否存在数据库
        // 如果存在拿到 id
        // 不存在先存储
        // 判断二维码是否存在
        //
        return 'xxx';
    }

}
