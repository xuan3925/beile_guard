<?php 
/**
 * 通知短信
 * @author xueyu
 */

namespace App\Service\Sms;

trait SmsNotice
{
    
	public function aUserWithoutVideo($tel)
	{
		try {
            $content = $this->sms->getTemplate('no_video', ['days'=>'19']);
			return $this->sms->sendNotice($tel, $content);
        } catch (SmsException $e) {
            return $e->getMessage();
        }
	}

}
