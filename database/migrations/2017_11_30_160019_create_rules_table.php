<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 64)->comment('权限菜单名称');
            $table->string('href', 64)->nullable()->comment('链接url');
            $table->string('rule', 64)->nullable()->comment('控制器方法');
            $table->integer('pid')->default(0)->comment('父级id');
            $table->tinyInteger('check')->default(1)->comment('是否需要验证');
            $table->tinyInteger('status')->default(0)->comment('是否显示');
            $table->tinyInteger('level');
            $table->string('icon', 64)->nullable()->comment('图标');
            $table->smallInteger('sort')->comment('排序');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rules');
    }
}
