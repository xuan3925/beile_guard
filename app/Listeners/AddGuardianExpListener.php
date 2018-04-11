<?php
/**
 * 增加经验监听
 * @author xueyu
 */

namespace App\Listeners;

use App\Events\AddGuardianExpEvents;
use App\Models\User;
use App\Models\GuardianEarth;
use App\Models\GuardianEarthUsersExpLog;
use App\Models\GuardianEarthAchievement;
use App\Models\GuardianEarthUsersAchievement;

class AddGuardianExpListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Gold  $event
     * @return void
     */
    public function handle(AddGuardianExpEvents $event)
    {
        $exp_detail = $this->getExp($event->type);
        $this->addExpLog($event->activity, $exp_detail['exp'], $event->type, $exp_detail['intro']);
        $this->addAchievements(
            $this->addExp($event->activity, $exp_detail['exp'])
        );
    }

    /**
     * 增加经验相关称号
     * @author xueyu
     * @param  $activity App\Models\GuardianEarth
     */
    private function addAchievements($activity)
    {
        $user_ach = User::find($activity->user_id)->guardianEarthUsersAchievement->pluck('achievement_id');
        $ach = GuardianEarthAchievement::where('module', GuardianEarthAchievement::EXP)->get();
        foreach ($ach as $k => $v) 
        {
            if (false === $user_ach->search($v->id))
            {
                if ($activity->guardian_exp >= $v->condition)
                {
                    $this->addAchievement($activity->user_id, $v->module, $v->id);
                    // 触发增加经验
                    if ($v->add_exp > 0)
                    {
                        $this->addExp($activity , $v->add_exp);
                        $this->addExpLog($activity , $v->add_exp, AddGuardianExpEvents::EXP_TRIGGER, '经验累积达到'.$v->condition);
                    }
                }
            }
        }
    }

    /**
     * 增加称号
     * @author xueyu
     */
    private function addAchievement($user_id, $achievement_module, $achievement_id)
    {
        $data = compact('user_id', 'achievement_module', 'achievement_id');
        GuardianEarthUsersAchievement::create($data);
    }

    /**
     * [addExp description]
     * @author xueyu
     * @param  $activity App\Models\GuardianEarth
     * @param  $exp      增加的经验值
     * @param  $intro    说明文字
     */
    private function addExp($activity, $exp)
    {
        $activity->increment('guardian_exp', $exp);
        return $activity;
    }

    /**
     * [addExpLog description]
     * @author xueyu
     * @param  $activity App\Models\GuardianEarth
     * @param  $exp      增加的经验值
     * @param  $source   经验来源 AddGuardianExpEvents CONST
     * @param  $intro    说明文字
     */
    private function addExpLog($activity, $exp, $source, $intro)
    {
        $data = [
            'user_id' => $activity->user_id,
            'source'  => $source,
            'intro'   => $intro,
            'guardian_exp' => $exp,
        ];
        GuardianEarthUsersExpLog::create($data);
    }

    /**
     * 获取增加的经验和说明文字
     * @author xueyu
     * @param  $type AddGuardianExpEvents CONST
     */
    private function getExp($type)
    {
        switch ($type) 
        {
            case AddGuardianExpEvents::REGISTER:
                $exp   = 10000;
                $intro = '注册成功';
                break;

            case AddGuardianExpEvents::SHARE:
                $exp   = 233;
                $intro = '分享成功';
                break;

            case AddGuardianExpEvents::FRIENDS_GUARD:
                $exp   = 1000;
                $intro = '好友帮助拾取垃圾';
                break;

            case AddGuardianExpEvents::SELF_GUARD:
                $exp   = 1000;
                $intro = '拾取自己的垃圾';
                break;

            case AddGuardianExpEvents::LOGIN_SEVEN_DAYS:
                $exp   = 666;
                $intro = '连续登陆7天';
                break;

            case AddGuardianExpEvents::SHARE_TEN_TIMES:
                $exp   = 6666;
                $intro = '分享达到10次';
                break;
        }
        return compact('exp', 'intro');
    }
}
