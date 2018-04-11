<?php 
/**
 * 验证码短信 
 * @author ning
 */

namespace App\Service\Sms;

use Exception;
use App\Service\Sms\Api\SmsException;
use App\Service\Sms\Models\SmsToken as SmsTokenModel;

trait SmsToken
{
    /**
     * 发送重置密码的验证码
     * @author xueyu
     * @param  [type] $phone [description]
     * @return [type]        [description]
     */
    public function sendResetToken($phone)
    {
        try {
            // 每天最多发送5次验证码
            $this->maxSendFiveTimes($phone);

            $token = rand(1111, 9999);
            $content = $this->sms->getTemplate('password_reset', compact('token'));
            $data = array(
                'type'          => self::PASSWORD_RESET,
                'phone'         => $phone,
                'token'         => $token,
                'expired_at'    => now()->addMinutes(self::EXPIRED),
            );
            $token = SmsTokenModel::create($data);
                
            // 发送短信验证码
            $this->sms->sendValidation($phone, $content);
            
            return true;
        } catch (SmsException $e) {
            return $e->getMessage();
        }
    }

    /**
     * 验证验证码是否有效
     * @author xueyu
     * @param string $phone 手机号
     * @param int    $type  见头部常量
     * @param int    $token 验证码
     * @return  数据库记录的id
     */
    public function checkResetToken($phone, $token)
    {
        try {
            $type = self::PASSWORD_RESET;
            return with(new SmsTokenModel)->checkToken($phone, $type, $token);
        } catch (SmsException $e) {
            return $e->getMessage();
        }
    }

    /**
     * 标记验证码已使用
     * @author xueyu
     */
    public function useToken($id)
    {
        return with(new SmsTokenModel)->useToken($id);
    }

    /**
     * 每天最多只能发送5次验证码
     * @author xueyu
     */
    private function maxSendFiveTimes($phone)
    {
        $count = with(new SmsTokenModel)->sendTimesToday($phone);
        if ($count > 5)
            throw new SmsException(SmsException::MAX_TIME, 1);
    }

}
