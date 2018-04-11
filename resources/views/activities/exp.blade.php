@extends('layouts.app')

@section('title')
@endsection

@section('body-css')
<?php 
    if (!$condition)
    {
        echo 'class="jm-scene-empty"';
    }
    else
    {
        $index = rand(1, 3);
        $index = $index % 3;
        $class = [
            'jm-scene-forest', 'jm-scene-beach', 'jm-scene-park'
        ];
        echo "class=\"{$class[$index]}\"";
    }
 ?>
@endsection

@section('content')

@include('common.header2')

@if ($condition)
<div class="jm-garbage jm-garbage-apple">
    <img src="{{ resources_domain('images/img_garbage_apple.png') }}" />
</div>
<div class="jm-garbage jm-garbage-box">
    <img src="{{ resources_domain('images/img_garbage_box.png') }}" />
</div>
<div class="jm-garbage jm-garbage-bottle">
    <img src="{{ resources_domain('images/img_garbage_bottle.png') }}" />
</div>
<div class="jm-garbage jm-garbage-cans">
    <img src="{{ resources_domain('images/img_garbage_cans.png') }}" />
</div>
<div class="jm-garbage jm-garbage-paper">
    <img src="{{ resources_domain('images/img_garbage_paper.png') }}" />
</div>
@endif

<div class="jm-scene-trash">
    <img src="{{ resources_domain('images/icon_trash.png') }}" />
</div>
@endsection

@section('script')
<script>
    $(function () {
        @if ($condition)
        $('.jm-garbage').on('click', function () {
            $(this).addClass('jm-garbage-done');
            if ($('.jm-garbage').length == $('.jm-garbage-done').length) {
                jmAjax({
                    url: "{{ route('activities.guard.addexp', ['id'=>$activity->user_id]) }}",
                    type: "POST",
                    success: function (data) {
                        setTimeout(function () {
                            @if (Auth::check() && Auth::user()->id == $activity->user_id) 
                            jmAlert('增加了1000守护值',{title:'您已成功守护地球'});
                            @else
                            jmAlert('为守护者增加了1000守护值',{title:'您已成功守护地球'});
                            @endif
                        }, 500);
                    }
                });
                
            }
        });
        @endif
    });
</script>
@endsection