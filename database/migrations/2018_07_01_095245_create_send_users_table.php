<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSendUsersTable extends Migration
{
    /**
     * 发放二维码
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->comment('二维码名称');
            $table->longText('code_img_base64')->nullable()->comment('二维码 图片: base64 编码');
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
        Schema::dropIfExists('send_users');
    }
}
