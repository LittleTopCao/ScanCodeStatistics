<?php

namespace App\Admin\Controllers;

use App\ScanRecord;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ScanRecordController extends Controller
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

            $content->header('扫码记录');
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

            $content->header('扫码记录');
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

            $content->header('扫码记录');
            $content->description('新建');

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
        return Admin::grid(ScanRecord::class, function (Grid $grid) {

            $grid->scanUser()->name('微信名');
            $grid->scanUser()->avatar('头像')->image('http://wechat.shitouboy.com', 50, 50);
            $grid->created_at('扫码时间');

            $grid->model()->orderBy('id', 'desc'); // 排序规则

            $grid->filter(function($filter){ // 查询过滤
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                $filter->where(function ($query) {
                    $query->whereHas('scanUser', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%");
//                        ->orWhere('email', 'like', "%{$this->input}%")
                    });
                }, '微信名');
            });

            $grid->disableCreateButton(); // 禁用创建按钮
            $grid->disableExport(); // 禁用导出数据
            $grid->disableRowSelector(); // 禁用行选择
            $grid->disableActions(); // 禁用行操作列
            $grid->actions(function ($actions) { // 禁用操作按钮
                $actions->disableDelete();
                $actions->disableEdit();
            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ScanRecord::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
