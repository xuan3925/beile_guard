<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuardianEarth;
use App\Events\AddGuardianExpEvents;
use App\Repositories\GuardianEarthRepository;
use App\Http\Controllers\Traits\ActivitiesExpTrait;

class ActivitiesGuardController extends Controller
{
    use ActivitiesExpTrait;

    protected $guardian_earth;

    public function __construct(GuardianEarthRepository $guardian_earth)
    {
        $this->guardian_earth = $guardian_earth;
    }

    /**
     * 捡垃圾页面
     * @author xueyu
     * @param  $id 守护地球活动id/用户id
     */
    public function showGuardView(Request $request, $id)
    {
        $activity = $this->guardian_earth->byId($id);
        $is_owns = $this->isOwns($activity);
        $key = $this->getKeys($is_owns, $id);
        $condition = $this->checkCookie(
            $request->cookie($key), $key, $is_owns
        );
        return view('activities.exp', compact('activity', 'condition'));
    }

    /**
     * 捡垃圾 加经验
     * @author xueyu
     */
    public function addGuardExp(Request $request, $id)
    {
        $activity = $this->guardian_earth->byId($id);
        $is_owns = $this->isOwns($activity);
        $cookie = $this->setCookie(
            $this->getKeys($is_owns, $id), $is_owns
        );
        // 增加经验值
        $type = $is_owns ? AddGuardianExpEvents::SELF_GUARD : AddGuardianExpEvents::FRIENDS_GUARD;
        event(new AddGuardianExpEvents($id, $type));
        return response([])->cookie($cookie);
    }

    /**
     * 验证捡垃圾剩余时间
     * @author xueyu
     */
    public function check(Request $request, $id)
    {
        $activity = $this->guardian_earth->byId($id);
        $is_owns = $this->isOwns($activity);
        $key = $this->getKeys($is_owns, $id);
        $cookie = $request->cookie($key);
        $condition = $this->checkCookie(
            $cookie, $key, $is_owns
        );
        if (false === $condition)
            return $this->sendCheckErrorResponse($is_owns, $cookie);    

        return [];
    }
}
