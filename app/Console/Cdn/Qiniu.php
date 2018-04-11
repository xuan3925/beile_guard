<?php 
/**
  * 七牛 仅上传resource文件用
  * @author xueyu
  */ 

namespace App\Console\Cdn;

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
        $this->bucket = 'resource-web';
    }


    /**
     * 检查文件是否存在
     * @author xueyu
     * @param  $file 七牛file
     */
    public function file_exists($file)
    {
        $qiniu = new BucketManager($this->auth);
        list($ret, $err) = $qiniu->stat($this->bucket, $file);
        if ($err !== null)
            return false;

        return true;
    }



    /**
     * 删除文件
     * @author xueyu
     * @param  $file 七牛file
     */
    public function delete($file)
    {
        $bucket = config('config.qiniu_bucket');
        $qiniu = new BucketManager($this->auth);
        $err = $qiniu->delete($this->bucket, $file);
        if ($err !== null)
            return false;

        return true;
    }



    /**
     * 上传文件
     * @author ning
     * @param  $filePath 要上传文件的本地路径
     * @param  $file     上传到七牛后保存的文件名
     */
    public function upload($file, $filePath)
    {
        // 生成上传 Token
        $token = $this->auth->uploadToken($this->bucket);

        // 初始化 UploadManager 对象
        $uploadMgr = new UploadManager();

        // 文件上传
        list($ret, $err) = $uploadMgr->putFile($token, $file, $filePath);
        if (empty($ret['hash']) || empty($ret['key']))
            return false;

        return true;
    }

}
