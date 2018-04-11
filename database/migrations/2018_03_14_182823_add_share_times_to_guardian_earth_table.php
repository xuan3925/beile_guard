<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShareTimesToGuardianEarthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guardian_earth', function (Blueprint $table) {
            $table->integer('share_times')->default(0)->after('guardian_exp')->comment('分享次数');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guardian_earth', function (Blueprint $table) {
            $table->dropColumn('share_times');
        });
    }
}
