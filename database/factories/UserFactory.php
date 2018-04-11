<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
	$citys = ['北京', '上海', '深圳', '其他'];
	$md = str_random(4);
	$password = str_random(8);
    return [
        'nickname' => 'Test-' . $faker->name,
        'phone' => '13'.mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9),
        'age' => mt_rand(1,12),
        'city' => $citys[mt_rand(0,3)],
        'password' => make_password($password, $md),
        'md' => $md, 
        'remember_token' => str_random(10),
        'is_our_users' => mt_rand(0, 1),
    ];
});

$factory->define(App\Models\GuardianEarth::class, function (Faker $faker) {
    return [
        'subject' => '',
        'content' => '',
        'video'   => '',
        'guardian_exp' => mt_rand(100, 199) * 100,
        'share_times' => 0,
    ];
});