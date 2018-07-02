<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactoryCodesTable extends Migration
{
    /**
     * 厂家二维码
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factory_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->comment('二维码名称');
            $table->string('url')->nullable()->comment('二维码 url');
            $table->string('path')->nullable()->comment('二维码 图片, 存储在 public/uploads/images');
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
        Schema::dropIfExists('factory_codes');
    }
}
