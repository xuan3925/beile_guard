<?php

namespace App\Events;

use App\Models\GuardianEarth;
use Illuminate\Queue\SerializesModels;

class AddGuardianExpEvents
{
    use SerializesModels;

    const REGISTER = 1; // 注册
    const SHARE = 2; // 分享 
    const FRIENDS_GUARD = 3; // 好友捡垃圾 
    const SELF_GUARD = 4; // 自己捡垃圾 
    const LOGIN_SEVEN_DAYS = 5; // 连续登录七天
    const SHARE_TEN_TIMES = 6; // 分享十次
    const EXP_TRIGGER = 7; // 经验值达到一定数值触发

    /**
     * App\Models\GuardianEarth
     * @var Model
     */
    public $activity;

    /**
     * 触发的事件类型，见上方常量
     * @var string
     */
    public $type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($activity_id, $type)
    {
        $this->activity = GuardianEarth::findOrFail($activity_id);

        $this->type = $type;
    }

}
