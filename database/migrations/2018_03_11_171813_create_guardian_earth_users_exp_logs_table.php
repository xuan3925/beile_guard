<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuardianEarthUsersExpLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardian_earth_users_exp_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户id');
            $table->integer('guardian_exp')->default('0')->comment('新增的经验值');
            $table->integer('source')->comment('获得经验值的来源 见AddGuardianExpEvents');
            $table->string('intro')->comment('获得经验值的说明');
            $table->timestamp('created_at')->nullable();
            $table->comment = '守护地球活动经验日志表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guardian_earth_users_exp_logs');
    }
}
