<?php
/**
 * 分享监听
 * @author xueyu
 */

namespace App\Listeners;

use App\Models\User;
use App\Events\GuardianShareEvents;
use App\Events\AddGuardianExpEvents;
use App\Models\GuardianEarthAchievement;
use App\Models\GuardianEarthUsersAchievement;

class GuardianShareListener
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
    public function handle(GuardianShareEvents $event)
    {
        $activity = $event->activity;
        $user_id  = $activity->user_id;

        // 增加记录一次
        $activity->increment('share_times');

        event(new AddGuardianExpEvents($user_id, AddGuardianExpEvents::SHARE));

        if ($activity->share_times >= 10 && !$this->hasShareAchievement($user_id))
        {
            $this->addShareAchievement($user_id);
            event(new AddGuardianExpEvents($user_id, AddGuardianExpEvents::SHARE_TEN_TIMES));
        }
    }

    /**
     * 用户是否有分享的成就
     * @author xueyu
     */
    private function hasShareAchievement($user_id)
    {
        $user = User::find($user_id);
        $response = $user->guardianEarthUsersAchievement()
                         ->where('achievement_module', GuardianEarthAchievement::SHARE)
                         ->first();
        return (bool) $response;
    }

    /**
     * 记录分享成就
     * @author xueyu
     */
    private function addShareAchievement($user_id)
    {
        $data = [
            'user_id'            => $user_id,
            'achievement_module' => GuardianEarthAchievement::SHARE,
            'achievement_id'     => GuardianEarthAchievement::SHARE_ID,
        ];
        GuardianEarthUsersAchievement::create($data);
    }

}
