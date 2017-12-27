<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOplogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oplog', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default(1)->comment('日志类型');
            $table->string('title', 64)->default('')->comment('日志标题');
            $table->string('created_by', 64)->default('')->comment('创建者');
            $table->bigInteger('ip')->default(0)->comment('ip地址');
            $table->string('uri', 64)->default('')->comment('请求url');
            $table->string('method', 64)->default('')->comment('请求方式');
            $table->string('param', 255)->default('')->comment('请求参数');
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
        Schema::dropIfExists('oplog');
    }
}
