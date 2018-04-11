<?php
/**
 * Chanzor短信api
 * @author Xueyu
 */

namespace App\Service\Sms\Api\Chanzor;

use App\Service\Sms\Api\SmsAbstract;
use App\Service\Sms\Api\SmsException;

class Api extends SmsAbstract
{
	private $server;
	private $account;
	private $password;
	private $sign;

	public function __construct() 
	{
		parent::__construct();
		$this->server 	= 'http://api.chanzor.com';
		$this->account  = '98ab62';
		$this->password = strtoupper(md5("8haykuflj7"));  // App Key  密码 需要 md5 32位大写
		$this->sign   	= '【贝乐学科英语】';
	}

	/**
	 * 验证类短信发送
	 * @author xueyu
	 * @param $phone 手机号
	 * @param $content 发送内容
	 * @throws 发送失败 抛出异常 SmsException
	 */	
	public function sendValidation($phone, $content) 
	{
		$phone 	   = trim($phone);
		$content   = trim($content);
		$sendTime  = $extno = ""; // 定时发送, 扩展子号 暂时用不上
		$post_data = "account=".$this->account."&password=".$this->password."&mobile=".$phone."&content=".rawurlencode($content.$this->sign)."&sendTime=".$sendTime."&extno=".$extno;
		$response  = $this->post($post_data, $this->server.'/send');

		// 发送状态
		$res = json_decode($response, true);
		$status = empty($res) || $res['status'] !== 0 ? false : true;

		// 记录日志
		$this->recordLogs($phone, $content, $response, $status);

		if (false === $status)
			throw new SmsException(SmsException::TOKEN_SEND_FAILD, 1);

		return $res;
	}

	/**
	 * 验证类短信发送
	 * @author xueyu
	 * @param $phone 手机号
	 * @param $content 发送内容
	 * @return bool
	 */	
	public function sendNotice($phone, $content) 
	{
		$phone 	   = trim($phone);
		$content   = trim($content);
		$sendTime  = $extno = ""; // 定时发送, 扩展子号 暂时用不上
		$post_data = "account=".$this->account."&password=".$this->password."&mobile=".$phone."&content=".rawurlencode($content.$this->sign)."&sendTime=".$sendTime."&extno=".$extno;
		$response  = $this->post($post_data, $this->server.'/send');

		// 发送状态
		$res = json_decode($response, true);
		$status = empty($res) || $res['status'] !== 0 ? false : true;

		// 记录日志
		$this->recordLogs($phone, $content, $response, $status);

		return $status;
	}
	
	/**
	 * 发送curl请求
	 * @author sun
	 */
	private function post($post_data, $url) 
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}