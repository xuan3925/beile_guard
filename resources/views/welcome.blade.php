@extends('layouts.app')

@section('title')
@endsection

@section('header')
@endsection

@section('body-css')
class="jm-guard-home"
@endsection

@section('content')

@include('common.header2')

<div class="jm-home-body">
    <!--<img class="jm-gif" src="../images/anim_index.gif" />-->
    <img class="jm-home-text" src="{{ resources_domain('images/img_guard.png') }}" />
    <a href="{{ route('activities.index') }}" class="jm-home-join">
        <img src="{{ resources_domain('images/btn_join.png') }}" />
    </a>
</div>
@endsection

@section('script')
<script>
    $(function () {

    });
</script>
@endsection