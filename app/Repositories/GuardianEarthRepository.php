<?php
/**
 * 守护地球活动
 * @author xueyu
 */

namespace App\Repositories;

use App\Models\GuardianEarth;

class GuardianEarthRepository
{

    /**
     * 截取视频第一帧
     * @author xueyu
     */
    const VIDEO_IMG = '?vframe/jpg/offset/0|imageView2/1/w/683/h/364';

    /**
     * [create description]
     * @author xueyu
     * @param array $attributes
     * @return App\Models\GuardianEart
     */
    public function create(array $attributes)
    {
        return GuardianEarth::create($attributes);
    }

    /**
     * [update description]
     * @author xueyu
     * @return App\Models\GuardianEart
     */
    public function update(GuardianEarth $obj, array $attributes)
    {
        foreach ($attributes as $k => $v) 
        {
            $obj->$k = $v;
        }
        $obj->save();
        return $obj;
    }

    /**
     * [byId description]
     * @author xueyu
     * @return App\Models\GuardianEart
     */
    public function byId($id)
    {
        $obj = GuardianEarth::findOrFail($id);
        return $obj;
    }

    /**
     * 获取视频第一帧图片
     * @author xueyu
     */
    public function videoImg($video)
    {
        return empty($video) ? '' : $video . self::VIDEO_IMG;
    }

    /**
     * 用户排名
     * @author xueyu
     */
    public function userRanking($user_id, $guardian_exp)
    {
        $count = GuardianEarth::where('guardian_exp', '>', $guardian_exp)
                              ->orWhere(function($query) use ($user_id, $guardian_exp){
                                  $query->where('guardian_exp', '=', $guardian_exp)
                                        ->where('user_id', '<', $user_id);
                              })
                              ->count();
        return ++$count;
    }


    /**
     * 用户排名列表
     * @author xueyu
     */
    public function userRankingList()
    {
        $lists = GuardianEarth::orderBy('guardian_exp', 'desc')
                              ->orderBy('user_id', 'asc')
                              ->with('user')
                              ->take(50)
                              ->get();
        return $lists->map(function($list) {
            $list->_video = cdn_domain($list->video);
            $list->_video_img = $this->videoImg($list->_video);
            return $list;
        });
    }
}