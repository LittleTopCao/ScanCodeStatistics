<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2018/6/30
 * Time: 19:58
 */

namespace App\Http\Controllers;

use Log;
use Debugbar;

class WeChatController
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志
        $app = app('wechat.official_account');
        return $app->server->serve();
    }
}