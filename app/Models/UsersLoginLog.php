<?php
/**
 * 用户登录日志
 * @author xueyu
 */

namespace App\Models;

class UsersLoginLog extends Model
{
    const UPDATED_AT = null;
    
    protected $fillable = [
        'user_id', 'ip_address', 'login_date', 'created_at'
    ];
    
}
