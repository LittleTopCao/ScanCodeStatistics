<?php

namespace App\Admin\Controllers;

use App\Code;

use App\FactoryCode;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

use QrCode;
use DB;

/**
 * 扫码二维码
 * @package App\Admin\Controllers
 */
class CodeController extends Controller
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

            $content->header('扫码二维码');
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

            $content->header('扫码二维码');
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

            $content->header('扫码二维码');
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
        return Admin::grid(Code::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->name('名称');

//            $grid->path('链接');

            $grid->column('今日扫码')->display(function () {

                $count = DB::select('SELECT count(*) FROM codes INNER JOIN scan_records ON codes.id = scan_records.code_id WHERE TO_DAYS(scan_records.created_at) = TO_DAYS(NOW()) AND codes.id = ?;', [$this->id]);

                return ((array)$count[0])['count(*)'];
            });

            $grid->column('共扫码')->display(function () {

                $count = DB::select('SELECT count(*) FROM codes INNER JOIN scan_records ON codes.id = scan_records.code_id WHERE codes.id = ?;', [$this->id]);

                return ((array)$count[0])['count(*)'];
            });

            $grid->column('二维码')->display(function () {

                $url = url('uploads/'.$this->path);
                $arr = explode('.',$url);
                $extension = array_pop($arr);
                $name = $this->name.'.'.$extension;

                return "<a target='_blank' href='".$url."' download='".$name."'>下载</>";

            });

            $grid->factory_code_id('厂家二维码')->display(function($factory_code_id) {
                return FactoryCode::find($factory_code_id)->name;
            });

//            $grid->updated_at('修改时间');

            $grid->created_at('创建时间');

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Code::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('name', '名称');

            $form->select('factory_code_id', '厂家二维码')->options(function ($id) {
                $factoryCode = FactoryCode::find($id);

                if ($factoryCode) {
                    return [$factoryCode->id => $factoryCode->name];
                }
            })->ajax('/admin/api/factory-codes');

            $form->image('path', '二维码, 创建时不需要输入, 自动生成')->uniqueName();

            $form->display('updated_at', '修改时间');

            $form->display('created_at', '创建时间');

            //保存后回调
            $form->saved(function (Form $form) {
                // 定义路径
                $name = md5(uniqid()).'.png';
                // 生成二维码
                QrCode::format('png')->size(256)->margin(0)->encoding('UTF-8')
                    ->generate(url('scan',$form->model()->id), public_path('uploads/images/'.$name));

                $form->model()->path = 'images/'.$name;
                $form->model()->save();
            });
        });
    }
}
