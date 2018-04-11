<?php
/**
 * 注册监听
 * @author xueyu
 */

namespace App\Listeners;

use App\Events\AddGuardianExpEvents;
use App\Models\GuardianEarth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisteredListener
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
    public function handle(Registered $event)
    {
        $user = $event->user;
        $this->addActivity($user->id);
        // 增加经验
        event(new AddGuardianExpEvents($user->id, AddGuardianExpEvents::REGISTER));
    }

    /**
     * 自动加入活动
     * @author xueyu
     */
    private function addActivity($user_id)
    {
        $data = [
            'user_id' => $user_id,
            'subject' => '',
            'content' => '',
            'video'   => '',
        ];
        GuardianEarth::create($data);
    }
}
