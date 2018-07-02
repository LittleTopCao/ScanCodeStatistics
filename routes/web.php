<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 扫码控制器, 路由参数: 二维码 id , 中间件: 微信用户信息 中间件, $id 用来区分二维码
Route::get('/scan/{id}', 'ScanCodeController@scan')->middleware('wechat.oauth:default,snsapi_userinfo');
// 扫码查看 当前可领数, 总共领取数, $id 用来区分二维码
Route::get('/statistics/{id}', 'ScanCodeController@statistics')->middleware('wechat.oauth:default,snsapi_userinfo');
// 领取 礼品 , 返回 成功 提示
Route::get('/send', 'ScanCodeController@send')->middleware('wechat.oauth:default,snsapi_userinfo');

