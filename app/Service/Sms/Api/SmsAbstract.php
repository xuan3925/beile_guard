<?php 
/**
 * 短信 
 * @author xueyu
 */

namespace App\Service\Sms\Api;

use DB;
use App\Service\Sms\Models\SmsLog;

abstract class SmsAbstract
{
	/**
	 * bool 是否记录日志
	 */
	protected $record;

	/**
	 * 短信模板
	 */
	protected $template;
	
	public function __construct()
	{
		$config = include(__DIR__ . DIRECTORY_SEPARATOR . 'config.php');
		$this->record 	= $config['record'];
		$this->template = $config['template'];
	}

	/**
	 * 发送验证类短信
	 * @author xueyu
	 * @param  [type] $tel      [手机]
	 * @param  [type] $content  [发送内容]
	 */
	abstract public function sendValidation($phone, $content);

	/**
	 * 发送通知类短信
	 * @author xueyu
	 * @param  [type] $tel      [手机]
	 * @param  [type] $content  [发送内容]
	 */
	abstract public function sendNotice($phone, $content);

	/**
	 * 记录日志
	 * @author xueyu
	 * @param  [type] $phone    [description]
	 * @param  [type] $content  [description]
	 * @param  [type] $response [description]
	 * @param  [type] $status   [description]
	 * @return [type]           [description]
	 */
	public function recordLogs($phone, $content, $response, $status)
	{
		if ($this->record)
		{
			$data = compact('phone', 'content', 'response', 'status');
			SmsLog::create($data);
		}
	}

	/**
	 * 获取模板
	 * @author xueyu
	 * @param $key  模板的key
	 * @param $data 模板的参数
	 */
	public function getTemplate($key, $data=array())
	{
		$template = $this->template;
		if (empty($template[$key]))
			throw new SmsException(SmsException::TEMPLATE_FAILD, 1);
		
		try {
			return vsprintf($template[$key], array_values($data));
		} catch (\Exception $e) {
			throw new SmsException(SmsException::TEMPLATE_FAILD, 2);
		}
	}
}