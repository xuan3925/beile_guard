<?php
/**
 * 守护地球活动
 * @author xueyu
 */

namespace App\Models;

class GuardianEarth extends Model
{
	protected $table = 'guardian_earth';
	protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id', 'subject', 'content', 'video', 'guardian_exp'
    ];

    /**
     * 用户表
     * @author xueyu
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
