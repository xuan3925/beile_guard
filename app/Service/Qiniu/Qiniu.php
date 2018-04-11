<?php 
/**
  * 七牛
  * @author xueyu
  */ 

namespace App\Service\Qiniu;

use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;
use Qiniu\Processing\PersistentFop;
use Qiniu\Auth;

class Qiniu
{

    // 认证
    public $auth;
    public $bucket;

    public function __construct()
    {
        set_time_limit(0);
        $access = config('cdn.qiniu_accesskey');
        $secret = config('cdn.qiniu_secretkey');

        $this->auth   = new Auth($access, $secret);
        $this->bucket = config('cdn.qiniu_bucket');
    }


    /**
     * 获取upload token
     * @author xueyu
     */
    public function getUpToken()
    {
        return $this->auth->uploadToken($this->bucket);
    }

}