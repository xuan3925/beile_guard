<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname', 30)->comment('昵称');
            $table->string('phone', 20)->unique()->comment('手机');
            $table->integer('age')->default(0)->comment('年龄');
            $table->string('city', 30)->comment('城市');
            $table->char('password', 32);
            $table->char('md', 4)->comment('密码盐值');
            $table->rememberToken();
            $table->tinyInteger('is_our_users')->default('0')->comment('1-是贝乐学员 0-不是');
            $table->timestamps();
            $table->comment = '用户表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
