<?php
/**
 * 守护地球活动 用户成就
 * @author xueyu
 */

namespace App\Models;

class GuardianEarthUsersAchievement extends Model
{
	const UPDATED_AT = null;
	
    protected $fillable = [
        'user_id', 'achievement_module', 'achievement_id',
    ];
}
