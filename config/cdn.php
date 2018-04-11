<?php 
/**
 * cdn配置
 */

return [
	
	'qiniu_bucket' => env('QINIU_BUCKET'),

    'qiniu_accesskey' => env('QINIU_ACCESSKEY'),
    
    'qiniu_secretkey' => env('QINIU_SECRETKEY'),

    /**
     * 用户上传cdn
     */
    'cdn_domain' => env('CDN_DOMAIN', '/'),

    /**
     * css/js cdn url
     */
    'cdn_resources_domain' => env('CDN_RESOURCES_DOMAIN', '/'),

    /**
	 * css/js资源版本号
	 */
    'cdn_resources_version' => env('CDN_RESOURCES_VERSION', '1.0'),

];