<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuardianEarthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardian_earth', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('subject', 20)->index()->comment('主题');
            $table->string('content', 255)->comment('内容');
            $table->string('video', 255)->comment('视频');
            $table->integer('guardian_exp')->default('0')->comment('守护经验值');
            $table->timestamps();
            $table->comment = '守护地球活动表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guardian_earth');
    }
}
