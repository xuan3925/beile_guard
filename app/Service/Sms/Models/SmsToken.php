<?php
/**
 * 短信验证码
 * @author xueyu
 */

namespace App\Service\Sms\Models;

use Carbon\Carbon;
use App\Service\Sms\Api\SmsException;
use Illuminate\Database\Eloquent\Model;

class SmsToken extends Model
{
    protected $fillable = [
        'type', 'phone', 'token', 'expired_at', 'used_at'
    ];

    /**
     * 使用token
     * @author xueyu
     */
    public function useToken($id)
    {
        return $this->where('id', $id)->update(['used_at'=>now()]);;
    }

    /**
     * 验证token是否有效
     * @author xueyu
     */
    public function checkToken($phone, $type, $token)
    {
        $data = $this->where(compact('phone', 'type'))->orderBy('id', 'desc')->first();
        $expired_at = Carbon::createFromFormat('Y-m-d H:i:s', $data->expired_at);
        if (empty($data) || !empty($data->used_at) || now()->gte($expired_at) || $data->token != $token)
            throw new SmsException(SmsException::TOKEN_FAILD, 1);

        return $data->id;
    }

    /**
     * 查看手机今日发送次数
     * @author xueyu
     */
    public function sendTimesToday($phone)
    {
        return $this->where('phone', $phone)
                    ->whereBetween('created_at', [today(), today()->addDays(1)])
                    ->count();
    }
}
