<?php

namespace App\Admin\Controllers;

use App\SendCode;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

use QrCode;
use DB;

/**
 * 发放二维码
 * @package App\Admin\Controllers
 */
class SendCodeController extends Controller
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

            $content->header('发放二维码');
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

            $content->header('发放二维码');
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

            $content->header('发放二维码');
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
        return Admin::grid(SendCode::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->name('名称');

            // 二维码链接

            $grid->column('今日发放')->display(function () {

                $count = DB::select('SELECT count(send_records.number) FROM send_codes INNER JOIN send_records ON send_codes.id = send_records.send_code_id WHERE TO_DAYS(send_records.created_at) = TO_DAYS(NOW()) AND send_codes.id = ?;', [$this->id]);

                return ((array)$count[0])['count(send_records.number)'];
            });

            $grid->column('共发放')->display(function () {

                $count = DB::select('SELECT count(send_records.number) FROM send_codes INNER JOIN send_records ON send_codes.id = send_records.send_code_id WHERE send_codes.id = ?;', [$this->id]);

                return ((array)$count[0])['count(send_records.number)'];
            });

            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(SendCode::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('name', '名称');

            $form->display('updated_at', '修改时间');

            $form->display('created_at', '创建时间');


            //保存后回调
            $form->saved(function (Form $form) {
                // 定义路径
                $name = md5(uniqid()) . '.png';
                // 生成二维码
                QrCode::format('png')->size(256)->margin(0)->encoding('UTF-8')
                    ->generate(url('send', $form->model()->id), public_path('uploads/images/' . $name));

                $form->model()->code_img_base64 = 'images/' . $name;
                $form->model()->save();
            });
        });
    }
}
