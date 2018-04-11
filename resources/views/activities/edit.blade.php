@extends('layouts.app')

@section('title')
@endsection

@section('header')
@endsection

@section('content')

@include('common.header')

<div class="jm-post jm-post-lg">
    <div class="jm-post-title">
        <p>上传视频</p>
    </div>
    <div class="jm-post-body">
        <div class="jm-post-con">
            <div class="jm-upload-video">
                <input type="hidden" name="video" value="{{ $data->video }}" />
                <div class="jm-video {{ empty($data->video) ? 'hidden' : '' }}">
                    <img src="{{ resources_domain('images/icon_close.png') }}" class="jm-video-close" />
                    <img src="{{ $data->_video_img }}" class="jm-video-poster"/>
                    <!-- <a href="#" class="jm-video-play">
                        <img src="{{ resources_domain('images/icon_play.png') }}"/>
                    </a> -->
                </div>
                <div class="jm-video-btn {{ empty($data->video) ? '' : 'hidden' }}">
                    <img src="{{ resources_domain('images/btn_upload.png') }}" id="uploadTrigger"/>
                </div>
                <div class="jm-video-info">
                    <p>1、录制横版视频，大小不超过100MB<p>
                    <p>2、视频总长度控制在3分钟以内<p>
                    <p>3、视频格式：MP4或者MOV<p>
                    <p>4、录制视频时建议选择光线好的地方，大声说出你的保护宣言“Save our home! Save our lives!”<p>
                    <p>5、作品一经上传即默认为视频内容及肖像可做活动宣传使用<p>
                </div>
            </div>
        </div>
    </div>
    <div class="jm-post-body jm-post-notitle">
        <img src="{{ resources_domain('images/img_connector.png') }}" class="jm-post-connect" />
        <div class="jm-post-con">
            <div class="jm-form">
                <div class="jm-form-group">
                    <input type="text" class="jm-input" name="subject" value="{{ $data->subject }}" maxlength="15" placeholder="Save our home（请输入守护主题）"/>
                </div>
                <div class="jm-form-group">
                    <textarea class="jm-input jm-video-textarea" name="content" maxlength="150" placeholder="地球是我们人类的家园，保护地球就是保护我们人类自己，让我们从从一点一滴做起，为地球贡献自己的力量，守护我们共同的家园！（请输入守护故事）">{{ $data->content }}</textarea>
                </div>
                <div class="jm-form-btns jm-form-btn">
                    <a href="javascript:;" id="submit">
                        <img src="{{ resources_domain('images/btn_sure.png') }}" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="weui-cells weui-cells_form hidden" id="uploader">
    <div class="weui-cell">
        <div class="weui-cell__bd">
            <div class="weui-uploader">
                <div class="weui-uploader__hd">
                    <p class="weui-uploader__title">图片上传</p>
                    <div class="weui-uploader__info"><span id="uploadCount">0</span>/5</div>
                </div>
                <div class="weui-uploader__bd">
                    <ul class="weui-uploader__files" id="uploaderFiles"></ul>
                    <div class="weui-uploader__input-box">
                        <input id="uploaderInput" class="weui-uploader__input" type="file" accept="video/*" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function(){
        var _loading;

        function createFilePath(suffix) {
            var _now = new Date();
            return ('upload/' + _now.toLocaleString().split(" ")[0] + '/' + _now.getTime()+ '_'+ Math.random().toString(36).substr(7) + '.' + suffix);
        }

        $('.jm-video-close').on('click', function () {
            $('.jm-video').addClass('hidden');
            $('.jm-video-btn').removeClass('hidden');
            $('.jm-video-poster').attr('src', '');
            $('input[name=video]').val("");
        });

        $('#uploadTrigger').click(function () {
            $('#uploaderInput').trigger('click');
        });

        var _qiniuToken = '{!! $token !!}';

        weui.uploader('#uploader', {
            url: 'http://up.qiniu.com',
            auto: true,
            type: 'file',
            fileVal: 'file',
            compress: false,
            onBeforeQueued: function (files) {
                console.log('before');
//                        if (this.size > 10 * 1024 * 1024) {
//                            weui.alert('请上传不超过10M的图片');
//                            return false;
//                        }
            },
            onQueued: function () {
                console.log(this);
            },
            onBeforeSend: function (data, headers) {
                _loading = weui.loading('数据加载中', {
                    className: "jm-weui-dialog"
                });
                var _key = createFilePath(data.name.split('.')[1]);
                console.log(_key);
                $.extend(data, {token: _qiniuToken});
                $.extend(data, {key: _key});
                // $.extend(data, { test: 1 }); // 可以扩展此对象来控制上传参数
                // $.extend(headers, { Origin: 'http://127.0.0.1' }); // 可以扩展此对象来控制上传头部

                // return false; // 阻止文件上传
            },
            onProgress: function (procent) {
                console.log('progress');
                console.log(this, procent);
            },
            onSuccess: function (ret) {
                _loading.hide();
                var _url = Laravel.cdn_domain + ret.key;
                $('.jm-video').removeClass('hidden');
                $('.jm-video-btn').addClass('hidden');
                $('.jm-video-poster').attr('src', _url + "?vframe/jpg/offset/0|imageView2/1/w/683/h/364");
                $('input[name=video]').val(ret.key);
            },
            onError: function (err) {
                _loading.hide();
                console.log('error');
                console.log(this, err);
            }
        });

        $('#submit').on('click', function () {
            var obj = {
                video: $('input[name=video]').val(),
                subject: $('input[name=subject]').val(),
                content: $('textarea[name=content]').val()
            };

            if (obj.subject == "")
                obj.subject = 'Save our home';

            if (obj.content == '')
                obj.content = '地球是我们人类的家园，保护地球就是保护我们人类自己，让我们从从一点一滴做起，为地球贡献自己的力量，守护我们共同的家园！';

            if (obj.subject == "") {
                jmMsg("请填写守护主题");
                return false;
            } else if (obj.content == "") {
                jmMsg("请填写守护故事");
                return false;
            } else {
                jmAjax({
                    url: "{{ route('activities.store') }}",
                    type: "POST",
                    data: obj,
                    success: function (data) {
                        window.location.href = '{{ route('home') }}';
                    }
                });
            }
        });
    });
</script>
@endsection