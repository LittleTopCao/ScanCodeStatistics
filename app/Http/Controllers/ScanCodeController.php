<?php

namespace App\Http\Controllers;

use App\Code;
use App\ScanRecord;
use App\ScanUser;
use App\SendCode;
use App\SendRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

    /**
     *
     */
    public function scan($id)
    {
        // 拿到二维码
        $code = Code::with('factoryCode')->findOrFail($id);
        // 拿到用户
        $wechatUser = session('wechat.oauth_user.default');
        // 查找用户, 没有则创建
        $scanUser = ScanUser::firstOrCreate(['open_id' => $wechatUser->getId()],
            ['name' => $wechatUser->getName(), 'nick_name' => $wechatUser->getNickname(), 'avatar' => $wechatUser->getAvatar()]);

        // 判断微信名 和 微信头像 是否已修改 ,
        if($scanUser->name != $wechatUser->getName() || $scanUser->avatar != $wechatUser->getAvatar()){
            $scanUser->name = $wechatUser->getName();
            $scanUser->avatar = $wechatUser->getAvatar();
            $scanUser->save();
        }

        // 判断最新扫码时间, 如果不是今天 则  插入记录
        if($scanUser->scan_date == null || !Carbon::parse($scanUser->scan_date)->isToday()){
            // 插入 扫码记录
            $scanRecord = new ScanRecord();
            $scanRecord->scan_user_id = $scanUser->id;
            $scanRecord->code_id = $code->id;
            $scanRecord->save();
            // 更新 扫码次数 及 最新扫码时间
            $scanUser->scan_number += 1;
            $scanUser->scan_total += 1;
            $scanUser->scan_date = Carbon::now();
            $scanUser->save();
        }
        return redirect($code->factoryCode->url);
    }

    /**
     * 扫码查看当前个人统计信息
     */
    public function statistics($id)
    {
        // 拿到发放二维码
        $sendCode = SendCode::findOrFail($id);
        // 拿到用户信息
        $wechatUser = session('wechat.oauth_user.default');
        // 查找用户, 没有则创建
        $scanUser = ScanUser::firstOrCreate(['open_id' => $wechatUser->getId()],
            ['name' => $wechatUser->getName(), 'nick_name' => $wechatUser->getNickname(), 'avatar' => $wechatUser->getAvatar()]);

        return view('statistics', ['scanUser' => $scanUser, 'sendCode' => $sendCode]);
    }

    /**
     * 扫码领取页面, 验证领取个数, 返回领取成功页面
     */
    public function send(Request $request){
        $number = $request->input('number');
        $total = $request->input('total');
        $sendId = $request->input('code');

        // 拿到发放二维码
        $sendCode = SendCode::findOrFail($sendId);

        // 拿到用户信息
        $wechatUser = session('wechat.oauth_user.default');
        $scanUser = ScanUser::firstOrCreate(['open_id' => $wechatUser->getId()],
            ['name' => $wechatUser->getName(), 'nick_name' => $wechatUser->getNickname(), 'avatar' => $wechatUser->getAvatar()]);

        $isSendSuccess = false;
        if($scanUser->scan_number == $number && $scanUser->scan_total == $total){
            // 插入领取记录, 并把 可领取数 归零
            $sendRecord = new SendRecord();
            $sendRecord->scan_user_id = $scanUser->id;
            $sendRecord->send_code_id = $sendCode->id;
            $sendRecord->number = $scanUser->scan_number;
            $sendRecord->save();

            $scanUser->scan_number = 0;
            $scanUser->save();

            $isSendSuccess = true;
        }

        return view('result', ['isSendSuccess' => $isSendSuccess, 'number' => $number]);
    }

}
