<?php

/**
 * 获取IP地址
 * @author xueyu
 */
function ip()
{
    return request()->getClientIp();
}

/**
 * cdn地址
 * @author xueyu
 */
function cdn_domain($url)
{
	return config('cdn.cdn_domain') . $url;
}

/**
 * css/js 资源地址
 * @author xueyu
 */
function resources_domain($url)
{
	if (app()->environment('production'))
		return config('cdn.cdn_resources_domain') . 'guard/' . $url . '?v=' . config('cdn.cdn_resources_version');
	else
		return config('app.url') . 'resources/' . $url . '?v=' . config('cdn.cdn_resources_version');;
}

/**
 * 用户密码
 * @author xueyu
 * @param  $password 密码明文
 * @param  $md       盐值
 * @return  md5 string
 */
function make_password($password, $md)
{
	return md5(md5($password).$md);
}
	
/**
 * 七天前的日期
 * @author xueyu
 * @return Carbon\Carbon
 */
function last_seven_days()
{
	return Carbon\Carbon::today()->subDays(6);
}

/**
 * 活动是否已过期
 * @author xueyu
 * @return boolean [description]
 */
function is_activity_stop()
{
	$stop_date = '2018-04-08';
	$stop = Carbon\Carbon::parse($stop_date);
	$today = Carbon\Carbon::today();
	return $stop->lt($today);
}