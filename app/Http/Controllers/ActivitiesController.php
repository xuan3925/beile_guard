<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Service\Qiniu\Qiniu;
use App\Events\GuardianShareEvents;
use App\Http\Requests\ActivitiesRequest;
use App\Repositories\GuardianEarthRepository;

class ActivitiesController extends Controller
{
    protected $guardian_earth;

    public function __construct(GuardianEarthRepository $guardian_earth)
    {
        $this->middleware('auth', ['except' => ['index']]);
        $this->guardian_earth = $guardian_earth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('activities.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Auth::user()->id;
        $data = $this->guardian_earth->byId($id);
        $data->_video = cdn_domain($data->video);
        $data->_video_img = $this->guardian_earth->videoImg($data->_video);
        $token = with(new Qiniu)->getUpToken();
        return view('activities.edit', compact('token', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivitiesRequest $request)
    {
        $id = Auth::user()->id;
        $activity = $this->guardian_earth->byId($id);
        $attribute = [
            'subject' => $request->input('subject'),
            'content' => $request->input('content'),
            'video'   => $request->input('video', ''),
        ];
        $this->guardian_earth->update($activity, $attribute);
        return [];
    }

    /**
     * 分享
     * @author xueyu
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function share(Request $request)
    {
        $user_id = Auth::user()->id;
        event(new GuardianShareEvents($user_id));

        $activity = $this->guardian_earth->byId($user_id);
        $activity->ranking = $this->guardian_earth->userRanking($user_id, $activity->guardian_exp);
        return compact('activity');
    }
}
