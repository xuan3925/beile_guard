<?php
/**
 * 用户
 * @author xueyu
 */

namespace App\Repositories;

use App\Models\User;
use App\Models\GuardianEarthAchievement;

class UserRepository
{

    /**
     * [byId description]
     * @author xueyu
     * @return App\Models\User
     */
    public function byId($id)
    {
        $obj = User::findOrFail($id);
        return $obj;
    }

    /**
     * 用户获得的成就
     * @author xueyu
     * @param  $user_id 用户id
     */
    public function guardianEarthAachievements($user_id)
    {
        $achs = GuardianEarthAchievement::orderBy('sort', 'asc')->get();
        $user_ach = User::find($user_id)->guardianEarthUsersAchievement->pluck('achievement_id');
        $achs = $achs->map(function($ach) use ($user_ach){
            if ($ach->module == GuardianEarthAchievement::JOIN) 
                $ach->status = 1;
            elseif (false === $user_ach->search($ach->id))
                $ach->status = 0;
            else
                $ach->status = 1;
            $ach->intro = str_replace('{num}', $ach->condition, $ach->intro);
            unset($ach->created_at, $ach->updated_at, $ach->condition, $ach->sort);
            return $ach;
        });
        return $achs;
    }


}