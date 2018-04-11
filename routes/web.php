<?php

Route::get('/', 'IndexController@index')->name('index');

Route::get('home', 'HomeController@index')->name('home');

// 活动介绍 排行榜 排行榜详情
Route::resource('activities', 'ActivitiesController', [
	'only'=>['index', 'create', 'store']
]);
Route::resource('activities/ranking', 'ActivitiesRankingController', [
	'only'=>['index', 'show'], 
	'names'=>['index'=>'activities.ranking.index', 'show'=>'activities.ranking.show']
]);

// 捡垃圾
Route::get('activities/guard/{id}', 'ActivitiesGuardController@showGuardView')->name('activities.guard.show');
Route::post('activities/guard/{id}/add', 'ActivitiesGuardController@addGuardExp')->name('activities.guard.addexp');
Route::post('activities/guard/{id}/check', 'ActivitiesGuardController@check')->name('activities.guard.check');
Route::post('activities/share', 'ActivitiesController@share')->name('activities.share');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Login Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/phone', 'Auth\ForgotPasswordController@sendResetTokenPhone')->name('password.phone');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');