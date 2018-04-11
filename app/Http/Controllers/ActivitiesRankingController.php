<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\GuardianEarthRepository;

class ActivitiesRankingController extends Controller
{

    protected $user;
    protected $guardian_earth;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GuardianEarthRepository $guardian_earth, UserRepository $user)
    {
        // $this->middleware('auth');
        $this->guardian_earth = $guardian_earth;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = $this->guardian_earth->userRankingList();
        return view('activities.ranking.index', compact('lists'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = $id;
        // 活动
        $activity = $this->guardian_earth->byId($user_id);
        $activity->_video = cdn_domain($activity->video);
        $activity->_video_img = $this->guardian_earth->videoImg($activity->_video);
        $activity->ranking = $this->guardian_earth->userRanking($user_id, $activity->guardian_exp);
        
        // 用户成就
        $user_achievements = $this->user->guardianEarthAachievements($user_id);

        // 用户
        $user = $this->user->byId($user_id);

        return view('activities.ranking.show', compact('activity', 'user_achievements', 'user'));
    }

}
