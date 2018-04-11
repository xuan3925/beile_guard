<?php
/**
 * 守护地球活动 用户经验日志
 * @author xueyu
 */

namespace App\Models;

class GuardianEarthUsersExpLog extends Model
{
	const UPDATED_AT = null;

    protected $fillable = [
        'user_id', 'guardian_exp', 'source', 'intro'
    ];
}
