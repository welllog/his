<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 128)->comment('用户名');
            $table->string('password', 255)->comment('密码');
            $table->char('tel', 11)->comment('手机号');
            $table->string('email', 128)->nullable()->comment('邮箱');
            $table->string('remember_token', 100)->nullable()->comment('登录令牌');
            $table->tinyInteger('status')->default(1)->comment('账号状态');
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
        Schema::dropIfExists('admins');
    }
}
