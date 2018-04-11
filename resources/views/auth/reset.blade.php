@extends('layouts.app')

@section('title')
@endsection

@section('header')
@endsection

@section('content')

@include('common.header')

<div class="jm-post jm-forget">
    <div class="jm-post-title">
        <p>密码找回</p>
    </div>
    <div class="jm-post-body">
        <div class="jm-post-con">
            <div class="jm-form">
                <div class="jm-form-group">
                    <input type="number" class="jm-input" size="11" name="phone" placeholder="请输入手机号码"/>
                </div>
                <div class="jm-form-group jm-form-rcode">
                    <input type="number" class="jm-input" name="token" placeholder="请输入验证码"/>
                    <a href="javascript:;" class="jm-input-addon" id="getCode">获取验证码</a>
                </div>
                <div class="jm-form-group">
                    <input type="password" class="jm-input" name="password" placeholder="请输入新密码（6-16位）"/>
                </div>
                <div class="jm-form-btns jm-form-btn">
                    <a href="javascript:;" id="submit">
                        <img src="{{ resources_domain('images/btn_done.png') }}" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(function () {

    $('body').off('click', '#getCode:not(.disabled)').on('click', '#getCode:not(.disabled)', function () {
        var phone = $('input[name=phone]').val();
        if (phone == "") {
            jmMsg("请输入正确的手机号码");
            return false;
        } else if (!checkPhone(phone)) {
            jmMsg("请输入正确的手机号码");
            return false;
        } else {
            jmAjax({
                url: "{{ route('password.phone') }}",
                type: "POST",
                data: {phone: phone},
                success: function (data) {
                    var $obj = $('#getCode');
                    $obj.addClass('disabled');
                    $obj.text(10 + "秒");
                    countDown(10, function (s) {
                        $obj.text(s + "秒");
                    }, function () {
                        $obj.text("获取短信验证码");
                        $obj.removeClass('disabled');
                    });
                }
            });
        }
    });

    $('#submit').on('click', function () {
        var data = {
            phone : $('input[name=phone]').val(),
            password : $('input[name=password]').val(),
            token : $('input[name=token]').val()
        };
        if (data.phone == "") {
            jmMsg("请输入正确的手机号码");
            return false;
        } else if (!checkPhone(data.phone)) {
            jmMsg("请输入正确的手机号码");
            return false;
        } else if (data.token == "") {
            jmMsg("请输入验证码");
            return false;
        } else if (data.password == "") {
            jmMsg("请输入新密码");
            return false;
        } else if (data.password.length < 6 || data.password.length > 16) {
            jmMsg("请设置6-16位的密码");
            return false;
        } else {
            jmAjax({
                url: "{{ route('password.reset') }}",
                type: "POST",
                data: data,
                success: function (data) {
                    window.location.href = '{{ route('login').$referer_path }}';
                }
            });
        }
    });

});

</script>
@endsection