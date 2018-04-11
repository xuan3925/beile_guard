<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone', 20)->index()->comment('手机');
            $table->string('content')->comment('短信内容');
            $table->string('response')->comment('短信平台返回内容');
            $table->timestamp('created_at')->nullable();
            $table->tinyInteger('status')->comment('短信发送状态 1-成功 0-失败');
            $table->comment = '短信历史记录表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_logs');
    }
}
