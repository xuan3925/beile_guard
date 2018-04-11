<?php
/**
 * @author xueyu
 * php artisan db:seed --class=UsersTableSeeder
 */

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 100)->create()->each(function($u) {
            $u->guardianEarth()->save(factory(App\Models\GuardianEarth::class)->make());
        });
    }
}
