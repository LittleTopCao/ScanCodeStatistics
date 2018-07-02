<?php

namespace App\Admin\Controllers;

use App\Code;
use App\FactoryCode;

use App\ScanUser;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Zxing\QrReader;

use Debugbar;
use DB;

/**
 * 厂家二维码 增删改查类
 * @package App\Admin\Controllers
 */
class FactoryCodeController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('厂家二维码');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('厂家二维码');
            $content->description('编辑');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('厂家二维码');
            $content->description('创建');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(FactoryCode::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->name('名称');

//            $grid->url('链接');

            $grid->column('今日扫码')->display(function () {

                $count = DB::select('SELECT count(*) FROM factory_codes INNER JOIN codes ON factory_codes.id = codes.factory_code_id INNER JOIN scan_records ON codes.id = scan_records.code_id WHERE TO_DAYS(scan_records.created_at) = TO_DAYS(NOW()) AND factory_codes.id = ?;', [$this->id]);

                return ((array)$count[0])['count(*)'];
            });

            $grid->column('共扫码')->display(function () {

                $count = DB::select('SELECT count(*) FROM factory_codes INNER JOIN codes ON factory_codes.id = codes.factory_code_id INNER JOIN scan_records ON codes.id = scan_records.code_id WHERE factory_codes.id = ?;', [$this->id]);

                return ((array)$count[0])['count(*)'];
            });

            $grid->updated_at('修改时间');

            $grid->created_at('创建时间');

            $grid->model()->orderBy('id', 'desc'); // 排序规则
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(FactoryCode::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('name', '名称');

            $form->display('url', '链接');

            $form->image('code_img_base64', '二维码')->uniqueName();

            $form->display('updated_at', '修改时间');

            $form->display('created_at', '创建时间');

            $form->saving(function (Form $form) {
                // 保存前 解析二维码 生成 url 可行
                $qrcode = new QrReader(realpath($form->code_img_base64));
                $form->url = $qrcode->text();
            });

        });
    }
}
