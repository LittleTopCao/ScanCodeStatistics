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

// 扫码控制器, 路由参数: 二维码 id , 中间件: 微信用户信息 中间件
Route::get('/scan/{id}', 'ScanCodeController@show')->middleware('wechat.oauth:snsapi_userinfo');
