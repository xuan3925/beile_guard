<?php 
/**
 * 短信入口
 * @author xueyu
 */

namespace App\Service\Sms;

use App\Service\Sms\Api\SmsFactory;

class Sms
{
    use SmsToken, SmsNotice;
    
    // 模板类型
    const REGISTER = 1; // 注册
    const PASSWORD_RESET = 2; // 找回密码

    // 短信失效时间(分钟)
    const EXPIRED = 10;

    /**
     * 实例化自己的对象
     */
    private $self;

    /**
     * 短信api
     */
    private $sms;

    public function __construct()
    {
        $this->sms = SmsFactory::create();
    }

    /**
     * 对外提供静态方法实例化自身
     * @author xueyu
     */
    public static function broker()
    {
        if (!empty(self::$self))
            return self::$self;

        return new self();
    }

}
