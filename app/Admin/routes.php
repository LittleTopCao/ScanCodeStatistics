<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('factory-codes', FactoryCodeController::class); // 厂家二维码
    $router->resource('codes', CodeController::class); // 扫码 二维码
    $router->resource('send-codes', SendCodeController::class); // 发放二维码
    $router->resource('send-users', ScanUserController::class); // 扫码用户

    $router->get('api/factory-codes', 'ApiListController@factoryCodes');

});
