<?php

namespace App\Console\Cdn;

use Illuminate\Console\Command;

class Resource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:resource {folder?} {file?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量上传resource文件';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->resource_qiniu = new Qiniu;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->_handle();
            exit('success');
        } catch (Exception $e) {
            exit('fail, please try again!');
        }
    }

    public function _handle()
    {

        $folder = $this->argument('folder') ? '/'.$this->argument('folder') : '';

        $path = base_path('public/resources'.$folder);

        $file = $this->argument('file') ? $path.'/'.$this->argument('file') : '';

        // 文件夹是否存在
        if (false === is_dir($path))
            exit('dir is not found!');
        
        // 文件是否存在
        if ($file && false === is_file($file))
            exit('file is not found!');

        if ($file)
            $files = array($file);  // 如果是单个文件，则定义成一维数组
        else
            $files = $this->getfiles($path); // 如果是文件夹，则获取文件夹下所有文件

        echo count($files).' files'.PHP_EOL;

        foreach ($files as $k => $val) 
        {
            // 上传到七牛后的文件名
            $file = str_replace($path, "guard{$folder}", $val);

            // 文件是否存在
            $check_file = $this->resource_qiniu->file_exists($file);

            // 如果存在则删除
            if ($check_file)
                $this->resource_qiniu->delete($file);
            
            // 上传新文件
            $res = $this->resource_qiniu->upload($file, $val);
            if (false === $res)
                throw new \Exception("上传文件失败", 1);

            echo ($k + 1).' success'.PHP_EOL;
        }

        return true; 
    }


    /**
     * 获取文件夹下所有文件
     * @param $path 文件夹路径
     * @author ning
     */
    public function getfiles($path)
    { 
        static $data = array();
        foreach(scandir($path) as $afile)
        {
            if($afile=='.'||$afile=='..') continue; 
            if(is_dir($path.'/'.$afile)) 
            { 
                $this->getfiles($path.'/'.$afile); 
            } else { 
                $data[] = $path.'/'.$afile;
            } 

        } 
        return $data;
    }
}
