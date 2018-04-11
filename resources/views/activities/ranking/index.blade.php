@extends('layouts.app')

@section('title')
@endsection

@section('content')

@include('common.header2')

<header class="jm-rank-header">
    守护地球排行榜
</header>

<div class="jm-rank">
    @foreach ($lists as $k => $list)
    <div class="jm-rank-post">
        <div class="jm-rank-post-con">
            <a href="{{ route('activities.ranking.show', ['id'=>$list->user->id]) }}" class="jm-rank-post-detail">
                <img src="{{ resources_domain('images/btn_info.png') }}" />
            </a>
            <div class="jm-rank-post-title">
                <div class="jm-rank-number">
                    @if ($k < 3)
                    <div class="jm-rank-number-con">
                        <img src="{{ resources_domain('images/icon_rank_'.($k + 1).'.png') }}" />
                    </div>
                    @endif
                    <label>NO.{{ $k + 1 }} {{ $list->user->nickname }}</label>
                </div>
                <p>守护值：{{ $list->guardian_exp }}</p>
                @if (!empty($list->subject))
                <p>守护主题：{{ $list->subject }}</p>
                @endif
            </div>
            <div class="jm-rank-post-body">
                @if (empty($list->video))
                <div class="jm-video jm-video-empty">
                    暂无视频~
                </div>
                @else
                <div class="jm-video" data-video="{{ $list->_video }}">
                    <img src="{{ $list->_video_img }}" class="jm-video-poster"/>
                    <div class="jm-video-play">
                        <img src="{{ resources_domain('images/icon_play.png') }}"/>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('script')
<script>
    $(function () {
    });
</script>
@endsection