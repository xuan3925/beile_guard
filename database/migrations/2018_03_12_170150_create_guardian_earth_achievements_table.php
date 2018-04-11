<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuardianEarthAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardian_earth_achievements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 10)->comment('成就名称');
            $table->tinyInteger('module')->default(0)->comment('触发类型');
            $table->integer('condition')->default(0)->comment('触发条件');
            $table->string('intro', 50)->comment('成就说明文字');
            $table->integer('add_exp')->comment('获赠经验值 暂仅触发类型是经验使用');
            $table->string('images_prefix', 50)->comment('图片前缀');
            $table->timestamps();
            $table->integer('sort')->default(0)->comment('排序');
            $table->comment = '守护地球成就表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guardian_earth_achievements');
    }
}
