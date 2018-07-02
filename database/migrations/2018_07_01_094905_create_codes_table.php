<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodesTable extends Migration
{
    /**
     * 自己生成的二维码
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->comment('二维码名称');
            $table->string('path')->nullable()->comment('二维码 图片: 存储在 public/uploads/images 下');

            $table->unsignedInteger('factory_code_id')->comment('厂家二维码 id');
            $table->foreign('factory_code_id')->references('id')->on('factory_codes');

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
        Schema::dropIfExists('codes');
    }
}
