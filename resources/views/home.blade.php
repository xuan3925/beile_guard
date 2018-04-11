@extends('layouts.app')

@section('title')
@endsection

@section('header')
<a href="{{ route('logout') }}" class="jm-btn-logout"></a>
<a href="/" class="jm-btn-home"></a>
@endsection

@section('content')

@include('common.header')

<div class="jm-post jm-post-lg">
    <div class="jm-post-title">
        <p>我的守护</p>
    </div>
    <div class="jm-post-body">
        <div class="jm-post-con">
            <div class="jm-user-info">
                <div class="jm-user-avatar">
                    <img src="{{ resources_domain('images/icon_user_avatar.png') }}" />
                </div>
                <div class="jm-user-name">
                    <label>{{ Auth::user()->nickname }}</label>
                </div>
                <div class="jm-user-rank">
                    <div class="jm-user-imgtext">
                        <img src="{{ resources_domain('images/icon_rank_number.png') }}" />
                        <label>当前排名 <span id="activity-ranking">{{ $activity->ranking }}</span></label>
                    </div>
                    <div class="jm-user-imgtext">
                        <img src="{{ resources_domain('images/icon_love.png') }}" />
                        <label>已获得守护值 <span id="activity-guardian-exp">{{ $activity->guardian_exp }}</span></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="jm-post-body jm-post-notitle">
        <div class="jm-post-con jm-post-padding">
            <div class="jm-title">
                守护故事
            </div>
            <div class="jm-guard-info">
                @if (!empty($activity->video))
                <!-- 有视频 -->
                <div class="jm-video" data-video="{{ $activity->_video }}">
                    <img src="{{ $activity->_video_img }}" class="jm-video-poster"/>
                    <div class="jm-video-play">
                        <img src="{{ resources_domain('images/icon_play.png') }}" />
                    </div>
                </div>
                @else
                <!--无视频-->
                <a href="{{ route('activities.create') }}" class="jm-video jm-video-empty jm-video-empty-myself">
                    <img src="{{ resources_domain('images/btn_upload_lg.png') }}" />
                </a>
                @endif
                <a href="javascript:;" class="jm-guard-more">
                    <img src="{{ resources_domain('images/icon_more.png') }}" />
                </a>
                <div class="jm-guard-story">
                    <p>守护主题：</p>
                    <p>{{ $activity->subject }}</p>
                    <p>守护故事：</p>
                    <p>{!! nl2br($activity->content) !!}</p>
                </div>
            </div>
        </div>
    </div>
    @include('activities.common.achievements')
    <div class="jm-myself-btns">
        <a href="{{ route('activities.ranking.index') }}">
            <img src="{{ resources_domain('images/btn_rank.png') }}" />
        </a>
        <a href="javascript:;" class="btn-check-guard">
            <img src="{{ resources_domain('images/btn_sh.png') }}" />
        </a>
    </div>
</div>
<div class="jm-layer hidden">
    <div class="jm-layer-bg"></div>
    <div class="jm-layer-dialog">
        <div class="jm-layer-close">
            <img src="{{ resources_domain('images/icon_close_layer.png') }}" />
        </div>
        <div class="jm-layer-body">
            <div class="jm-layer-medal">
                <img src="{{ resources_domain('images/img_bwzs.png') }}" />
            </div>
            <p></p>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function () {
        $('.jm-guard-more').on('click', function () {
            if ($('.jm-guard-info').hasClass('jm-open')) {
                $('.jm-guard-info').removeClass('jm-open');
            } else {
                $('.jm-guard-info').addClass('jm-open');
            }
        });

        $('.btn-check-guard').on('click', function () {
            @if (is_activity_stop())
                activity_stop();
            @else
            jmAjax({
                url: "{{ route('activities.guard.check', ['id'=>$activity->user_id]) }}",
                type: "POST",
                alert: true,
                success: function (data) {
                    window.location.href = '{{ route('activities.guard.show', ['id'=>$activity->user_id]) }}';
                }, 
                error : function(jqXHR, textStatus, errorThrown) {
                    var http_status = jqXHR.status;
                    if (http_status != '422') {
                        jmAlert('服务器异常');
                        return false;
                    }

                    var response = JSON.parse(jqXHR.response);
                    for (var i in response.errors) {
                        if (i == 'seconds') {
                            var seconds = response.errors[i]['0'];
                            jmAlert("距离下次守护还剩 " + formatTime(seconds),{action:function(){
                                clearInterval(_count_down);
                            }},function(){
                                countDown(seconds, function(s){
                                    $('.weui-dialog__bd').text("距离下次守护还剩 " + formatTime(s));
                                },function(){
                                    location.href = "{{ route('activities.guard.show', ['id'=>$activity->user_id]) }}";
                                });
                            });
                        } else {
                            jmAlert(response.errors[i]['0']);
                        }
                        break;
                    }
                }
            });
            @endif
        });
    });
</script>
@endsection