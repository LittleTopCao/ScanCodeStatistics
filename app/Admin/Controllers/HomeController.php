<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\InfoBox;

use DB;
use Encore\Admin\Widgets\Table;

/**
 * 统计信息: 今日新增用户, 今日扫码, 今日领取, 总共扫码, 总共领取
 *          按 厂家二维码,  按 扫码二维码, 按 发放二维码
 * @package App\Admin\Controllers
 */
class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('统计信息');

            // 今日新增用户  今日扫码  总共扫码
            $userNumber = DB::select('SELECT count(*) FROM scan_users WHERE TO_DAYS(scan_users.created_at) = TO_DAYS(NOW());');
            $scanNumber = DB::select('SELECT count(*) FROM scan_records WHERE TO_DAYS(scan_records.created_at) = TO_DAYS(NOW());');
            $scanTotal = DB::select('SELECT count(*) FROM scan_records;');
            $info = '今日新增用户: '.((array)$userNumber[0])['count(*)'].'&nbsp;&nbsp;&nbsp;&nbsp;今日扫码: '.((array)$scanNumber[0])['count(*)'].'&nbsp;&nbsp;&nbsp;&nbsp;总共扫码: '.((array)$scanTotal[0])['count(*)'];

            // 今日领取  总共领取
            $sendNumber = DB::select('SELECT sum(send_records.number) FROM send_records WHERE TO_DAYS(send_records.created_at) = TO_DAYS(NOW());');
            $sendNow = DB::select('SELECT sum(scan_users.scan_number) FROM scan_users;');
            $sendTotal = DB::select('SELECT sum(send_records.number) FROM send_records;');
            $name = '今日领取: '.((array)$sendNumber[0])['sum(send_records.number)'].'&nbsp;&nbsp;&nbsp;&nbsp;总共领取: '.((array)$sendTotal[0])['sum(send_records.number)'].'&nbsp;&nbsp;&nbsp;&nbsp;剩余未领取: '.((array)$sendNow[0])['sum(scan_users.scan_number)'];

            $content->row(new InfoBox($name, 'th-list', 'aqua', '', $info));


//            厂家二维码,  按 扫码二维码, 按 发放二维码
            $content->row(function (Row $row) {


                // 按厂家二维码统计
                $row->column(4, function (Column $column) {

                    $headers = ['二维码', '今日扫码'];

                    $result = DB::select('SELECT f.name AS a, count(scan_records.id) AS b FROM factory_codes AS f LEFT OUTER JOIN codes ON f.id = codes.factory_code_id LEFT OUTER JOIN scan_records ON codes.id = scan_records.code_id WHERE TO_DAYS(scan_records.created_at) = TO_DAYS(NOW()) GROUP BY f.name;');
                    $rows = array_map(function ($value) {
                        return [$value->a, $value->b];
                    }, $result);

                    $table = new Table($headers, $rows);
                    $box = new Box('厂家统计', $table);

                    $column->append($box);
                });

                // 按扫码二维码统计
                $row->column(4, function (Column $column) {
                    $headers = ['二维码', '今日扫码'];

                    $result = DB::select('SELECT codes.name AS a, count(scan_records.id) AS b FROM codes LEFT OUTER JOIN scan_records ON codes.id = scan_records.code_id WHERE TO_DAYS(scan_records.created_at) = TO_DAYS(NOW()) GROUP BY codes.name;');
                    $rows = array_map(function ($value) {
                        return [$value->a, $value->b];
                    }, $result);

                    $table = new Table($headers, $rows);
                    $box = new Box('扫码统计', $table);

                    $column->append($box);
                });

                // 按发放二维码统计
                $row->column(4, function (Column $column) {
                    $headers = ['二维码', '今日发放'];

                    $result = DB::select('SELECT send_codes.name AS a, sum(send_records.number) AS b FROM send_codes LEFT OUTER JOIN send_records ON send_codes.id = send_records.send_code_id WHERE TO_DAYS(send_records.created_at) = TO_DAYS(NOW()) GROUP BY send_codes.name;');
                    $rows = array_map(function ($value) {
                        return [$value->a, $value->b];
                    }, $result);

                    $table = new Table($headers, $rows);
                    $box = new Box('发放统计', $table);

                    $column->append($box);
                });
            });
        });
    }
}
