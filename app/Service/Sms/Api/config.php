<?php 
/**
 * 手机短信模板
 * @author xueyu
 */

return [
	
	/**
	 * 是否记录短信日志
	 */
	'record' => true,

	/**
	 * 短信模板
	 * 参数要按照顺序传参 不是key=>value 匹配
	 */
	'template' => [
		/**
		 * 找回密码
		 * @param string token 验证码
		 */
		'password_reset' => '验证码为：%s，请在10分钟内输入。',

		/**
		 * 没有视频的用户发个短信
		 * @param string days 天数
		 */
		'no_video' => '家长您好，贝乐学科英语守护地球大作战活动还有%s天结束，上传视频通道将于4月22日23:59分关闭！系统显示您家宝贝的视频还没上传呢~您可登录“守护地球”→“上传/修改视频”添加视频。在“贝乐学科英语”官方微信，回复“守护地球”关键词，即可找到入口，期待宝贝的作品出炉~',
	],
];