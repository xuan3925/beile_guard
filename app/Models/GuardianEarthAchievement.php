<?php
/**
 * 守护地球活动 成就
 * @author xueyu
 */

namespace App\Models;

class GuardianEarthAchievement extends Model
{
    protected $fillable = [
        'name', 'module', 'condition', 'intro', 'add_exp', 'images_prefix', 'sort',
    ];

    // 成就类型
    const JOIN = 1; // 参加活动
    const EXP = 2; // 获得经验
    const LOGIN = 3; // 登录
    const SHARE = 4; // 分享

    // 预定义成就id
    const LOGIN_ID = 3;
    const SHARE_ID = 4;
}
