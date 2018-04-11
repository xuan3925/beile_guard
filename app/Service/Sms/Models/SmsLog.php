<?php
/**
 * 短信日志
 * @author xueyu
 */

namespace App\Service\Sms\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
	const UPDATED_AT = null;

    protected $fillable = [
        'phone', 'content', 'response', 'status'
    ];
}
