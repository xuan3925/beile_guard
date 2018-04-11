<?php 
/**
 * 短信相关异常
 * @author xueyu
 */

namespace App\Service\Sms\Api;

use Exception;

class SmsException extends Exception
{
	
    /**
     * lang trans('auth.sms_max_time')
     * 每日最多发送几次
     */
    const MAX_TIME = 'auth.sms_max_time';

    /**
     * token验证失败
     */
    const TOKEN_FAILD = 'auth.sms_token_faild';

    /**
     * token发送失败
     */
    const TOKEN_SEND_FAILD = 'auth.sms_send_faild';

    /**
     * 模板异常
     */
    const TEMPLATE_FAILD = 'auth.sms_template_faild';
}