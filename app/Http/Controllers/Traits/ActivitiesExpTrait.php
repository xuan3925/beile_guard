<?php

namespace App\Http\Controllers\Traits;

use Auth;
use Illuminate\Validation\ValidationException;

trait ActivitiesExpTrait
{
    /**
     * 是否是自己的活动
     * @author xueyu
     * @param  $activity
     */
    private function isOwns($activity)
    {
        return Auth::check() && Auth::user()->owns($activity);
    }

    /**
     * [checkCookie description]
     * @author xueyu
     * @param  $cookie  客户端cookie
     * @param  $key     cookie的key
     * @param  $is_owns 是否是自己的活动
     */
    private function checkCookie($cookie, $key, $is_owns)
    {
        if (!$is_owns)
            return empty($cookie) || $cookie != $this->today();
        else
            return empty($cookie) || $cookie < $this->now();
    }

    /**
     * [setCookie description]
     * @author xueyu
     * @param  string $key       cookie的key
     * @param  bool   $is_owns   是否是自己的活动
     */
    private function setCookie($key, $is_owns)
    {
        if ($is_owns)
            return cookie($key, $this->nextHourToNow(), 60);
        else
            return cookie($key, $this->today(), 24 * 60);
    }

    /**
     * [key description]
     * @author xueyu
     * @param  bool   $is_owns 是否是自己的活动
     * @param  int    $id      活动id/用户id
     */
    private function getKeys($is_owns, $id)
    {
        if ($is_owns)
            return 'guardian_earth_self_'.$id;
        else
            return 'guardian_earth_'.$id;
    }

    private function today()
    {
        return strtotime(date('Y-m-d'));
    }

    private function nextHourToNow()
    {
        return $this->now() + 3600;
    }

    private function now()
    {
        return strtotime(date('Y-m-d H:i:s'));
    }

    /**
     * 自己距离下次捡垃圾的时间
     * @author xueyu
     * @return [type] [description]
     */
    private function secondToNextPickUp($time)
    {
        return $time - $this->now();
    }

    /**
     * [sendCheckErrorResponse description]
     * @author xueyu
     * @param  [type] $time    cookie 存储的 用户是自己下次可以捡垃圾的时间
     */
    private function sendCheckErrorResponse($is_owns, $time)
    {
        if ($is_owns)
            $msg = ['seconds' => $this->secondToNextPickUp($time)];
        else
            $msg = ['is_owns_error' => '每日只可为TA守护一次哦'];

        throw ValidationException::withMessages($msg);
    }

}
