<?php
/**
 * 登录监听
 * @author xueyu
 */

namespace App\Listeners;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UsersLoginLog;
use App\Models\GuardianEarthAchievement;
use App\Models\GuardianEarthUsersAchievement;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\AddGuardianExpEvents;

class LoginListener
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
    public function handle(Login $event)
    {
        $user = $event->user;

        $this->addLoginLogs($user->id);
        
        if (!$this->hasLoginAchievement($user) && $this->isLoginSevenDays($user))
        {
            $this->addLoginAchievement($user->id);
            event(new AddGuardianExpEvents($user->id, AddGuardianExpEvents::LOGIN_SEVEN_DAYS));
        }
    }

    /**
     * 记录登录日志
     * @author xueyu
     */
    private function addLoginLogs($user_id)
    {
        $data = [
            'user_id'    => $user_id,
            'ip_address' => ip(),
            'login_date' => today(),
        ];
        UsersLoginLog::create($data);
    }

    /**
     * 查看用户是否连续登录7天
     * @author xueyu
     * @param $user App\Models\User
     */
    private function isLoginSevenDays(User $user)
    {
        $logs = $user->usersLoginLog()
                     ->select('user_id', 'login_date')
                     ->where('created_at', '>', last_seven_days())
                     ->groupBy('login_date')
                     ->orderBy('id', 'desc')
                     ->get();
        return $logs->count() >= 7;
    }

    /**
     * 记录登录成就
     * @author xueyu
     */
    private function addLoginAchievement($user_id)
    {
        $data = [
            'user_id'            => $user_id,
            'achievement_module' => GuardianEarthAchievement::LOGIN,
            'achievement_id'     => GuardianEarthAchievement::LOGIN_ID,
        ];
        GuardianEarthUsersAchievement::create($data);
    }

    /**
     * 用户是否有登录的成就
     * @author xueyu
     */
    private function hasLoginAchievement(User $user)
    {
        $response = $user->guardianEarthUsersAchievement()
                         ->where('achievement_module', GuardianEarthAchievement::LOGIN)
                         ->first();
        return (bool) $response;
    }
}
