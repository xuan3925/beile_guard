<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>贝乐学科英语</title>
        <link href="{{ resources_domain('css/style.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ resources_domain('css/weui.min.css') }}" rel="stylesheet" type="text/css">       
        <script type="text/javascript"> 
            window.Laravel = <?php echo json_encode([
                'cdn_domain' => config('cdn.cdn_domain'),
            ]); ?>;
        </script>
    </head>
    <body @yield('body-css')>
    
        <div class="jm-portrait">
        @yield('content')
        </div>
        <div class="jm-landscape">
            请竖屏
        </div>
        <script src="{{ resources_domain('js/zepto.js') }}"></script>
        <script src="{{ resources_domain('js/flexible.js') }}"></script>
        <script src="{{ resources_domain('js/weui.js') }}"></script>
        <script src="{{ resources_domain('js/base.js') }}"></script>
        @yield('script')
        
        @include('common.wechat')

        <script type="text/javascript"> 
            // 对浏览器的UserAgent进行正则匹配，不含有微信独有标识的则为其他浏览器  
            var ua = navigator.userAgent.toLowerCase();
            var isWeixin = ua.indexOf('micromessenger') != -1;
            var isAndroid = ua.indexOf('android') != -1;
            var isIos = (ua.indexOf('iphone') != -1) || (ua.indexOf('ipad') != -1);
            if (!isWeixin) {
                document.head.innerHTML = '<title>抱歉，出错了</title><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0"><link rel="stylesheet" type="text/css" href="https://res.wx.qq.com/open/libs/weui/0.4.1/weui.css">';
                document.body.innerHTML = '<div class="weui_msg"><div class="weui_icon_area"><i class="weui_icon_info weui_icon_msg"></i></div><div class="weui_text_area"><h4 class="weui_msg_title">请在微信客户端打开链接</h4></div></div>';
            } 
        </script>
    </body>
</html>