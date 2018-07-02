<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSendCodesTable extends Migration
{
    /**
     * 发放二维码
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->comment('二维码名称');
            $table->string('path')->nullable()->comment('二维码 图片; 存储在 public/upload/images 下 ');
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
        Schema::dropIfExists('send_codes');
    }
}
