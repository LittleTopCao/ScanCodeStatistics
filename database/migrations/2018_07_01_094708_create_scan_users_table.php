<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScanUsersTable extends Migration
{
    /**
     * 微信用户
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scan_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('open_id')->unique()->comment('openid 用户唯一标示');
            $table->string('name')->nullable()->comment('微信 name');
            $table->string('nick_name')->nullable()->comment('微信 nick_name');
            $table->string('avatar')->nullable()->comment('头像 url');
            $table->unsignedInteger('scan_number')->default(0)->comment('待领取 扫码数');
            $table->unsignedInteger('scan_total')->default(0)->comment('总共扫码数');
            $table->timestamp('scan_date')->nullable()->comment('最新扫码时间, 一天只记录最早');
            $table->string('remark')->default('')->comment('用户 备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scan_users');
    }
}
