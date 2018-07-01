<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScanRecordsTable extends Migration
{
    /**
     * 扫码记录
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scan_records', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('scan_user_id')->comment('微信用户 id');
            $table->foreign('scan_user_id')->references('id')->on('scan_users');

            $table->unsignedInteger('code_id')->comment('二维码 id');
            $table->foreign('code_id')->references('id')->on('codes');
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
        Schema::dropIfExists('scan_records');
    }
}
