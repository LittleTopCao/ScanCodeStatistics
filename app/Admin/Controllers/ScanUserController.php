<?php

namespace App\Admin\Controllers;

use App\ScanUser;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

/**
 * 扫码用户
 * @package App\Admin\Controllers
 */
class ScanUserController extends Controller
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

            $content->header('扫码用户');
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

            $content->header('扫码用户');
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

            $content->header('扫码用户');
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
        return Admin::grid(ScanUser::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->open_id('OpenId');

            $grid->name('名称');

            $grid->nick_name('昵称');

//            $grid->avatar('头像');

            $grid->scan_number('未领取');

            $grid->scan_total('共扫码');

            $grid->scan_date('最新扫码');

            $grid->remark('备注');

            $grid->updated_at('修改时间');

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
        return Admin::form(ScanUser::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->number('scan_number', '未领取');

            $form->display('scan_total', '共扫码');

            $form->text('remark', '备注');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
