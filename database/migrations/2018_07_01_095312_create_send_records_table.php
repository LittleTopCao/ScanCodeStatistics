<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSendRecordsTable extends Migration
{
    /**
     * 领取记录表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('scan_user_id')->comment('微信用户 id');
            $table->foreign('scan_user_id')->references('id')->on('scan_users');

            $table->unsignedInteger('number')->comment('领取数量');

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
        Schema::dropIfExists('send_records');
    }
}
