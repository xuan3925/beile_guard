<?php 
/**
 * 短信 
 * @author xueyu
 */

namespace App\Service\Sms\Api;

use App\Service\Sms\Api\Chanzor\Api;

class SmsFactory
{

	private static $obj;

	public static function create()
	{
		if (!empty(self::$obj))
			return self::$obj;

		return new Api;
	} 
	
}