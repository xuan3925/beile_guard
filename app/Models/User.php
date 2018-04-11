<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname', 'phone', 'age', 'city', 'password', 'md', 'is_our_users',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * 判断你模型中的数据是否是自己的
     * @author xueyu
     */
    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }

    /**
     * 守护地球活动
     * @author xueyu
     */
    public function guardianEarth()
    {
        return $this->hasOne(GuardianEarth::class, 'user_id');
    }

    /**
     * 用户成就
     * @author xueyu
     */
    public function guardianEarthUsersAchievement()
    {
        return $this->hasMany(GuardianEarthUsersAchievement::class, 'user_id');
    }

    /**
     * 登录日志
     * @author xueyu
     */
    public function usersLoginLog()
    {
        return $this->hasMany(UsersLoginLog::class, 'user_id');
    }
}
