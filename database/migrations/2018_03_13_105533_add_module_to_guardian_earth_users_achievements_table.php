<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModuleToGuardianEarthUsersAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guardian_earth_users_achievements', function (Blueprint $table) {
            $table->integer('achievement_module')->after('user_id')->comment('触发类型');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guardian_earth_users_achievements', function (Blueprint $table) {
            $table->dropColumn('achievement_module');
        });
    }
}
