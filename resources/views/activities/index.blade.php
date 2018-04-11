@extends('layouts.app')

@section('title')
@endsection

@section('header')
@endsection

@section('content')

@include('common.header')

<div class="jm-post jm-post-lg">
    <div class="jm-post-title">
        <p>活动详情</p>
    </div>
    <div class="jm-post-body">
        <div class="jm-post-con jm-post-padding jm-hdjs">
            <img src="{{ resources_domain('images/img_hdjs.png') }}" />
        </div>
    </div>
</div>
<div class="jm-info-btns">
    <a href="{{ route('activities.ranking.index') }}">
        <img src="{{ resources_domain('images/btn_rank_small.png') }}" />
    </a>
    <a href="javascript:;" id="upload">
        <img src="{{ resources_domain('images/btn_upload_small.png') }}" />
    </a>
    <a href="{{ route('home') }}">
        <img src="{{ resources_domain('images/btn_myself.png') }}" />
    </a>
</div>
<div class="jm-layer hidden">
    <div class="jm-layer-bg"></div>
    <div class="jm-layer-dialog">
        <div class="jm-layer-close">
            <img src="{{ resources_domain('images/icon_close_layer.png') }}" />
        </div>
        <div class="jm-layer-body">
            <div class="jm-layer-medal">
                <img src=".{{ resources_domain('images/img_bwzs.png') }}" />
            </div>
            <p></p>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function () {
        $("#upload").on('click', function(){
            @if (is_activity_stop())
                activity_stop();
            @else
                window.location.href = '{{ route('activities.create') }}';
            @endif
        });
    });
</script>
@endsection